@extends('layouts.app')


@section('title', 'Каталог')
@section('content')
    <div class="container">
        <h2 class="section-title">Каталог лакомств</h2>
        <div class="catalog-filters">
            <div class="catalog-main-categories">
                <a href="{{ route('catalog') }}"
                class="catalog-filter-main {{ request('category') ? '' : 'is-active' }}">
                    Все товары
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('catalog', ['category' => $category->id]) }}"
                    class="catalog-filter-main {{ request('category') == $category->id ? 'is-active' : '' }}">
                        {{ $category->title }}
                    </a>
                @endforeach
            </div>

            @foreach($categories as $category)
                @if(
                    request('category') == $category->id ||
                    $category->children->pluck('id')->contains((int) request('category'))
                )
                    @if($category->children->isNotEmpty())
                        <div class="catalog-subcategory-row">
                            @foreach($category->children as $child)
                                <a href="{{ route('catalog', ['category' => $child->id]) }}"
                                class="catalog-filter-child {{ request('category') == $child->id ? 'is-active' : '' }}">
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        <div class="catalog-grid">
              @foreach ($products as $product)
            <article class="product-card" >
                <div class="product-image" >
                   @php
                        $preview = $product->images->where('is_preview', true)->first()
                            ?? $product->images->first();
                    @endphp

                    @if ($preview)
                        <img src="{{ asset('storage/' . $preview->image) }}">
                    @endif
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
                         <form>
                        @csrf
                        <button type="button" class="btn product-btn add-to-cart " data-id="{{ $product->id }}">
                            В корзину
                        </button>
                        </form>
                           <a href="{{route('product', $product->id)}}" class="btn-accent product__link">
                                Подробнее
                            </a>
                        </div>
                </div>
            </article>
            @endforeach        
            
            

        </div>
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
@endsection