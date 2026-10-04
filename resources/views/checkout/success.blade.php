@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body py-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold mb-3">Thank You for Your Order!</h2>
                    <p class="lead text-muted mb-4">Your order has been placed successfully.</p>
                    
                    <!-- Order Details Card -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Order Details</h5>
                            <p class="mb-2">
                                <strong>Order Number:</strong> 
                                <span class="text-primary">{{ $order->order_number }}</span>
                            </p>
                            <p class="mb-2">
                                <strong>Total Amount:</strong> 
                                <span class="text-success fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                            </p>
                            <p class="mb-2">
                                <strong>Payment Method:</strong> 
                                {{ str_replace('_', ' ', ucfirst($order->payment_method)) }}
                            </p>
                            <p class="mb-0">
                                <strong>Estimated Delivery:</strong> 
                                {{ now()->addDays(5)->format('d M, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Order Items Summary -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ Str::limit($item->book->title, 30) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">
                        <i class="fas fa-envelope me-2"></i>
                        A confirmation email has been sent to <strong>{{ $order->email }}</strong>
                    </p>
                    
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg me-md-2">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        @auth
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-user me-2"></i>View Orders
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Success Animation */
    .success-checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }
    
    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #28a745;
    }
    
    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }
    
    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }
    
    .check-icon::before,
    .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: white;
        transform: rotate(-45deg);
    }
    
    .icon-line {
        height: 5px;
        background-color: #28a745;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    
    .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    
    .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    
    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(40, 167, 69, 0.5);
    }
    
    .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: white;
    }
    
    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 1px;
            top: 19px;
        }
        54% {
            width: 0;
            left: 1px;
            top: 19px;
        }
        70% {
            width: 50px;
            left: -8px;
            top: 37px;
        }
        84% {
            width: 17px;
            left: 21px;
            top: 48px;
        }
        100% {
            width: 25px;
            left: 14px;
            top: 45px;
        }
    }
    
    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 46px;
            top: 54px;
        }
        65% {
            width: 0;
            right: 46px;
            top: 54px;
        }
        84% {
            width: 55px;
            right: 0px;
            top: 35px;
        }
        100% {
            width: 47px;
            right: 8px;
            top: 38px;
        }
    }
</style>
@endpush