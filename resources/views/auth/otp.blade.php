@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw')
                    no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
        backdrop-filter: blur(4px);
    }

    .login-card {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 20px;
        padding: 50px 45px;
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.25);
        transition: all 0.3s ease;
        width: 100%;
        max-width: 460px;
    }

    .login-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.35);
    }

    .login-card h3 {
        font-weight: 700;
        color: #157347;
    }

    .input-group {
        position: relative;
        margin-bottom: 22px;
    }

    .input-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        transition: all 0.2s ease;
        background-color: #f9fafb;
        text-align: center;
        letter-spacing: 0.3em;
        font-size: 18px;
    }

    .input-group input:focus {
        border-color: #157347;
        background-color: #ffffff;
        box-shadow: 0 0 0 2px rgba(21, 115, 71, 0.15);
    }

    .btn-success {
        background-color: #157347;
        border: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.25s ease;
        padding: 12px;
        border-radius: 10px;
    }

    .btn-success:hover {
        background-color: #0f5a32;
        transform: scale(1.02);
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border-left: 4px solid #ef4444;
        padding: 10px 14px;
        margin-bottom: 12px;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border-left: 4px solid #22c55e;
        padding: 10px 14px;
        margin-bottom: 12px;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .text-link {
        color: #157347;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .text-link:hover {
        text-decoration: underline;
        color: #0f5a32;
    }

    .logo {
        height: 120px;
        width: 120px;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        margin-bottom: 12px;
    }
</style>

<div class="login-wrapper w-full flex justify-center px-6">
    <div class="login-card w-full max-w-[900px]">

        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="logo mx-auto">
            <h3 class="text-2xl font-bold">Enter OTP</h3>
            <p class="text-gray-500 mb-1">Verification Code</p>
        </div>

        {{-- ✅ Success Message --}}
        @if(session('message'))
            <div class="alert-success text-center">{{ session('message') }}</div>
        @endif

        {{-- ❌ Error Messages --}}
        @if($errors->any())
            <div class="alert-danger">
                <ul class="list-disc list-inside mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="input-group">
                <input type="text" name="otp" id="otp" maxlength="6" placeholder="Enter OTP" required>
            </div>

            <button type="submit" class="btn-success w-full text-white">Verify OTP</button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-link">← Back to Login</a>
        </div>
    </div>
</div>
@endsection
