@extends('welcome')

@section('title', 'Edit Post')

@section('content')
    <div class="max-w-3xl w-full px-12 mt-[70px] bg-white/60 backdrop-blur-md p-8">

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrfw
            @method('PUT')
            <input type="text" name="title" placeholder="Title"
                class="w-full text-4xl font-bold outline-none mb-6  text-black placeholder-gray-600 bg-transparent"
                value='{{ $post->title }}' required>

            <textarea name="content" rows="12" placeholder="Tell your story here..."
                class="w-full h-[250px] text-lg rounded resize-none focus:outline-none  text-black placeholder-gray-600   p-4 bg-transparent"
                required>{{ old('content', $post->content) }}</textarea>

            <div class="mb-6">
                <label for="category" class="block text-gray-500 mb-2">Category</label>
                <select name="category" id="category"
                    class="w-full  rounded px-4 py-2  focus:outline-none focus:ring-2 focus:ring-black  text-black placeholder-gray-600   p-4 bg-transparent"
                    required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="Technology">Technology</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Education">Education</option>
                    <option value="Travel">Travel</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="mt-6">
                <label for="image">Change Featured Image</label>
                <input type="file" name="image" accept="image/*"
                    class=" file:bg-black file:text-white file:mr-4 file:py-1.5 file:px-4
                       file:rounded file:border-0">

            </div>

            <button type="submit" class="mt-6 px-6 py-2 text-gray-700 rounded w-[100%] hover:bg-gray-200 ">
                Publish
            </button>
        </form>
    </div>
@endsection
