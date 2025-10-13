@extends('layouts.app')

@section('content')
<style>
    @include('partials.login-style')
</style>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="otp-card" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/steward.png') }}" alt="Logo" class="img-fluid" style="height:80px;">
            <h3 class="mt-3">Verify OTP</h3>
            <p class="text-muted">Enter the OTP sent to your email</p>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label fw-semibold">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" maxlength="6" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn btn-success w-100 fw-bold">Verify OTP</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('password.email.form') }}" class="text-decoration-none">Back to Email</a>
        </div>
    </div>
</div>
@endsection
