@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container py-4">
    <div class="bg-primary text-white rounded-3 p-5 mb-4">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Welcome to Book Store</h1>
            <p class="col-md-8 fs-4">Discover thousands of books across various genres. From bestsellers to classics, we have something for every reader.</p>
            <a href="{{ route('books.index') }}" class="btn btn-light btn-lg">Browse Books</a>
        </div>
    </div>

    <h2 class="mb-4">Shop by Category</h2>
    <div class="row mb-5">
        @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <a href="{{ route('books.index', ['category' => $category->name]) }}" class="text-decoration-none">
                    <div class="card h-100 text-center hover-shadow">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <h2 class="mb-4">Featured Books</h2>
    <div class="row">
        @foreach($featuredBooks as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $book->image ?? 'https://via.placeholder.com/300x400' }}" class="card-img-top" alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($book->title, 30) }}</h5>
                        <p class="card-text text-muted">by {{ $book->author }}</p>
                        <p class="card-text">
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
                                ({{ $book->review_count }})
                            </span>
                        </p>
                        <p class="card-text fw-bold text-primary">${{ number_format($book->price, 2) }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="mb-4 mt-5">Latest Additions</h2>
    <div class="row">
        @foreach($latestBooks as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $book->image ?? 'https://via.placeholder.com/300x400' }}" class="card-img-top" alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($book->title, 30) }}</h5>
                        <p class="card-text text-muted">by {{ $book->author }}</p>
                        <p class="card-text fw-bold text-primary">${{ number_format($book->price, 2) }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection