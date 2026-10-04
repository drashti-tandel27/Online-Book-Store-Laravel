@extends('layouts.app')

@section('title', request('search') ? 'Search: ' . request('search') : 'Books')

@section('content')
<div class="container py-4">
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
        <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Categories</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('books.index') }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('category') && !request('search') ? 'active' : '' }}">
                        <span><i class="fas fa-book me-2"></i>All Books</span>
                        <span class="badge bg-primary rounded-pill">{{ \App\Models\Book::count() }}</span>
                    </a>
                    
                    @foreach($categories as $category)
                        <a href="{{ route('books.index', ['category' => $category->name]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('category') == $category->name ? 'active' : '' }}">
                            <span><i class="fas fa-tag me-2"></i>{{ $category->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $category->books()->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Today's Deal Card -->
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-fire fa-3x mb-3"></i>
                    <h5>Today's Deal</h5>
                    <p class="small">Up to 50% off on selected books</p>
                    <a href="{{ route('books.index', ['sort' => 'deal']) }}" class="btn btn-light btn-sm">Shop Now</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Header with Search Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>
                        @if(request('category'))
                            {{ request('category') }} Books
                        @elseif(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            All Books
                        @endif
                    </h2>
                    @if(request('search'))
                        <p class="text-muted small">
                            <a href="{{ route('books.index') }}" class="text-primary">Clear search</a>
                        </p>
                    @endif
                </div>
                <p class="text-muted mb-0">
                    Showing {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} 
                    of {{ $books->total() }} results
                </p>
            </div>

            <!-- Sort Options -->
            <div class="d-flex justify-content-end mb-4">
                <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.href = this.value">
                    <option value="{{ route('books.index', array_merge(request()->except('sort'), ['sort' => 'title_asc'])) }}" 
                            {{ request('sort') == 'title_asc' || !request('sort') ? 'selected' : '' }}>
                        Sort by: Title A-Z
                    </option>
                    <option value="{{ route('books.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" 
                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>
                    <option value="{{ route('books.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" 
                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>
                    <option value="{{ route('books.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" 
                            {{ request('sort') == 'newest' ? 'selected' : '' }}>
                        Newest Arrivals
                    </option>
                </select>
            </div>

            <!-- Books Grid -->
            @if($books->count() > 0)
                <div class="row g-4">
                    @foreach($books as $book)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm book-card">
                                <!-- Book Image -->
                                <img src="{{ $book->hasImage() ? $book->image_url : 'https://images.pexels.com/photos/3945659/pexels-photo-3945659.jpeg?auto=compress&cs=tinysrgb&w=300' }}" 
                                     class="card-img-top" 
                                     alt="{{ $book->title }}" 
                                     style="height: 200px; width: 100%; object-fit: cover;">
                                
                                <!-- Out of Stock Badge -->
                                @if($book->stock < 1)
                                    <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 m-2 rounded-pill small">
                                        Out of Stock
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ Str::limit($book->title, 25) }}</h6>
                                    <p class="card-text text-muted small">by {{ Str::limit($book->author, 20) }}</p>
                                    
                                    <!-- Rating -->
                                    <div class="mb-2">
                                        @php $rating = $book->average_rating ?? 0; @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rating)
                                                <i class="fas fa-star text-warning small"></i>
                                            @elseif($i - 0.5 <= $rating)
                                                <i class="fas fa-star-half-alt text-warning small"></i>
                                            @else
                                                <i class="far fa-star text-warning small"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted small ms-1">({{ $book->review_count ?? 0 }})</span>
                                    </div>
                                    
                                    <!-- Price & Category -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="h5 fw-bold text-primary mb-0">₹{{ number_format($book->price, 2) }}</span>
                                        <span class="badge bg-info">{{ $book->category }}</span>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white border-0 pb-3">
                                    <div class="d-grid gap-2">
                                        <!-- View Details Button -->
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </a>
                                        
                                        <!-- Add to Cart & Wishlist Buttons Row -->
                                        <div class="d-flex gap-2">
                                            @auth
                                                <!-- Add to Cart Button -->
                                                <form action="{{ route('cart.add', $book->id) }}" method="POST" class="flex-grow-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100 btn-sm" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-cart-plus me-2"></i>{{ $book->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                                    </button>
                                                </form>
                                                
                                                <!-- Wishlist Button -->
                                                <form action="{{ route('wishlist.add', $book->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Add to Wishlist">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Login to Buy Button -->
                                                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-primary w-100 btn-sm">
                                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $books->withQueryString()->links() }}
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h5>No Books Found</h5>
                    @if(request('search'))
                        <p class="text-muted">No results found for "{{ request('search') }}". Try different keywords.</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>View All Books
                        </a>
                    @else
                        <p class="text-muted">No books available in this category.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .book-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    
    .list-group-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
    }
    
    .list-group-item.active i,
    .list-group-item.active .badge {
        color: white !important;
        background-color: rgba(255,255,255,0.2) !important;
    }
    
    .list-group-item {
        transition: all 0.3s;
        border-left: 3px solid transparent;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left-color: #667eea;
    }
    
    .badge {
        font-weight: 500;
        padding: 5px 8px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
    }
    
    .btn-outline-danger {
        transition: all 0.3s;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
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