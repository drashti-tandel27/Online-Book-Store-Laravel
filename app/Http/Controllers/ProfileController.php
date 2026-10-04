<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user orders
        $orders = Order::with('items.book')
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->paginate(5);
        
        // Get user wishlist items
        $wishlistItems = Wishlist::with('book')
                                 ->where('user_id', $user->id)
                                 ->latest()
                                 ->get();
        
        return view('profile.index', compact('user', 'orders', 'wishlistItems'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'address', 'dob'));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }
}