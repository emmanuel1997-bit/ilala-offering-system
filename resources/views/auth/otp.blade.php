@extends('layouts.app')

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
        transition: all 0.3s ease-in-out;
    }

    .otp-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .otp-card h3 {
        font-weight: 700;
        color: #157347;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #157347;
    }

    .btn-success {
        background-color: #157347;
        border: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-success:hover {
        background-color: #0f5a32;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border-left: 4px solid #ef4444;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .text-link {
        color: #157347;
        font-weight: 500;
    }

    .text-link:hover {
        text-decoration: underline;
        color: #0f5a32;
    }
</style>

<div class="flex justify-center items-center min-h-screen">
    <div class="otp-card w-full max-w-md">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/steward.png') }}"
                 alt="Ilala SDA Logo"
                 class="mx-auto mb-3 rounded-full shadow-md"
                 style="height: 90px;">
            <h3 class="text-2xl font-bold">Ilala SDA Church</h3>
            <p class="text-gray-500 mb-1">Offering Management System</p>
            <h4 class="text-green-700 font-semibold mt-3">Enter OTP</h4>
        </div>

        @if(session('message'))
            <div class="alert-success text-center">
                {{ session('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="mb-4">
                <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1">OTP Code</label>
                <input type="text" name="otp" id="otp" maxlength="6"
                       class="form-control w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-600 text-center text-lg tracking-widest"
                       placeholder="Enter 6-digit code" required>
            </div>

            <button type="submit" class="btn-success w-full py-2 rounded text-white">Verify OTP</button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-link">← Back to Login</a>
        </div>
    </div>
</div>
@endsection
