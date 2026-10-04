<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        // Check if book is in stock
        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'This book is out of stock!');
        }
        
        $cart = Session::get('cart', []);
        
        // If book already in cart, increase quantity
        if (isset($cart[$id])) {
            // Check if enough stock
            if ($cart[$id]['quantity'] + 1 > $book->stock) {
                return redirect()->back()->with('error', 'Not enough stock available!');
            }
            $cart[$id]['quantity']++;
        } else {
            // Add new item to cart
            $cart[$id] = [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'image' => $book->image,
                'isbn' => $book->isbn,
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Book added to cart successfully!');
    }

    /**
     * Update cart quantities
     */
    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        
        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                if ($quantity > 0) {
                    // Check stock availability
                    $book = Book::find($id);
                    if ($book && $quantity > $book->stock) {
                        return redirect()->route('cart.index')->with('error', 
                            'Only ' . $book->stock . ' copies of "' . $book->title . '" are available!');
                    }
                    $cart[$id]['quantity'] = $quantity;
                } else {
                    unset($cart[$id]);
                }
            }
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}