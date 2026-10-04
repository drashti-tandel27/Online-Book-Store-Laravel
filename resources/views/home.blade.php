@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section with Bookshelf Background -->
<section class="hero-section position-relative overflow-hidden">
    <div class="hero-overlay d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInUp">
                        Discover Your Next <span class="text-warning">Great Read</span>
                    </h1>
                    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                        Explore thousands of books across all genres. From bestsellers to hidden gems.
                    </p>
                    <div class="d-flex gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                        <a href="{{ route('books.index') }}" class="btn btn-warning btn-lg px-4 py-3">
                            <i class="fas fa-search me-2"></i>Browse Books
                        </a>
                        <a href="#featured" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-star me-2"></i>Featured
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image-wrapper">
                        <img src="https://images.pexels.com/photos/256455/pexels-photo-256455.jpeg?auto=compress&cs=tinysrgb&w=600" 
                             alt="Books Stack" class="img-fluid rounded-4 shadow">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar with Images -->
<section class="stats-bar py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <!-- Books Stat -->
            <div class="col-md-3 col-6">
                <div class="stat-item p-4">
                    <div class="stat-image mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" 
                             alt="Books" 
                             class="img-fluid"
                             style="width: 60px; height: 60px;">
                    </div>
                    <h3 class="fw-bold mb-1">{{ \App\Models\Book::count() }}+</h3>
                    <p class="text-muted mb-0">Books</p>
                </div>
            </div>
            
            <!-- Categories Stat -->
            <div class="col-md-3 col-6">
                <div class="stat-item p-4">
                    <div class="stat-image mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/977/977498.png" 
                             alt="Categories" 
                             class="img-fluid"
                             style="width: 60px; height: 60px;">
                    </div>
                    <h3 class="fw-bold mb-1">{{ \App\Models\Category::count() }}+</h3>
                    <p class="text-muted mb-0">Categories</p>
                </div>
            </div>
            
            <!-- Readers Stat -->
            <div class="col-md-3 col-6">
                <div class="stat-item p-4">
                    <div class="stat-image mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" 
                             alt="Readers" 
                             class="img-fluid"
                             style="width: 60px; height: 60px;">
                    </div>
                    <h3 class="fw-bold mb-1">{{ \App\Models\User::count() }}+</h3>
                    <p class="text-muted mb-0">Readers</p>
                </div>
            </div>
            
            <!-- Authors Stat -->
            <div class="col-md-3 col-6">
                <div class="stat-item p-4">
                    <div class="stat-image mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                             alt="Authors" 
                             class="img-fluid"
                             style="width: 60px; height: 60px;">
                    </div>
                    <h3 class="fw-bold mb-1">500+</h3>
                    <p class="text-muted mb-0">Authors</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bookshelf Categories Section -->
<section class="bookshelf-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Explore Our Bookshelf</h2>
            <p class="text-muted lead">Browse through our carefully curated categories</p>
        </div>
        
        <div class="row g-4">
            <!-- Fiction Shelf -->
            <div class="col-md-6 col-lg-3">
                <div class="bookshelf-card">
                    <div class="bookshelf-img">
                        <img src="https://images.pexels.com/photos/1907785/pexels-photo-1907785.jpeg?auto=compress&cs=tinysrgb&w=400" 
                             alt="Fiction" class="img-fluid">
                    </div>
                    <div class="bookshelf-content p-3">
                        <h5 class="fw-bold mb-1">Fiction</h5>
                        <p class="small text-muted mb-2">Novels, stories & literature</p>
                        <a href="{{ route('books.index', ['category' => 'Fiction']) }}" class="btn btn-sm btn-outline-primary w-100">
                            Browse <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Non-Fiction Shelf -->
            <div class="col-md-6 col-lg-3">
                <div class="bookshelf-card">
                    <div class="bookshelf-img">
                        <img src="https://images.pexels.com/photos/207662/pexels-photo-207662.jpeg?auto=compress&cs=tinysrgb&w=400" 
                             alt="Non-Fiction" class="img-fluid">
                    </div>
                    <div class="bookshelf-content p-3">
                        <h5 class="fw-bold mb-1">Non-Fiction</h5>
                        <p class="small text-muted mb-2">Biography, history & facts</p>
                        <a href="{{ route('books.index', ['category' => 'Non-Fiction']) }}" class="btn btn-sm btn-outline-primary w-100">
                            Browse <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Science Shelf - NEW IMAGE -->
            <div class="col-md-6 col-lg-3">
                <div class="bookshelf-card">
                    <div class="bookshelf-img">
                        <img src="https://images.pexels.com/photos/247819/pexels-photo-247819.jpeg?auto=compress&cs=tinysrgb&w=400" 
                             alt="Science" class="img-fluid">
                    </div>
                    <div class="bookshelf-content p-3">
                        <h5 class="fw-bold mb-1">Science</h5>
                        <p class="small text-muted mb-2">Physics, chemistry & biology</p>
                        <a href="{{ route('books.index', ['category' => 'Science']) }}" class="btn btn-sm btn-outline-primary w-100">
                            Browse <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Self-Help Shelf -->
            <div class="col-md-6 col-lg-3">
                <div class="bookshelf-card">
                    <div class="bookshelf-img">
                        <img src="https://images.pexels.com/photos/3772510/pexels-photo-3772510.jpeg?auto=compress&cs=tinysrgb&w=400" 
                             alt="Self-Help" class="img-fluid">
                    </div>
                    <div class="bookshelf-content p-3">
                        <h5 class="fw-bold mb-1">Self-Help</h5>
                        <p class="small text-muted mb-2">Personal growth & success</p>
                        <a href="{{ route('books.index', ['category' => 'Self-Help']) }}" class="btn btn-sm btn-outline-primary w-100">
                            Browse <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('books.index') }}" class="btn btn-primary px-5 py-3 rounded-pill">
                View All Categories <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<!-- Featured Books Carousel -->
<section id="featured" class="featured-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Books</h2>
            <p class="text-muted lead">Hand-picked titles you'll love</p>
        </div>
        
        <div class="row g-4">
            @php
                $featuredBooks = \App\Models\Book::inRandomOrder()->take(8)->get();
            @endphp
            @foreach($featuredBooks as $book)
            <div class="col-md-3 col-6">
                <div class="book-card border-0 shadow-sm">
                    <img src="{{ $book->image ?? 'https://images.pexels.com/photos/1544946/pexels-photo-1544946.jpeg?auto=compress&cs=tinysrgb&w=300' }}" 
                         class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
                    <div class="p-3">
                        <h6 class="fw-bold mb-1">{{ Str::limit($book->title, 20) }}</h6>
                        <p class="small text-muted mb-2">{{ $book->author }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">₹{{ number_format($book->price, 2) }}</span>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Newsletter -->
<section class="newsletter-section py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-6 fw-bold mb-3">Join Our Reading Community</h2>
        <p class="lead mb-4">Get book recommendations and exclusive offers</p>
        <form class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="email" class="form-control form-control-lg" placeholder="Your email">
                    <button class="btn btn-warning btn-lg" type="submit">Subscribe</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        min-height: 600px;
    }
    
    .hero-overlay {
        min-height: 600px;
    }
    
    /* Bookshelf Cards */
    .bookshelf-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .bookshelf-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .bookshelf-img {
        height: 180px;
        overflow: hidden;
    }
    
    .bookshelf-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .bookshelf-card:hover .bookshelf-img img {
        transform: scale(1.1);
    }
    
    /* Book Cards */
    .book-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s;
        height: 100%;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    
        /* Stats Bar with Images */
.stats-bar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.stat-item {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
}

.stat-image img {
    filter: drop-shadow(0 5px 10px rgba(102, 126, 234, 0.3));
    transition: transform 0.3s ease;
}

.stat-item:hover .stat-image img {
    transform: scale(1.1);
}

.stat-item h3 {
    font-size: 2.2rem;
    color: #333;
}

.stat-item p {
    font-size: 1rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-item {
        padding: 20px !important;
    }
    
    .stat-item h3 {
        font-size: 1.8rem;
    }
    
    .stat-image img {
        width: 50px !important;
        height: 50px !important;
    }
}
</style>
@endpush