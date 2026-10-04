@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">My Wishlist</h5>
                    @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                        <a href="{{ route('wishlist.clear') }}" class="btn btn-sm btn-outline-danger" 
                           onclick="return confirm('Are you sure you want to clear your wishlist?')">
                            <i class="fas fa-trash me-1"></i>Clear All
                        </a>
                    @endif
                </div>
                <div class="card-body">
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

                    @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                        <div class="row g-4">
                            @foreach($wishlistItems as $item)
                            <div class="col-md-3 col-6">
                                <div class="card h-100 border-0 shadow-sm wishlist-card">
                                    <div class="position-relative">
                                        <img src="{{ $item->book->hasImage() ? $item->book->image_url : 'https://via.placeholder.com/300x400/667eea/ffffff?text=' . urlencode($item->book->title) }}" 
                                             class="card-img-top" alt="{{ $item->book->title }}" 
                                             style="height: 200px; object-fit: cover;">
                                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" 
                                                onclick="window.location.href='{{ route('wishlist.remove', $item->book->id) }}'"
                                                title="Remove from wishlist">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">{{ Str::limit($item->book->title, 20) }}</h6>
                                        <p class="text-muted small mb-2">by {{ Str::limit($item->book->author, 15) }}</p>
                                        <div class="mb-2">
                                            @php $rating = $item->book->average_rating ?? 0; @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating)
                                                    <i class="fas fa-star text-warning small"></i>
                                                @elseif($i - 0.5 <= $rating)
                                                    <i class="fas fa-star-half-alt text-warning small"></i>
                                                @else
                                                    <i class="far fa-star text-warning small"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted small ms-1">({{ $item->book->review_count ?? 0 }})</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary">₹{{ number_format($item->book->price, 2) }}</span>
                                            <a href="{{ route('books.show', $item->book->id) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </div>
                                        <div class="mt-2">
                                            <form action="{{ route('cart.add', $item->book->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-heart fa-5x text-muted"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Your wishlist is empty</h5>
                            <p class="text-muted mb-4">Save your favorite books here</p>
                            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-book-open me-2"></i>Explore Books
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .wishlist-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush