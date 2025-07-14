@extends('welcome')

@section('title', 'Edit User')

@section('content')

    <div class="max-w-md mx-auto p-6 bg-white/60 backdrop-blur-md shadow rounded mt-[70px]">
        <h2 class="text-xl font-bold mb-4">Edit user</h2>

        <p class="mb-4"> Current Role: <strong>{{ $user->role }}</strong></p>

        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf

            @method('PUT')
            <input type="text" name="name" placeholder="Name" class="w-full p-2 border mb-4 bg-transparent"
                value="{{ $user->name }}" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-4 bg-transparent"
                value="{{ $user->email }}" required>
            <p class="text-gray-500 text-[11px]">-Hashed Password</p>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border mb-4 bg-transparent"
                value="{{ $user->password }}" required>

            <label for="role" class="block mb-2">Update Role:</label>
            <select name="role" id="role" class="w-full border p-2 mb-4" value="{{ $user->role }}" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

@endsection
