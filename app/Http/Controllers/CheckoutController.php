<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        return view('checkout.index', compact('cart'));
    }

    /**
     * Process the order
     */
    public function process(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9]{10}$/',
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'required|in:cash_on_delivery,card,bank_transfer,upi',
            'notes' => 'nullable|string',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            // Verify stock availability
            $book = Book::find($item['id']);
            if (!$book || $book->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 
                    'Sorry, "' . $item['title'] . '" is not available in the requested quantity.');
            }
            $total += $item['price'] * $item['quantity'];
        }

        // Set billing address same as shipping if not provided
        $billingAddress = $request->billing_address ?? $request->shipping_address;

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $billingAddress,
            'phone' => $request->phone,
            'email' => $request->email,
            'name' => $request->name,
            'notes' => $request->notes,
        ]);

        // Create order items and update stock
        foreach ($cart as $item) {
            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Update book stock
            $book = Book::find($item['id']);
            $book->stock -= $item['quantity'];
            $book->save();
        }

        // Clear the cart
        Session::forget('cart');

        // Redirect to success page
        return redirect()->route('checkout.success', $order->order_number)
                        ->with('success', 'Order placed successfully!');
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                      ->with('items.book')
                      ->firstOrFail();
        
        return view('checkout.success', compact('order'));
    }
}