<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Blog')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        textarea[name="Tell your story..."],
        input[name="title"] {
            font-family: Charter, 'Bitstream Charter', 'Sitka Text', Cambria, serif;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, sans-serif;
            line-height: 1.6;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



</head>

<body class="bg-slate-50 h-screen ">
    @guest
        <div class="flex justify-between p-2 fixed  w-[100%] bg-gray-50 z-50">
            <a href="{{ route('home') }}">
                <h1 class="font-bold text-2xl text-slate-800">Thoughts</h1>
            </a>
            <div class="flex space-x-6 items-center">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('login.show') }}">Login</a>
            </div>
        </div>
    @endguest

    @auth
        <div class="flex justify-between p-2  bg-slate-50 fixed top-0  w-[100%] z-0 ">
            <a href="{{ route('showblog') }}">
                <h1 class="font-bold text-2xl text-slate-900">Thoughts</h1>
            </a>

            <div class=" space-x-4 items-center  hidden md:flex">

                <a href="{{ route('showblog') }}">Blog</a>


                <a href="{{ route('userPosts.show') }}">My Posts</a>
                <a href="{{ route('write.form') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('/square-pen.svg') }}" class="w-6 h-6" alt="Write">
                    <span class="text-gray-800">Write</span>
                </a>
                @can('admin-only')
                    <a href="{{ route('allUsers.show') }}">All User</a>
                @endcan

            </div>

            <div class="flex space-x-2 items-center">
                @can('admin-only')
                    <a href="{{ route('role.show') }}" class="border border-black shadow p-1 text-sm px-3 rounded-md">Role</a>
                    <a href="{{ route('register.show') }}"
                        class="border border-black shadow p-1 text-sm px-3 rounded-md">Register</a>
                @endcan



                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-slate-900 text-white rounded p-1.5 text-sm px-3">Logout</button>
                </form>
            </div>
        </div>
    @endauth




    <!-- Page Content -->
    <main class="p-6 flex justify-center">
        @yield('content')
    </main>


</body>

</html>
