<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        $book = Book::findOrFail($bookId);

        // Check if user already reviewed this book
        $existingReview = Review::where('book_id', $bookId)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this book!');
        }

        Review::create([
            'book_id' => $bookId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }
}