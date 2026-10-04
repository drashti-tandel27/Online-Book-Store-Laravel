@extends('admin.layouts.admin')

@section('title', 'Review Details')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Review Details</h4>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Reviews
        </a>
    </div>

    <div class="row">
        <!-- Review Information -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Review Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Review ID:</th>
                            <td><strong>#{{ $review->id }}</strong></td>
                        </tr>
                        <tr>
                            <th>Rating:</th>
                            <td>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="text-dark ms-2">({{ $review->rating }}/5)</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Review Date:</th>
                            <td>{{ $review->created_at->format('F d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $review->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Book Information -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Book Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Book Title:</th>
                            <td>
                                <a href="{{ route('admin.books.show', $review->book->id) }}" class="text-primary">
                                    {{ $review->book->title }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Author:</th>
                            <td>{{ $review->book->author }}</td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>{{ $review->book->category }}</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>₹{{ number_format($review->book->price, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">User Name:</th>
                            <td><strong>{{ $review->user->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $review->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Member Since:</th>
                            <td>{{ $review->user->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Review Comment -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Review Comment</h5>
                </div>
                <div class="card-body">
                    <p class="lead mb-0">{{ $review->comment }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Button Section -->
    <div class="text-end">
        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" 
              onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-lg px-5">
                <i class="fas fa-trash me-2"></i>Delete Review
            </button>
        </form>
    </div>
</div>
@endsection