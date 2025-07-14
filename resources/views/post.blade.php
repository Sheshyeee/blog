@extends('welcome')

@section('title', $post->title)

@section('content')

    <!-- Alpine State Wrapper -->
    <div class="w-[650px] mx-auto mt-10 px-6"x-data="{ openComment: {{ session('open_comment') ? 'true' : 'false' }}, selectedPostId: null }">
        <h1 class="font-bold text-5xl mb-6">{{ $post->title }}</h1>

        <div class="flex space-x-7 justify-between">
            <div class="flex space-x-5 items-center mb-8">
                <div>
                    <h2>{{ $post->user->name }}</h2>
                </div>
                <h1 class="text-lg"> · </h1>
                <div>
                    <h2 class="text-gray-600 text-sm">
                        {{ $post->created_at->setTimezone('Asia/Manila')->format('F j, Y \a\t g:i A') }}
                    </h2>
                </div>
                <h1 class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</h1>
            </div>
            <div class=" flex justify-center items-center space-x-10 mt-[-20px]">

                <div class="flex space-x-2">
                    <form
                        action="{{ route('like.store', $post->id) }}?keep_comment={{ session('open_comment') ? '1' : '0' }}"
                        method="POST">
                        @csrf
                        <button type="submit"><img src="{{ asset('/heart.svg') }}" alt="like"></button>
                    </form>

                    <p>{{ $post->likes->count() }}</p>
                </div>
                <button @click="openComment = true; " class="flex justify-center items-center">
                    <img src="{{ asset('/message-circle.svg') }}" alt="Comment">
                    <h1 class="ml-2">{{ $post->comments->count() }}</h1>
                </button>
            </div>
        </div>

        <div>
            <p class="text-lg">{!! nl2br(e($post->content)) !!}</p>
        </div>

        <div x-show="openComment" x-transition
            class="fixed top-0 h-full overflow-y-auto   right-0 w-[500px] bg-slate-50 shadow-lg border-l z-50 p-6"
            @click.away="openComment = false">

            <h2 class="text-2xl font-bold mb-2">{{ $post->comments->count() <= 1 ? 'Reponse' : 'Responses' }}
                ({{ $post->comments->count() }})</h2>
            <hr>
            <div class="flex mt-8 mb-3">
                <img src="{{ asset('/circle-user-round.svg') }}" class="w-5 h-5" alt="icon">
                <h1 class="text-lg ml-2">{{ auth()->user()->name }}</h1>
            </div>
            <form method="POST" action="{{ route('comment.store', $post->id) }}">
                @csrf
                <input type="hidden" name="post_id" :value="selectedPostId">

                <div class="bg-slate-100 pb-4 h-[130px] ">
                    <textarea name="comment" rows="5" class="w-full focus:outline-none  bg-transparent p-4 rounded h-[130px]"
                        placeholder="Write your comment..."></textarea>

                    <div class="flex justify-end space-x-4  mr-12 bg-slate-100 w-full mt-[-8px]">
                        <button type="button" type="submit" @click="openComment = false"
                            class="text-black text-sm">Cancel</button>
                        <button @click="openComment = true"
                            class=" rounded-[30px] bg-black text-white px-4 py-1 text-sm ">Submit</button>
                    </div>
                </div>
            </form>

            <div class="w-full mt-8 ">
                @foreach ($post->comments->sortByDesc('created_at') as $comment)
                    <div class=" mb-4 p-4" x-data="{ openReply: false, openReplies: false, openDelete: false }">
                        <div class="flex flex-col ">
                            <div class="flex space-x-1.5">
                                <img src="{{ asset('/circle-user-round.svg') }}" class="w-9 h-10" alt="icon">
                                <div class="flex justify-center items-center">
                                    <div class="flex flex-col ">
                                        <div class="flex ">
                                            @if ($comment->user->name === $post->user->name)
                                                <div class="flex justify-center items-center space-x-4">
                                                    <h1 class="font-bold">{{ $comment->user->name }}</h1>
                                                    <p
                                                        class="text-[11px] py-0.5 px-3 bg-green-200 text-green-700 rounded-md font-bold">
                                                        Author</p>
                                                </div>
                                            @else
                                                <div class="flex justify-center items-center space-x-4">
                                                    <h1 class="font-bold">{{ $comment->user->name }}</h1>
                                                    <p
                                                        class="text-[10px] p-1 bg-slate-50 text-slate-50 rounded-md font-bold">
                                                        Author</p>
                                                </div>
                                            @endif
                                            @can('delete', $comment)
                                                <img src="{{ asset('/ellipsis.svg') }}" @click="openDelete = !openDelete; "
                                                    class="w-6 h-6 ml-[170px]" alt="icon">
                                                <div x-show="openDelete" x-transition @click.away="openDelete = false"
                                                    class="">
                                                    <form method="POST" action="{{ route('comment.destroy', $comment->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-black text-white text-sm py-1 px-3 rounded-md mt-[20px] ml-[-40px] absolute">Delete</button>
                                                    </form>
                                                </div>
                                            @endcan


                                        </div>
                                        <div class="flex flex-col">
                                            <h1 class="text-gray-800 text-sm">{{ $comment->created_at->diffForHumans() }}
                                            </h1>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4">
                                <h1>
                                    {{ $comment->content }}
                                </h1>
                            </div>

                        </div>
                        <div class="mt-5 flex">
                            <button @click="openReply = !openReply; "
                                class="mr-3 underline underline-offset-1 text-md text-blue-600">Reply</button>
                            @if ($comment->reply->count())
                                <div class="flex space-x-1 ml-8">
                                    <img src="{{ asset('/message-circle.svg') }}" alt="Comment">
                                    <button @click="openReplies = !openReplies; "
                                        class="text-gray-600 text-sm">{{ $comment->reply->count() }}
                                        {{ $comment->reply->count() <= 1 ? 'Reply' : 'Replies' }} </button>
                                </div>
                            @endif
                        </div>
                        <div x-show="openReply" x-transition @click.away="openReply = false">
                            <form method="POST" action="{{ route('reply.store', $comment->id) }}">
                                @csrf
                                <textarea name="reply" class="w-full focus:outline-none bg-transparent p-4 rounded" placeholder="Write your reply..."></textarea>
                                <div class="flex justify-end space-x-2  mr-6">
                                    <button type="button" @click="openReply = false" class="text-black">Cancel</button>
                                    <button type="submit"
                                        class=" rounded-[30px] bg-black text-white px-4 py-1 ">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div x-show="openReplies" x-transition @click.away="openReplies = false"
                            class="ml-12 border-l-2 border-gray-300 rounded-md pl-5">
                            <div class="mt-5">
                                @if ($comment->reply->count())
                                    @foreach ($comment->reply as $reply)
                                        <div class="flex space-x-1.5">
                                            <img src="{{ asset('/circle-user-round.svg') }}" class="w-7 h-8"
                                                alt="icon">
                                            <div class="flex justify-center items-center">
                                                <div class="flex flex-col ">
                                                    @if ($reply->user->name === $post->user->name)
                                                        <div class="flex justify-center items-center space-x-4">
                                                            <h1 class="font-bold text-sm">{{ $reply->user->name }}</h1>
                                                            <p
                                                                class="text-[11px] py-0.5 px-3 bg-green-200 text-green-700 rounded-md font-bold">
                                                                Author</p>
                                                        </div>
                                                    @else
                                                        <h1 class="font-bold text-sm">{{ $reply->user->name }}</h1>
                                                    @endif

                                                    <h1 class="text-gray-800 text-sm">
                                                        {{ $reply->created_at->diffForHumans() }}</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-4 py-6">
                                            <h1>{{ $reply->content }}</h1>
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
