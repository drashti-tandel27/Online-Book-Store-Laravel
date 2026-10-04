<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Basic Stats
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $averageRating = round(Review::avg('rating'), 1);
        
        // LOW STOCK ITEMS (stock < 10)
        $lowStockBooks = Book::where('stock', '<', 10)->get();
        $lowStockCount = $lowStockBooks->count();
        
        // ORDERS THIS MONTH
        $ordersThisMonth = Order::whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))
                                ->count();
        
        // ORDERS THIS WEEK
        $ordersThisWeek = Order::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        
        // TODAY'S ORDERS
        $ordersToday = Order::whereDate('created_at', today())->count();
        
        // Get recent orders with user details (for table display)
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Get recent reviews
        $recentReviews = Review::with(['user', 'book'])->latest()->take(5)->get();
        
        // Get low stock books list for display
        $lowStockList = Book::where('stock', '<', 10)
                            ->orderBy('stock', 'asc')
                            ->take(5)
                            ->get();
        
        // Get monthly sales total (revenue)
        $monthlyRevenue = Order::whereMonth('created_at', date('m'))
                               ->whereYear('created_at', date('Y'))
                               ->sum('total_amount');
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalOrders',
            'totalUsers',
            'totalReviews',
            'averageRating',
            'lowStockCount',
            'lowStockBooks',
            'lowStockList',
            'ordersThisMonth',
            'ordersThisWeek',
            'ordersToday',
            'recentOrders',
            'recentReviews',
            'monthlyRevenue'
        ));
    }
}