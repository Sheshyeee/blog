@extends('welcome')

@section('title', 'User Posts')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-12  bg-green-400 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-100 transition ease-in-out duration-500 ">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col mt-[50px] w-[50%] ">
        @forelse ($posts as $post)
            <a href="{{ route('post.show', $post->id) }} ">
                <div class=" border-b-2 p-8 py-10x bg-white/60 backdrop-blur-md rounded-2xl shadow-xl mb-3 ">
                    <div class=" flex space-x-4">
                        <div class="w-[500px] ">
                            <div class="mb-4">
                                <p class="text-md text-gray-600">by: <span class="text-black">
                                        {{ $post->user->name ?? 'Unknown' }}</span></p>
                            </div>
                            <p class="font-bold text-2xl mb-1 text-slate-900">{{ $post->title }}</p>
                            <p class="text-gray-600">{{ $post->category }}</p>
                            <div class="md:flex flex-shrink space-x-[180px] mt-4">
                                <div>
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            Posted on {{ $post->created_at->format('F j, Y \a\t g:i A') }}
                                        </p>w
                                    </div>
                                </div>
                                <div class="flex space-x-2   ">
                                    @can('delete', $post)
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-slate-900 px-3 py-1 border-2 rounded-md"><img
                                                    src="{{ asset('/trash.svg') }}" alt=""></button>
                                        </form>
                                    @endcan
                                    @can('update', $post)
                                        <form action="{{ route('posts.edit', $post->id) }}" method="GET">
                                            <button type="submit" class="px-3 py-1  border-2 rounded-md border-gray-  00"><img
                                                    src="{{ asset('/file-pen-line.svg') }}" alt=""></button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-[165px] h-[120px]" alt="">
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p>No available posts</p>
        @endforelse

    </div>

@endsection
