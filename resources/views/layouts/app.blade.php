<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PAGEWAVE.com') - Online Book Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Header Main */
        .header-main {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        /* Logo Styles for PAGEWAVE.com */
        .logo {
            font-size: 28px;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 2px;
            transition: transform 0.3s;
            color: #333;
        }
        
        .logo:hover {
            transform: scale(1.05);
            color: #333;
        }
        
        .logo i {
            color: #667eea;
            margin-right: 8px;
            font-size: 28px;
        }
        
        .logo-page {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-wave {
            color: #333;
            font-weight: 700;
        }
        
        .logo-com {
            color: #999;
            font-size: 16px;
            font-weight: 400;
            margin-left: 2px;
            align-self: flex-end;
        }
        
        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px 20px;
            padding-right: 120px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .search-box button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        
        .header-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-icons a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }
        
        .header-icons a:hover {
            color: #667eea;
        }
        
        .header-icons i {
            font-size: 18px;
        }
        
        .cart-badge {
            position: relative;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #667eea;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
        }
        
        /* Navigation Menu - SIMPLIFIED */
        .nav-menu {
            background: white;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
        }
        
        .nav-menu .container {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        
        .nav-item {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 5px 0;
            position: relative;
            transition: color 0.3s;
        }
        
        .nav-item:hover {
            color: #667eea;
        }
        
        .nav-item.active {
            color: #667eea;
        }
        
        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 2px;
            background: #667eea;
        }
        
        .nav-item i {
            margin-right: 6px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-main .row {
                gap: 15px;
            }
            
            .logo {
                font-size: 22px;
                justify-content: center;
            }
            
            .logo-com {
                font-size: 14px;
            }
            
            .search-box {
                max-width: 100%;
            }
            
            .header-icons {
                justify-content: center;
            }
            
            .nav-menu .container {
                gap: 20px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header Main -->
    <div class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-12">
                    <!-- LOGO: PAGEWAVE.com -->
                    <a href="{{ route('home') }}" class="logo">
                        <i class="fas fa-book-open"></i>
                        <span class="logo-page">PAGE</span> 
                        <span class="logo-wave">WAVE</span>
                        <span class="logo-com">.com</span>
                    </a>
                </div>
                <div class="col-lg-6 col-md-12">
                    <form action="{{ route('books.index') }}" method="GET" class="search-box">
                        <input type="text" name="search" placeholder="Search By Title, Author, Publisher Or ISBN" value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search me-2"></i>Search</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="header-icons">
                        @auth
                            {{-- Admin link - only shown when NOT in user mode --}}
                            @if(Auth::user()->is_admin == 1 && (!session()->has('user_mode') || session('user_mode') == false))
                                <a href="{{ route('admin.dashboard') }}" class="text-danger">
                                    <i class="fas fa-crown"></i>
                                    <span>Admin</span>
                                </a>
                            @endif
                            
                            {{-- User profile link - always shown --}}
                            <a href="{{ route('profile') }}">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                        @else
                            {{-- Guest links --}}
                            <a href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        @endauth
                        
                        {{-- Cart - always shown --}}
                        <a href="{{ route('cart.index') }}" class="cart-badge">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Cart</span>
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="cart-count">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMPLIFIED Navigation Menu -->
    <div class="nav-menu">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="{{ route('books.index') }}" class="nav-item {{ request()->routeIs('books.index') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Books
            </a>
        </div>
    </div>

    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-book me-2"></i>PAGEWAVE.com</h5>
                    <p>Your one-stop destination for knowledge and entertainment.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li><a href="{{ route('books.index') }}" class="text-white-50">Books</a></li>
                        <li><a href="#" class="text-white-50">About Us</a></li>
                        <li><a href="#" class="text-white-50">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <p class="text-white-50">
                        <i class="fas fa-envelope me-2"></i>info@pagewave.com<br>
                        <i class="fas fa-phone me-2"></i>+1 234 567 890<br>
                        <i class="fas fa-map-marker-alt me-2"></i>123 Book Street, NY
                    </p>
                </div>
            </div>
            <hr class="bg-light">
            <p class="text-center mb-0">&copy; {{ date('Y') }} PAGEWAVE.com. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>