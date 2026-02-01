@if ($paginator->hasPages())
<nav aria-label="Pagination Navigation">
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">&laquo;</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled">
            <span class="page-link">{{ $element }}</span>
        </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active">
            <span class="page-link">{{ $page }}</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        </li>
        @else
        <li class="page-item disabled">
            <span class="page-link">&raquo;</span>
        </li>
        @endif
    </ul>
</nav>
@endif

<style>
.pagination svg {
    display: none;
}

.pagination {
    display: flex;
    list-style: none;
    padding-left: 0;
    justify-content: center;
    gap: 5px; 
}

.page-item {
    display: inline;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 35px;
    height: 35px;
    color: #0ea5e9;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px !important; 
    padding: 0 10px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.page-item.active .page-link {
    background-color: #0ea5e9;
    border-color: #0ea5e9;
    color: white;
}

.page-link:hover:not(.disabled) {
    background-color: #f0f9ff;
    transform: translateY(-2px);
}
</style>