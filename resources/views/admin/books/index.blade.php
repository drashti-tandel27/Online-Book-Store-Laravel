@extends('admin.layouts.admin')

@section('title', 'Manage Books')

@section('content')
<div class="container-fluid px-0">
    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Manage Books</h4>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Book
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Books Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 60px">ID</th>
                            <th style="width: 80px">Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Price (₹)</th>
                            <th>Stock</th>
                            <th>Rating</th>
                            <th style="width: 120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>
                                @if($book->image)
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" 
                                         style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div style="width: 50px; height: 70px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($book->title, 40) }}</strong>
                            </td>
                            <td>{{ $book->author }}</td>
                            <td>
                                <span class="badge bg-info">{{ $book->category }}</span>
                            </td>
                            <td>
                                <strong>₹{{ number_format($book->price, 2) }}</strong>
                            </td>
                            <td>
                                @if($book->stock > 10)
                                    <span class="badge bg-success">{{ $book->stock }} in stock</span>
                                @elseif($book->stock > 0)
                                    <span class="badge bg-warning">Only {{ $book->stock }} left</span>
                                @else
                                    <span class="badge bg-danger">Out of stock</span>
                                @endif
                            </td>
                            <td>
                                @if($book->average_rating > 0)
                                    <div class="d-flex align-items-center">
                                        <span class="text-warning me-1">
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
                                        <span class="text-muted small">({{ $book->review_count }})</span>
                                    </div>
                                @else
                                    <span class="text-muted small">No ratings</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" 
                                                onclick="return confirm('Are you sure you want to delete this book?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                                <h5>No Books Found</h5>
                                <p class="text-muted">Get started by adding your first book.</p>
                                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Book
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($books->hasPages())
            <div class="d-flex justify-content-center p-3 border-top">
                {{ $books->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection