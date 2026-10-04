<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // If admin is logged in, you can show different content
        if (Auth::check() && Auth::user()->is_admin == 1) {
            // Admin viewing home page - maybe show admin stats?
            $totalBooks = Book::count();
            $totalCategories = Category::count();
            
            return view('home', compact('totalBooks', 'totalCategories'));
        }

        // Regular user view
        $featuredBooks = Book::inRandomOrder()->take(8)->get();
        $categories = Category::withCount('books')->get();
        $latestBooks = Book::latest()->take(4)->get();
        
        return view('home', compact('featuredBooks', 'categories', 'latestBooks'));
    }
}