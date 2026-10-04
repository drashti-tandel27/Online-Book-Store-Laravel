@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($cart) > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Book</th>
                            <th>Price (₹)</th>
                            <th>Quantity</th>
                            <th>Total (₹)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($item['image']))
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" 
                                                 style="width: 60px; height: 80px; object-fit: cover; border-radius: 5px;" 
                                                 class="me-3">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 60px; height: 80px; border-radius: 5px;">
                                                <i class="fas fa-book fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $item['title'] }}</h6>
                                            <small class="text-muted">ISBN: {{ $item['isbn'] ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold">₹{{ number_format($item['price'], 2) }}</td>
                                <td style="width: 150px;">
                                    <input type="number" 
                                           name="quantities[{{ $id }}]" 
                                           value="{{ $item['quantity'] }}" 
                                           min="1" 
                                           class="form-control form-control-sm text-center"
                                           style="width: 80px;">
                                </td>
                                <td class="fw-bold text-primary">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                <td>
                                    <a href="{{ route('cart.remove', $id) }}" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Remove this item from cart?')">
                                        <i class="fas fa-trash-alt me-1"></i> Remove
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-primary">₹{{ number_format($total, 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mt-4">
                <div>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <a href="{{ route('cart.clear') }}" 
                       class="btn btn-outline-danger ms-2"
                       onclick="return confirm('Clear all items from cart?')">
                        <i class="fas fa-trash-alt me-2"></i>Clear Cart
                    </a>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning me-2">
                        <i class="fas fa-sync-alt me-2"></i>Update Cart
                    </button>
                    <a href="{{ route('checkout.index') }}" class="btn btn-success">
                        <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                    </a>
                </div>
            </div>
        </form>

        <!-- You Might Also Like Section -->
        <div class="mt-5">
            <h3 class="mb-4">You Might Also Like</h3>
            <div class="row g-4">
                @php
                    $recommendedBooks = \App\Models\Book::inRandomOrder()->take(4)->get();
                @endphp
                @foreach($recommendedBooks as $book)
                <div class="col-md-3 col-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ $book->hasImage() ? $book->image_url : 'https://images.pexels.com/photos/3945659/pexels-photo-3945659.jpeg?auto=compress&cs=tinysrgb&w=300' }}" 
                             class="card-img-top" alt="{{ $book->title }}"
                             style="height: 150px; object-fit: cover;">
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold small">{{ Str::limit($book->title, 20) }}</h6>
                            <p class="text-muted small mb-2">₹{{ number_format($book->price, 2) }}</p>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-5x text-muted"></i>
            </div>
            <h3 class="fw-bold mb-3">Your Cart is Empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added any books to your cart yet.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-book-open me-2"></i>Browse Books
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    
    .table tfoot th {
        font-size: 1.1rem;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    
    @media (max-width: 768px) {
        .d-flex.flex-wrap {
            flex-direction: column;
            gap: 10px !important;
        }
        
        .d-flex.flex-wrap > div {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        
        .btn {
            width: 100%;
            margin: 5px 0 !important;
        }
    }
</style>
@endpush