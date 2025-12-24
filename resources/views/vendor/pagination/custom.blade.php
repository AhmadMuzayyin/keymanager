@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-slate-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="px-3 py-2 text-slate-600 hover:text-[#009B4D] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $pages = [];

            // Always show first page
            $pages[] = 1;

            // Current page and next page (if exists and not already shown)
            if ($currentPage > 1 && $currentPage < $lastPage) {
                $pages[] = $currentPage;
            }
            if ($currentPage + 1 < $lastPage - 1 && $currentPage + 1 > 1) {
                $pages[] = $currentPage + 1;
            }

            // Last two pages (second last and last)
            if ($lastPage > 1) {
                if ($lastPage - 1 > 1) {
                    $pages[] = $lastPage - 1;
                }
                $pages[] = $lastPage;
            }

            // Remove duplicates and sort
            $pages = array_unique($pages);
            sort($pages);
        @endphp

        @foreach ($pages as $index => $page)
            {{-- Add dots if there's a gap --}}
            @if ($index > 0 && $page - $pages[$index - 1] > 1)
                <span class="px-2 py-2 text-slate-400">...</span>
            @endif

            @if ($page == $currentPage)
                <span class="px-4 py-2 bg-[#009B4D] text-white font-semibold rounded-lg">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $paginator->url($page) }}"
                    class="px-4 py-2 text-slate-600 hover:bg-[#009B4D] hover:text-white rounded-lg transition-colors">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="px-3 py-2 text-slate-600 hover:text-[#009B4D] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="px-3 py-2 text-slate-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        @endif
    </nav>
@endif
