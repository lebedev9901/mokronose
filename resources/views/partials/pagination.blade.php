@if($products->lastPage() > 1)
    <div class="custom-pagination">
        @if ($products->onFirstPage())
            <span class="disabled">«</span>
        @else
            <a href="{{ $products->previousPageUrl() }}">«</a>
        @endif

        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if ($page == $products->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}">»</a>
        @else
            <span class="disabled">»</span>
        @endif
    </div>
@endif