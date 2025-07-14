@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6 text-white" role="navigation" aria-label="Pagination Navigation">
        <ul class="inline-flex items-center space-x-2  px-4 py-2 rounded-md">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 text-sm text-black rounded-full cursor-not-allowed">‹ Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-1 text-sm text-black  rounded-full transition">
                        ‹ Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1 text-sm text-gray-400">…</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 text-sm border-black border-2 text-black rounded-md">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-1 text-sm text-black rounded-full transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-1 text-sm text-black rounded-full transition">
                        Next ›
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 text-sm text-white  rounded-full cursor-not-allowed">
                        Next ›
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
