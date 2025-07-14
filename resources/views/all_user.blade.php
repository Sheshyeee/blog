@extends('welcome')

@section('title', 'All Users')

@section('content')
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="fixed top-8 right-10 bg-green-400 text-white text-md font-medium px-12 py-4 rounded shadow-lg z-50 transition ease-in-out duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-12">
        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="text-black text-left text-[12px] uppercase tracking-wider">
                    <tr>
                        <th class="px-12 py-4">ID</th>
                        <th class="px-12 py-4">Name</th>
                        <th class="px-12 py-4">Email</th>
                        <th class="px-12 py-4">Role</th>
                        <th class="px-12 py-4">Created At</th>
                        <th class="px-12 py-4">Updated At</th>
                        <th class="px-12 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($users as $user)
                        <tr class="{{ $loop->even ? 'bg-slate-100' : 'bg-white' }} hover:bg-purple-50 transition">
                            <td class="px-6 py-2 text-center font-bold">{{ $user->id }}</td>
                            <td class="px-6 py-2 text-center font-bold">{{ $user->name }}</td>
                            <td class="px-6 py-2 text-center">{{ $user->email }}</td>
                            <td class="px-6 py-2 text-center capitalize">
                                <span
                                    class="{{ $user->role === 'admin' ? 'bg-cyan-100 text-cyan-500 font-bold' : 'bg-green-100 text-green-500 font-semibold' }} px-4 py-1 rounded-md">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-2 text-center">{{ $user->created_at->format('F j, Y') }}</td>
                            <td class="px-6 py-2 text-center">{{ $user->updated_at->format('F j, Y') }}</td>
                            <td class="px-6 py-2 text-center flex justify-center space-x-2">
                                <!-- Edit Form -->
                                <form action="{{ route('user.edit', $user->id) }}" method="GET" class="inline-block">
                                    <button type="submit" class="p-1 rounded px-4 hover:bg-gray-200">
                                        <img src="{{ asset('/user-pen.svg') }}" alt="Edit">
                                    </button>
                                </form>
                                <!-- Delete Form -->
                                @can('delete', $user)
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-slate-900 p-1 px-4 rounded hover:bg-gray-800">
                                            <img src="{{ asset('/trash.svg') }}" alt="Delete">
                                        </button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
