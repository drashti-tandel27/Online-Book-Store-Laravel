<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add book to wishlist
     */
    public function add($bookId)
    {
        $book = Book::findOrFail($bookId);
        
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
                         ->where('book_id', $bookId)
                         ->exists();
        
        if ($exists) {
            return redirect()->back()->with('info', 'Book already in your wishlist!');
        }
        
        Wishlist::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
        ]);
        
        return redirect()->back()->with('success', 'Book added to wishlist!');
    }

    /**
     * Remove book from wishlist
     */
    public function remove($bookId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                           ->where('book_id', $bookId)
                           ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Book removed from wishlist!');
        }
        
        return redirect()->back()->with('error', 'Book not found in wishlist!');
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        Wishlist::where('user_id', Auth::id())->delete();
        return redirect()->route('wishlist.index')->with('success', 'Wishlist cleared!');
    }
}