@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-6">
    <h2 class="text-2xl font-bold text-green-700 mb-4">Profile Settings</h2>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Profile Image -->
        <div class="flex items-center gap-6">
            <img src="{{ $user->profile_photo_url ?? asset('storage/images/steward.png') }}"
                 alt="Profile" class="w-20 h-20 rounded-full object-cover border">
            <div>
                <label class="block text-gray-600 font-medium mb-1">Change Profile Picture</label>
                <input type="file" name="profile_photo"
                       class="block w-full text-sm text-gray-500 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>
        </div>

        <!-- Name -->
        <div>
            <label class="block text-gray-600 font-medium mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-gray-600 font-medium mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">
                Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
