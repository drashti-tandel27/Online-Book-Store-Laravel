@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-4x text-primary mb-3"></i>
                        <h2 class="fw-bold">Create Account</h2>
                        <p class="text-muted">Join PAGEWAVE today</p>
                    </div>
                    
                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Full Name - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter your full name"
                                           required 
                                           autofocus>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 3 characters</small>
                            </div>

                            <!-- Email Address - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Enter your email"
                                           required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">We'll never share your email</small>
                            </div>

                            <!-- Phone Number - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-primary"></i></span>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="Enter 10-digit mobile number"
                                           pattern="[0-9]{10}"
                                           maxlength="10"
                                           required>
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">10-digit mobile number</small>
                            </div>

                            <!-- Date of Birth - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Date of Birth <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar text-primary"></i></span>
                                    <input type="date" 
                                           class="form-control @error('dob') is-invalid @enderror" 
                                           name="dob" 
                                           value="{{ old('dob') }}" 
                                           max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                           required>
                                </div>
                                @error('dob')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">You must be 18+ years old</small>
                            </div>

                            <!-- Address - Required -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-primary"></i></span>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" 
                                              rows="2" 
                                              placeholder="Enter your complete address"
                                              required>{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Street, city, state, pincode</small>
                            </div>

                            <!-- Password - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           id="password"
                                           placeholder="Create a strong password"
                                           required>
                                    <span class="input-group-text bg-light" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="password-requirements mt-2 small">
                                    <div class="text-muted mb-1">Password must contain:</div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <span id="length" class="text-danger"><i class="fas fa-times-circle me-1"></i>8+ characters</span>
                                        </div>
                                        <div class="col-6">
                                            <span id="uppercase" class="text-danger"><i class="fas fa-times-circle me-1"></i>Uppercase</span>
                                        </div>
                                        <div class="col-6">
                                            <span id="lowercase" class="text-danger"><i class="fas fa-times-circle me-1"></i>Lowercase</span>
                                        </div>
                                        <div class="col-6">
                                            <span id="number" class="text-danger"><i class="fas fa-times-circle me-1"></i>Number</span>
                                        </div>
                                        <div class="col-6">
                                            <span id="special" class="text-danger"><i class="fas fa-times-circle me-1"></i>Special (@$!%*?&)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password - Required -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
                                    <input type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           placeholder="Re-enter your password"
                                           required>
                                    <span class="input-group-text bg-light" id="toggleConfirmPassword" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="confirmEyeIcon"></i>
                                    </span>
                                </div>
                                <div id="passwordMatch" class="small mt-1"></div>
                            </div>
                        </div>

                        <!-- Terms and Conditions - Required -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" 
                                   class="form-check-input @error('terms') is-invalid @enderror" 
                                   id="terms" 
                                   name="terms" 
                                   value="1"
                                   {{ old('terms') ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms of Service</a> and 
                                <a href="#" class="text-primary">Privacy Policy</a> <span class="text-danger">*</span>
                            </label>
                            @error('terms')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-3 mb-3" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status" id="submitSpinner"></span>
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Log in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });

    // Confirm password visibility toggle
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('password_confirmation');
    const confirmEyeIcon = document.getElementById('confirmEyeIcon');
    
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        confirmEyeIcon.classList.toggle('fa-eye');
        confirmEyeIcon.classList.toggle('fa-eye-slash');
    });

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        // Check length
        const lengthCheck = document.getElementById('length');
        if (password.length >= 8) {
            lengthCheck.className = 'text-success';
            lengthCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i>8+ characters';
        } else {
            lengthCheck.className = 'text-danger';
            lengthCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i>8+ characters';
        }
        
        // Check uppercase
        const uppercaseCheck = document.getElementById('uppercase');
        if (/[A-Z]/.test(password)) {
            uppercaseCheck.className = 'text-success';
            uppercaseCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i>Uppercase';
        } else {
            uppercaseCheck.className = 'text-danger';
            uppercaseCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i>Uppercase';
        }
        
        // Check lowercase
        const lowercaseCheck = document.getElementById('lowercase');
        if (/[a-z]/.test(password)) {
            lowercaseCheck.className = 'text-success';
            lowercaseCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i>Lowercase';
        } else {
            lowercaseCheck.className = 'text-danger';
            lowercaseCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i>Lowercase';
        }
        
        // Check number
        const numberCheck = document.getElementById('number');
        if (/[0-9]/.test(password)) {
            numberCheck.className = 'text-success';
            numberCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i>Number';
        } else {
            numberCheck.className = 'text-danger';
            numberCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i>Number';
        }
        
        // Check special character
        const specialCheck = document.getElementById('special');
        if (/[@$!%*?&]/.test(password)) {
            specialCheck.className = 'text-success';
            specialCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i>Special';
        } else {
            specialCheck.className = 'text-danger';
            specialCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i>Special';
        }
        
        // Check password match
        checkPasswordMatch();
    });

    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmPasswordInput.value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirm.length === 0) {
            matchDiv.innerHTML = '';
        } else if (password === confirm) {
            matchDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</span>';
        } else {
            matchDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</span>';
        }
    }

    // Phone number validation
    document.querySelector('input[name="phone"]').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // Form submission loading state
    document.getElementById('registerForm').addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitSpinner').classList.remove('d-none');
    });

    // Date of birth validation (18+)
    document.querySelector('input[name="dob"]').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (age < 18 || (age === 18 && monthDiff < 0)) {
            this.setCustomValidity('You must be 18 years or older');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush