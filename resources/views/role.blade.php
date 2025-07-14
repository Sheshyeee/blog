@extends('welcome')

@section('content')
    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-10  bg-red-600 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-md mx-auto p-6 bg-white shadow rounded mt-[70px]">
        <h2 class="text-xl font-bold mb-4">Select Role</h2>
        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <label for="role" class="block mb-2">Choose Role:</label>
            <select name="role" id="role" class="w-full border p-2 mb-4" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Next</button>
        </form>
    </div>
@endsection
