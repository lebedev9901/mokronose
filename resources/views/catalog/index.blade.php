@extends('layouts.app')


@section('title', 'Каталог')
@section('content')
    <div class="container">
        <h2 class="section-title">Каталог лакомств</h2>
        <div class="catalog-filters">
    <a href="{{ route('catalog') }}"
       class="{{ request('category') ? '' : 'active' }}">
        Все
    </a>

    @foreach($categories as $category)
        <a href="{{ route('catalog', ['category' => $category->id]) }}"
           class="{{ request('category') == $category->id ? 'active' : '' }}">
            {{ $category->title }}
        </a>
    @endforeach
</div>
        <div class="catalog-grid">
              @foreach ($products as $product)
            <article class="product-card" >
                <div class="product-image" >
                    <img src="{{ $product->images->first()?->image ?? ''}}" alt="{{ $product->title }}">
                </div>

                <div class="product-info">
                    <a href="{{ route('product', $product->id)}}" class="product-title">{{ $product->title }}</a>
                    <p class="product-desc">
                        {{ $product->description }}
                    </p>
                    <div class="product-rating">
                    <span class="rating_text">⭐{{$product->rating}}</span>
                    </div>
                    <div class="product-meta">
                        <span class="product-weight">{{ $product->weight }}</span>
                        <span class="product-price">{{ $product->price}}₽</span>
                    </div>

                    <div class="product-actions"  data-id="{{$product->id}}">
                        <div class="cart-qty-controls" style="display:none;">
                        <button class="qty-minus">−</button>
                        <span class="qty-number">1</span>
                        <button class="qty-plus">+</button>
                    </div>
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit">В корзину</button>
                        </form>
                        <button class="btn-order">Заказать</button>
                            </div>
                </div>
            </article>
            @endforeach        
            
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

        </div>

    </div>
@endsection