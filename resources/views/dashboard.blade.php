@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Welcome, {{ Auth::user()->name }}!</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                                    <h5>My Orders</h5>
                                    <a href="{{ route('profile.index') }}" class="btn btn-outline-primary">View Orders</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                    <h5>My Profile</h5>
                                    <a href="{{ route('profile.index') }}" class="btn btn-outline-primary">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                                    <h5>Browse Books</h5>
                                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection