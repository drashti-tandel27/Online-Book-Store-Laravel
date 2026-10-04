<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();
        
        // ========== SEARCH FUNCTIONALITY ==========
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('author', 'like', '%' . $searchTerm . '%')
                  ->orWhere('publisher', 'like', '%' . $searchTerm . '%')
                  ->orWhere('isbn', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        // ==========================================
        
        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('title', 'asc');
            }
        } else {
            $query->orderBy('title', 'asc');
        }
        
        $books = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        return view('books.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with('reviews.user')->findOrFail($id);
        $relatedBooks = Book::where('category', $book->category)
                            ->where('id', '!=', $book->id)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();
        
        return view('books.show', compact('book', 'relatedBooks'));
    }
}