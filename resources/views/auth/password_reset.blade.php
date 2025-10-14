@extends('layouts.app')

@section('content')
<!-- Make sure Font Awesome is included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-pO1bG6+D8xK+6tQYgFVkk7O2y+RmRy8dE0xnhzBGJ02nXc5/4jvDx8vZ0fX4p0B9Z3BrD/NkJuFZ9H8uD+P1bw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
        background: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw') no-repeat center center fixed;
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
        width: 100%;
        max-width: 460px;
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
        padding: 12px 45px 12px 40px; /* leave space for icons */
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        background-color: #f9fafb;
    }

    .input-group input:focus {
        border-color: #157347;
        background-color: #ffffff;
        box-shadow: 0 0 0 2px rgba(21, 115, 71, 0.15);
    }

    .input-group .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 16px;
    }

    .input-group .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        font-size: 16px;
    }

    .btn-success {
        background-color: #157347;
        border: none;
        font-weight: 600;
        font-size: 16px;
        padding: 12px;
        border-radius: 10px;
        width: 100%;
        color: white;
    }

    .btn-success:hover {
        background-color: #0f5a32;
        transform: scale(1.02);
    }

    .alert-danger, .alert-success {
        border-radius: 6px;
        padding: 10px 14px;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
        border-left: 4px solid #ef4444;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .logo {
        height: 120px;
        width: 120px;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        margin-bottom: 12px;
    }
</style>

<div class="login-wrapper w-full flex justify-center px-6">
    <div class="login-card w-full max-w-[900px]">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/steward.png') }}" alt="Logo" class="logo mx-auto">
            <h3 class="text-2xl font-bold">Set New Password</h3>
            <p class="text-gray-500 mb-1">Enter a strong new password</p>
        </div>

        @if(session('message'))
            <div class="alert-success text-center">{{ session('message') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-danger">
                <ul class="list-disc list-inside mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', session('email')) }}">

            <div class="input-group">
                <i class="fa fa-lock input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Enter new password" required>
                <i class="fa fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <div class="input-group">
                <i class="fa fa-lock input-icon"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required>
                <i class="fa fa-eye toggle-password" id="toggleConfirmPassword"></i>
            </div>

            <button type="submit" class="btn-success">Reset Password</button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-link">← Back to Login</a>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.classList.toggle('fa-eye-slash');
    });

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password_confirmation');
    toggleConfirmPassword.addEventListener('click', function () {
        const type = confirmInput.type === 'password' ? 'text' : 'password';
        confirmInput.type = type;
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
