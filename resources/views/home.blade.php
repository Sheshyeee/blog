@extends('welcome')

@section('title', 'Home')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-12  bg-green-400 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex space-x-[200px] mt-[90px]">
        <div>
            <h1 class="text-[100px]">Read,</h1>
            <h1 class="text-[100px] mt-[-41px]">write, reflect</h1>
            <h1 class="text-[30px] mb-8">Simple ideas that speak to you</h1>

            <a href="{{ route('login.show') }}" class="border rounded-2xl text-white bg-slate-900 px-8 py-3">Start Reading</a>
        </div>
        <div>
            <img src="{{ asset('/write.png') }}" alt="" class="w-[350px] h-[300px]">
        </div>
    </div>
@endsection
