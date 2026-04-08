@extends('layouts.app')

@section('content')
<div class="container">
    <div class="product-page">
        <div class="product-page__grid">
            <div class="product-gallery">
                @php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                @endphp

                @if ($preview)
                    <img src="{{ asset('storage/' . $preview->image) }}" class="product-main-img">
                @endif
            </div>
            <div class="product-info">

                <h1 class="product-title">{{ $product->title }}</h1>

                <div class="product-rating">
                    ⭐ {{ $product->rating ?? '4.8' }}
                </div>

                <p class="product-desc">
                    {{ $product->description }}
                </p>

                <div class="product-price">
                    {{ $product->price }} ₽
                </div>

                <form>
                        @csrf
                        <button type="button" class="btn product-btn add-to-cart" data-id="{{ $product->id }}">
                            В корзину
                        </button>
                </form>
                <div class="product-benefits">
                    <div>🐶 100% натуральный состав</div>
                    <div>🚚 Быстрая доставка</div>
                    <div>❤️ Подходит для всех пород</div>
                </div>
            </div>
        </div>
        <div class="product-reviews">

            <h2 class="section-title">Отзывы о товаре</h2>

            @if($product->reviews->count())
                <div class="reviews-grid">

                    @foreach($product->reviews as $review)
                        <div class="review-card">

                            <div class="review-rating">
                                ⭐ {{ $review->rating }}
                            </div>

                            <p class="review-text">
                                {{ $review->text }}
                            </p>

                            <div class="review-author">
                                <div class="review-avatar">
                                    {{ mb_substr($review->user_name, 0, 1) }}
                                </div>

                                <div>
                                    <div class="review-name">
                                        {{ $review->user_name }}
                                    </div>
                                    <div class="review-date">
                                        {{ $review->created_at->format('d.m.Y') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <p class="no-reviews">Пока нет отзывов. Будьте первым!</p>
            @endif

        </div>
    </div>
</div>
@endsection
