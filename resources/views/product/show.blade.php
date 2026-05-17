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

                <div class="product-main-image-wrapper">
                    <img
                        id="mainProductImage"
                        src="{{ asset('storage/' . $preview->image) }}"
                        class="product-main-img"
                    >
                </div>

                @if($product->images->count() > 1)

                    <div class="product-thumbs">

                        @foreach($product->images as $image)

                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                class="product-thumb {{ $preview->id === $image->id ? 'active' : '' }}"
                                onclick="changeProductImage(this)"
                            >

                        @endforeach

                    </div>

                @endif

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
        @auth
        <form method="POST" action="{{ route('product.reviews.store', $product) }}" class="review-form">
            @csrf
            @error('text')
                <div class="error">{{ $message }}</div>
            @enderror
            <label>Оценка</label>
            <select name="rating" required>
                <option value="5">5 — отлично</option>
                <option value="4">4 — хорошо</option>
                <option value="3">3 — нормально</option>
                <option value="2">2 — плохо</option>
                <option value="1">1 — ужасно</option>
            </select>

            <label>Отзыв</label>
            <textarea name="text" required placeholder="Напишите отзыв"></textarea>

            <button type="submit" class="btn">Оставить отзыв</button>
        </form>
        @else
        <p>
            Чтобы оставить отзыв, 
            <a href="{{ route('vk.redirect') }}">войдите через VK</a>
            или авторизуйтесь.
        </p>
        @endauth
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

                                    @if($review->user?->avatar)

                                        <img
                                            
                                            src="{{ $review->user->avatar ?? '/img/default-avatar.png' }}" 
                                            alt="{{ $review->user?->first_name ?? $review->user?->name }}"
                                            class="review-avatar-img"
                                        >

                                    @else

                                        <span>
                                            {{ mb_substr($review->user?->first_name ?? $review->user?->name ?? 'П', 0, 1) }}
                                        </span>

                                    @endif

                                </div>

                                <div>
                                    <div class="review-name">
                                        {{ $review->user?->first_name ?? $review->user?->name ?? 'Пользователь' }}
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

<script>
    function changeProductImage(el) {
        document.getElementById('mainProductImage').src = el.src;

        document.querySelectorAll('.product-thumb').forEach((img) => {
            img.classList.remove('active');
        });

        el.classList.add('active');
    }
</script>
@endsection
