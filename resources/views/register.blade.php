@extends('welcome')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-12  bg-green-400 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-md mx-auto p-6 bg-white/60 backdrop-blur-md shadow rounded mt-[70px]">
        <h2 class="text-xl font-bold mb-4">Register</h2>

        <p class="mb-4">Selected Role: <strong>{{ ucfirst($role) }}</strong></p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <input type="hidden" name="role" value="{{ $role }}">

            <input type="text" name="name" placeholder="Name" class="w-full p-2 border mb-4 bg-transparent" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-4 bg-transparent" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border mb-4 bg-transparent"
                required>

            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Register User</button>
        </form>
    </div>
@endsection
