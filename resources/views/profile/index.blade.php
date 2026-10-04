@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="avatar-circle mx-auto mb-3">
                        <span class="initials">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                    </div>
                    <h5 class="fw-bold">{{ Auth::user()->name ?? 'Guest User' }}</h5>
                    <p class="text-muted small">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Profile Navigation -->
            <div class="list-group shadow-sm">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="fas fa-user me-2"></i> Your Account
                </a>
                <a href="#orders" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-shopping-bag me-2"></i> Your Orders
                </a>
                <a href="#wishlist" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-heart me-2"></i> Your Wishlist
                </a>
                <a href="#password" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="fas fa-lock me-2"></i> Change Password
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Your Account Tab -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Your Account</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" value="{{ Auth::user()->dob ?? '' }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="2">{{ Auth::user()->address ?? '' }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Your Orders Tab -->
                <div class="tab-pane fade" id="orders">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Your Orders</h5>
                            <span class="badge bg-primary">{{ $orders->count() ?? 0 }} orders</span>
                        </div>
                        <div class="card-body">
                            @if(isset($orders) && $orders->count() > 0)
                                @foreach($orders as $order)
                                <div class="border rounded p-3 mb-3 order-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <span class="text-muted small">Order #</span>
                                            <p class="fw-bold">{{ $order->order_number }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="text-muted small">Date</span>
                                            <p>{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="text-muted small">Total</span>
                                            <p class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="text-muted small">Status</span>
                                            <p>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge bg-info">Processing</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-primary">Shipped</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderModal{{ $order->id }}">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Details Modal -->
                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Order Details - {{ $order->order_number }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <h6>Order Information</h6>
                                                        <p>
                                                            <strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}<br>
                                                            <strong>Status:</strong> 
                                                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span><br>
                                                            <strong>Payment:</strong> {{ ucfirst($order->payment_status) }}<br>
                                                            <strong>Method:</strong> {{ str_replace('_', ' ', ucfirst($order->payment_method)) }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Shipping Information</h6>
                                                        <p>
                                                            <strong>Name:</strong> {{ $order->name }}<br>
                                                            <strong>Email:</strong> {{ $order->email }}<br>
                                                            <strong>Phone:</strong> {{ $order->phone }}<br>
                                                            <strong>Address:</strong> {{ $order->shipping_address }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <h6>Order Items</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Book</th>
                                                                <th>Price</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->items as $item)
                                                            <tr>
                                                                <td>{{ $item->book->title ?? 'N/A' }}</td>
                                                                <td>₹{{ number_format($item->price, 2) }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3" class="text-end">Total:</th>
                                                                <th>₹{{ number_format($order->total_amount, 2) }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                @if($order->notes)
                                                    <div class="mt-3">
                                                        <h6>Order Notes</h6>
                                                        <p class="text-muted">{{ $order->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $orders->links() }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-shopping-bag fa-5x text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3">No orders yet</h5>
                                    <p class="text-muted mb-4">Start shopping to see your orders here</p>
                                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-book-open me-2"></i>Browse Books
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Your Wishlist Tab - UPDATED -->
                <div class="tab-pane fade" id="wishlist">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Your Wishlist</h5>
                            @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                                <a href="{{ route('wishlist.clear') }}" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Are you sure you want to clear your wishlist?')">
                                    <i class="fas fa-trash me-1"></i>Clear All
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                                <div class="row g-4">
                                    @foreach($wishlistItems as $item)
                                    <div class="col-md-4 col-6">
                                        <div class="card h-100 border-0 shadow-sm wishlist-item">
                                            <div class="position-relative">
                                                <img src="{{ $item->book->hasImage() ? $item->book->image_url : 'https://via.placeholder.com/300x400/667eea/ffffff?text=' . urlencode($item->book->title) }}" 
                                                     class="card-img-top" alt="{{ $item->book->title }}" 
                                                     style="height: 180px; object-fit: cover;">
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

                <!-- Change Password Tab -->
                <div class="tab-pane fade" id="password">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Change Password</h5>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .initials {
        font-size: 32px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .list-group-item {
        border: none;
        padding: 12px 20px;
        transition: all 0.3s;
    }
    
    .list-group-item i {
        width: 20px;
        color: #667eea;
    }
    
    .list-group-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .list-group-item.active i {
        color: white;
    }
    
    .list-group-item:hover {
        background: #f8f9fa;
        padding-left: 25px;
    }
    
    .order-card {
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    
    /* Wishlist Item Styles */
    .wishlist-item {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .wishlist-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    
    .btn-outline-danger {
        border-radius: 25px;
        padding: 10px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }
    
    .tab-pane {
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        border-radius: 15px;
    }
</style>
@endpush