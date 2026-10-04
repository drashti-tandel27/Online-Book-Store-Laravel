<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display all reviews
     */
    public function index()
    {
        $reviews = Review::with(['user', 'book'])
                        ->latest()
                        ->paginate(10);
        
        $totalReviews = Review::count();
        $averageRating = round(Review::avg('rating'), 1);
        
        // ✅ FIX: Calculate rating distribution correctly
        $ratingDistribution = [
            5 => Review::where('rating', 5)->count(),
            4 => Review::where('rating', 4)->count(),
            3 => Review::where('rating', 3)->count(),
            2 => Review::where('rating', 2)->count(),
            1 => Review::where('rating', 1)->count(),
        ];
        
        $pendingReviews = Review::count(); // You can add status column if needed
        
        // Get unique users who reviewed
        $totalUsersReviewed = Review::distinct('user_id')->count('user_id');
        
        return view('admin.reviews.index', compact(
            'reviews', 
            'totalReviews', 
            'averageRating', 
            'ratingDistribution',
            'pendingReviews',
            'totalUsersReviewed'
        ));
    }

    /**
     * Show a specific review
     */
    public function show($id)
    {
        $review = Review::with(['user', 'book'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Review deleted successfully!');
    }

    /**
     * Get review statistics for dashboard
     */
    public function getStats()
    {
        $totalReviews = Review::count();
        $averageRating = round(Review::avg('rating'), 1);
        $ratingDistribution = [
            5 => Review::where('rating', 5)->count(),
            4 => Review::where('rating', 4)->count(),
            3 => Review::where('rating', 3)->count(),
            2 => Review::where('rating', 2)->count(),
            1 => Review::where('rating', 1)->count(),
        ];
        
        $recentReviews = Review::with(['user', 'book'])
                              ->latest()
                              ->take(5)
                              ->get();
        
        return compact('totalReviews', 'averageRating', 'ratingDistribution', 'recentReviews');
    }
}