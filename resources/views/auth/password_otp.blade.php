
@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    .login-card h3, .login-card h4 {
        font-weight: 700;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .btn-primary {
        background-color: #157347;
        border: none;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #157347;
    }
</style>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="img-fluid" style="height: 80px;">
            <h3 class="mt-3">Ilala SDA Church</h3>
            <p class="text-muted">Offering Management System</p>
            <h4 class="mt-2">Verify OTP</h4>
        </div>

        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label fw-semibold">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" maxlength="6" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Verify OTP</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('password.email.form') }}" class="text-decoration-none">Back to Email</a>
        </div>
    </div>
</div>
@endsection




