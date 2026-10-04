@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Book Image -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                @if($book->hasImage())
                    <img src="{{ $book->image_url }}" 
                         class="card-img-top rounded" 
                         alt="{{ $book->title }}" 
                         style="height: 400px; width: 100%; object-fit: cover;">
                @else
                    <img src="https://images.pexels.com/photos/3945659/pexels-photo-3945659.jpeg?auto=compress&cs=tinysrgb&w=600" 
                         class="card-img-top rounded" 
                         alt="{{ $book->title }}" 
                         style="height: 400px; width: 100%; object-fit: cover;">
                @endif
            </div>
        </div>
        
        <!-- Book Info -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h1 class="display-5 fw-bold">{{ $book->title }}</h1>
                <p class="lead text-muted">by {{ $book->author }}</p>
                
                <!-- Rating -->
                <div class="mb-3">
                    <span class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $book->average_rating)
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $book->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <span class="ms-2 text-muted">({{ $book->review_count }} reviews)</span>
                </div>
                
                <!-- Price -->
                <h2 class="text-primary mb-3">₹{{ number_format($book->price, 2) }}</h2>
                
                <!-- Category & Stock -->
                <div class="mb-3">
                    <span class="badge bg-info fs-6 me-2">{{ $book->category }}</span>
                    @if($book->stock > 0)
                        <span class="badge bg-success fs-6">In Stock ({{ $book->stock }} available)</span>
                    @else
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    @endif
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $book->description ?? 'No description available' }}</p>
                </div>
                
                <!-- Book Details Table -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Book Details</h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="text-muted">ISBN:</th>
                                <td>{{ $book->isbn ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Publisher:</th>
                                <td>{{ $book->publisher ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Publication Year:</th>
                                <td>{{ $book->publication_year ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Pages:</th>
                                <td>{{ $book->pages ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Add to Cart & Wishlist Section - UPDATED STEP 8 -->
                <div class="d-flex gap-3">
                    @auth
                        <!-- Add to Cart Button -->
                        <form action="{{ route('cart.add', $book->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus me-2"></i>{{ $book->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        </form>
                        
                        <!-- Wishlist Button -->
                        <form action="{{ route('wishlist.add', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-lg" title="Add to Wishlist">
                                <i class="fas fa-heart"></i> Wishlist
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Customer Reviews</h3>
            
            @auth
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Write a Review</h5>
                        <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="btn-check" required>
                                        <label for="star{{ $i }}" class="btn btn-outline-warning">
                                            <i class="fas fa-star"></i> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Your Review</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            @else
                <p class="alert alert-info">
                    Please <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}">login</a> to write a review.
                </p>
            @endauth

            @forelse($book->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $review->user->name }}</h5>
                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                        </div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="card-text">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">No reviews yet. Be the first to review this book!</p>
            @endforelse
        </div>
    </div>

    <!-- Related Books -->
    @if(isset($relatedBooks) && $relatedBooks->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Books</h3>
                <div class="row">
                    @foreach($relatedBooks as $relatedBook)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ $relatedBook->hasImage() ? $relatedBook->image_url : 'https://images.pexels.com/photos/3945659/pexels-photo-3945659.jpeg?auto=compress&cs=tinysrgb&w=300' }}" 
                                     class="card-img-top" alt="{{ $relatedBook->title }}" 
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($relatedBook->title, 20) }}</h6>
                                    <p class="card-text small text-muted">₹{{ number_format($relatedBook->price, 2) }}</p>
                                    <a href="{{ route('books.show', $relatedBook->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .rating .btn-check:checked + .btn {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    
    .rating .btn {
        margin-right: 5px;
    }
    
    .card {
        border-radius: 10px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-outline-danger {
        transition: all 0.3s;
        border-width: 2px;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }
    
    /* Alert styles */
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }
    
    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
    }
</style>
@endpush