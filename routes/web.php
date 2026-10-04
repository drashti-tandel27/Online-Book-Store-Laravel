<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{id}', [BookController::class, 'show'])->name('show');
});

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::get('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('clear');
});

// ==================== REVIEW ROUTES ====================
Route::middleware('auth')->post('/reviews/{bookId}', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
// ==================== END REVIEW ROUTES ====================

// Checkout routes
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('success');
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    
    // Category Routes
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Book Routes
    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
    
    // Order Routes
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{order}/payment', [App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('orders.update-payment');
    Route::delete('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Review Routes
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // User Routes
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});
// ==================== END ADMIN ROUTES ====================

// Wishlist Routes
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [App\Http\Controllers\WishlistController::class, 'index'])->name('index');
    Route::post('/add/{bookId}', [App\Http\Controllers\WishlistController::class, 'add'])->name('add');
    Route::get('/remove/{bookId}', [App\Http\Controllers\WishlistController::class, 'remove'])->name('remove');
    Route::get('/clear', [App\Http\Controllers\WishlistController::class, 'clear'])->name('clear');
});
// ==================== END WISHLIST ROUTES ====================

// ==================== MODE SWITCHING ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/enter-user-mode', function() {
        Session::put('user_mode', true);
        return redirect()->route('home');
    })->name('enter.user.mode');
    
    Route::get('/exit-user-mode', function() {
        Session::forget('user_mode');
        return redirect()->route('admin.dashboard');
    })->name('exit.user.mode');
});
// ==================== END MODE SWITCHING ROUTES ====================

// User authentication routes
require __DIR__.'/auth.php';