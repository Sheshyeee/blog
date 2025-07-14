@extends('welcome')

@section('title', 'login')

@section('content')
    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-10  bg-red-500 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('error') }}
        </div>
    @endif

    <div class="w-full max-w-md p-6 rounded-2xl flex flex-col bg-white/60 backdrop-blur-md  shadow-2 mt-[70px]">
        <div>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-6 text-black">Login to your account</h2>
            <p class="text-gray-700 mt-[-20px] mb-4">Enter your email below to login to <br> your account</p>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="mb-4" for="">Email</label>
                    <input type="email" id="email" name="email" placeholder="..."
                        class="w-full p-2 border-2 border-gray-200 rounded-lg shadow mt-2 focus:outline-none bg-transparent focus:border-black"
                        required>
                </div>


                <div class="mb-4">
                    <label class="mb-4" for="">Password</label>
                    <input type="password" id="password" name="password" placeholder="..."
                        class="w-full p-2 mt-2 border-2 border-gray-200 rounded-lg shadow  focus:outline-none bg-transparent focus:border-black"
                        required>
                </div>
                <button type="submit" class="w-[200px] bg-slate-900 rounded-2xl text-white py-2  hover:bg-gray-800">
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection
