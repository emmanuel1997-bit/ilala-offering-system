@extends('layouts.app')

@section('content')
<style>
   body {
    background: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.otp-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
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
    background-color: #157347;
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
            <img src="{{ asset('storage/images/steward.png') }}" alt="Logo" class="img-fluid" style="height:80px;">
            <h3 class="mt-3">Set New Password</h3>
            <p class="text-muted">Enter a strong new password</p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', session('email')) }}">

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">New Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Reset Password</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</div>
@endsection
