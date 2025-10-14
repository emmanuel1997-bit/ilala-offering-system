@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Users</h1>
            <button type="button" id="openCreateUserModal"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-md flex items-center transition duration-200">
                <i class="fas fa-user-plus mr-2"></i> Create New User
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Roles</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm">{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow transition"
                                    type="submit">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="createUserModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
            <button type="button" id="closeCreateUserModal"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-3xl font-bold" aria-label="Close">&times;</button>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Create User</h2>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-green-500 focus:border-green-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-green-500 focus:border-green-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Password</label>
                    <input type="password" name="password"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-green-500 focus:border-green-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-green-500 focus:border-green-500"
                        required>
                </div>
                <div class="mb-3">
                    <label class="block font-medium text-gray-700">Roles</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($roles as $role)
                        <label class="inline-flex items-center gap-1 px-2 py-1 border rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-checkbox">
                            <span class="text-gray-700">{{ $role->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="cancelCreateUserModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">Cancel</button>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openModalBtn = document.getElementById('openCreateUserModal');
        const closeModalBtn = document.getElementById('closeCreateUserModal');
        const cancelModalBtn = document.getElementById('cancelCreateUserModal');
        const modal = document.getElementById('createUserModal');

        openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    </script>
</div>
@endsection
