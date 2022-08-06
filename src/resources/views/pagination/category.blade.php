@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item icon-previous disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    {{-- <span class="page-link" aria-hidden="true">&lsaquo;</span> --}}
                    <span class="page-link" aria-hidden="true">Poprzednia strona</span>
                </li>
            @else
                <li class="page-item icon-previous">
                    {{-- <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a> --}}
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Poprzednia strona</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    {{-- <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li> --}}
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            @if (abs($paginator->currentPage() - $page) <= 1 || ($paginator->currentPage() == 1 && $page <= 3))
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item icon-next">
                    {{-- <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a> --}}
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Następna strona</a>
                </li>
            @else
                <li class="page-item icon-next disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    {{-- <span class="page-link" aria-hidden="true">&rsaquo;</span> --}}
                    <span class="page-link" aria-hidden="true">Następna strona</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
    .icon-previous {
    display: flex;
    border: 1px solid #00a143;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 14px;
}

.icon-next {
    display: flex;
    border: 1px solid #00a143;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 14px;
}

.icon-previous.disabled,
.icon-next.disabled {
    border: 1px solid #818181;
}

.page-item {
    padding: 5px 10px;
}
</style>
