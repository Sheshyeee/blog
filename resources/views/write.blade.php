@extends('welcome')

@section('title', 'Write a Post')

@section('content')

    <div class="max-w-3xl w-full px-12 mt-[70px] bg-white/50 backdrop-blur-md p-8 rounded-2xl">

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('write') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="title" placeholder="Write your Title"
                class="w-full text-4xl font-bold outline-none border-0 mb-6 placeholder-gray-600 bg-transparent" required>

            <textarea name="content" rows="12" placeholder="Tell your story here..."
                class="w-full h-[250px] text-lg rounded resize-none focus:outline-none text-black placeholder-gray-600  border-2p-4 bg-transparent"
                required></textarea>

            <div class="mb-6">
                <label for="category" class="block text-gray-600 mb-2">Category</label>
                <select name="category" id="category"
                    class="w-full  rounded px-4 py-2 text-gray-800   bg-transparent focus:outline-none focus:ring-2 focus:ring-black border-2"
                    required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="Technology">Technology</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Education">Education</option>
                    <option value="Travel">Travel</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <!-- Image Upload -->
            <div class="mt-6">
                <label for="image" class="block text-gray-600 mb-2">Featured Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full text-sm text-gray-750
                       file:mr-4 file:py-2 file:px-4
                       file:rounded file:border-0
                       file:text-sm file:font-semibold
                       file:bg-black file:text-white
                       hover:file:bg-gray-800">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="mt-6 px-6 py-2 text-gray-800 rounded w-[100%] hover:bg-gray-200 border-2 border-gray-600">
                Publish
            </button>
        </form>
    </div>
@endsection
