@extends('welcome')

@section('title', 'Blogs')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-10  bg-green-400 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('success') }}
        </div>
    @endif
    <div class="pt-[130px]">

        <div
            class="flex justify-between items-center p-3 w-[1100px] bg-white/60 backdrop-blur-md  shadow-md rounded-t-2xl z-0 rounded-r-2xl fixed top-[75px]  ">
            <div>
                <p class="font-normal text-[20px]">Showing ({{ $postCount }}) Posts</p>
            </div>
            <a class="flex justify-center items-center">
                <p class="text-[18px]">Hide Filters</p>
                <img src="{{ asset('/slider.svg') }}" class="w-10 h-6" alt="slider">
            </a>
        </div>
        <div class="flex">
            <div
                class="w-[300px] shadow-md flex flex-col font-bold text-lg p-8 bg-white/60 backdrop-blur-md fixed top-[132px] h-[calc(100vh-100px)] overflow-y-auto">
                <a href="{{ route('showblog') }}"
                    class=" hover:bg-blue-50 hover:text-gray-600  py-1 px-4  font-normal rounded-md text-[17px] {{ request('category') == '' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">All</a>
                <a href="{{ route('showblog', ['category' => 'Technology']) }}"
                    class="mb-2 hover:bg-blue-50 font-normal hover:text-gray-600 py-1 px-4 rounded-md text-[17px]  {{ request('category') == 'Technology' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">Technology</a>
                <a href="{{ route('showblog', ['category' => 'Lifestyle']) }}"
                    class="mb-2 hover:bg-blue-50  font-normal hover:text-gray-600 py-1 px-4 rounded-md text-[17px] {{ request('category') == 'Lifestyle' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">Lifestyle</a>
                <a href="{{ route('showblog', ['category' => 'Education']) }}"
                    class="mb-2 hover:bg-blue-50  font-normal hover:text-gray-600 py-1 px-4 rounded-md text-[17px] {{ request('category') == 'Education' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">Education</a>
                <a href="{{ route('showblog', ['category' => 'Travel']) }}"
                    class="mb-2 hover:bg-blue-50  font-normal hover:text-gray-600  py-1 px-4 rounded-md text-[17px] {{ request('category') == 'Travel' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">Travel</a>
                <a href="{{ route('showblog', ['category' => 'Others']) }}"
                    class="mb-2 hover:bg-blue-50  font-normal hover:text-gray-600  py-1 px-4 rounded-md text-[17px] {{ request('category') == 'Others' ? 'bg-blue-100 text-blue-500 ' : 'text-gray-600' }}">Others</a>
            </div>
            <div class="ml-[300px] w-full h-[calc(100vh-130px)] overflow-y-auto px-8 scroll-smooth">
                @forelse ($posts as $post)
                    <a href="{{ route('post.show', $post->id) }}" class="block mb-4">
                        <div class="bg-white/60 backdrop-blur-md  rounded-2xl shadow-xl p-6">
                            <div class="w-full max-w-[700px] flex space-x-4">
                                <div class="w-[500px]">
                                    <div class="mb-4">
                                        <p class="text-md text-gray-600">
                                            by: <span class="text-black">{{ $post->user->name ?? 'Unknown' }}</span>
                                        </p>
                                    </div>
                                    <p class="font-bold text-2xl mb-1 text-slate-900">{{ $post->title }}</p>
                                    <p class="text-gray-600">{{ $post->category }}</p>
                                    <div class="flex justify-between mt-4">
                                        <p class="text-sm text-gray-500">
                                            Posted on
                                            {{ $post->created_at->setTimezone('Asia/Manila')->format('F j, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div>
                                        <img src="{{ asset('storage/' . $post->image) }}"
                                            class="w-[165px] h-[120px] object-cover rounded" alt="">
                                    </div>
                                    <div class="mt-4">
                                        @can('delete', $post)
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-slate-900 px-3 py-1 border-2 rounded-md"><img
                                                        src="{{ asset('/trash.svg') }}" alt=""></button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="w-[746px]">No available posts</p>
                @endforelse
            </div>

        </div>
    </div>
@endsection
