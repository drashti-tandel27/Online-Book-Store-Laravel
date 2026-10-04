@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Billing & Shipping Information -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Billing & Shipping Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Full Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name', auth()->user()->name ?? '') }}" 
                                       placeholder="Enter your full name"
                                       required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email ?? '') }}" 
                                       placeholder="Enter your email"
                                       required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                       placeholder="Enter 10-digit mobile number"
                                       pattern="[0-9]{10}"
                                       maxlength="10"
                                       required>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Shipping Address -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">
                                    Shipping Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                          name="shipping_address" 
                                          rows="3"
                                          placeholder="Street address, city, state, pincode"
                                          required>{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                                @error('shipping_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Billing Address (Same as shipping) -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sameAsShipping" checked>
                                    <label class="form-check-label" for="sameAsShipping">
                                        Billing address same as shipping
                                    </label>
                                </div>
                            </div>

                            <!-- Billing Address (hidden by default) -->
                            <div class="col-md-12 mb-3" id="billingAddressDiv" style="display: none;">
                                <label class="form-label fw-bold">
                                    Billing Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                          name="billing_address" 
                                          rows="3"
                                          placeholder="Street address, city, state, pincode">{{ old('billing_address', auth()->user()->address ?? '') }}</textarea>
                                @error('billing_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">
                                    Payment Method <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>
                                        <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                    </option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>
                                        <i class="fas fa-credit-card me-2"></i>Credit/Debit Card
                                    </option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                                        <i class="fas fa-university me-2"></i>Bank Transfer
                                    </option>
                                    <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>
                                        <i class="fas fa-mobile-alt me-2"></i>UPI (Google Pay, PhonePe, Paytm)
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order Notes -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Order Notes (Optional)</label>
                                <textarea class="form-control" 
                                          name="notes" 
                                          rows="2"
                                          placeholder="Any special instructions for your order">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="fas fa-check-circle me-2"></i>Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $item)
                                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(isset($item['image']))
                                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" 
                                                         style="width: 30px; height: 40px; object-fit: cover; border-radius: 3px;" 
                                                         class="me-2">
                                                @endif
                                                <span class="small">{{ Str::limit($item['title'], 15) }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-end">₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <th colspan="2" class="text-end">Subtotal:</th>
                                    <th class="text-end">₹{{ number_format($total, 2) }}</th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">Shipping:</td>
                                    <td class="text-end text-success">Free</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-end">Total:</th>
                                    <th class="text-end text-primary h5">₹{{ number_format($total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-4 text-center">
                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <i class="fas fa-lock text-muted" title="Secure Payment"></i>
                            <i class="fas fa-truck text-muted" title="Free Shipping"></i>
                            <i class="fas fa-undo text-muted" title="Easy Returns"></i>
                        </div>
                        <small class="text-muted d-block">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your information is secure and encrypted
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle billing address visibility
    document.getElementById('sameAsShipping').addEventListener('change', function() {
        const billingDiv = document.getElementById('billingAddressDiv');
        const billingTextarea = document.querySelector('textarea[name="billing_address"]');
        
        if (this.checked) {
            billingDiv.style.display = 'none';
            billingTextarea.removeAttribute('required');
        } else {
            billingDiv.style.display = 'block';
            billingTextarea.setAttribute('required', 'required');
        }
    });

    // Format phone number
    document.querySelector('input[name="phone"]').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
</script>
@endpush