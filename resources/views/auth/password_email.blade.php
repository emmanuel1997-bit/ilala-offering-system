@extends('layouts.app')

@section('title', 'Reset Password - Ilala SDA')

@section('content')
<style>
    body {
        background: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw')
        no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .otp-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #157347;
    }

    .btn-primary {
        background-color: #157347;
        border: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #125c38;
    }

    .btn-success {
        background-color: #198754;
        border: none;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #157347;
    }
</style>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="otp-card" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            {{-- Church Logo --}}
            <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="img-fluid" style="height: 80px;">
            <h3 class="mt-3 fw-bold">Ilala SDA Church</h3>
            <p class="text-muted mb-2">Offering Management System</p>
            <h4 class="mt-3">Reset Password</h4>
        </div>

        {{-- Success Message --}}
        @if(session('message'))
            <div class="alert alert-success text-center">{{ session('message') }}</div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Reset Form --}}
        <form method="POST" action="{{ route('password.email.send') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control"
                       placeholder="Enter your email"
                       required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">
                Send OTP
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</div>
@endsection
