@extends('welcome')

@section('title', 'All Users')

@section('content')
    <div class="max-w-md mx-auto mt-10 text-center">
        <h1 class="text-2xl font-bold mb-4">Verify Your Email</h1>
        <p class="mb-4">Please check your email for a verification link.</p>

        @if (session('message'))
            <div class="text-green-600">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
                Resend Verification Email
            </button>
        </form>
    </div>
@endsection
