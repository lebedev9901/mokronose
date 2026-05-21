@extends('layouts.app')

@section('title', $product->name . ' — Мокронос')

@section('description', Str::limit(strip_tags($product->description), 160))

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

                @if($product->categories->isNotEmpty())
                    <div class="product-card-categories">
                        @foreach($product->categories as $category)
                            <a href="{{ route('catalog', ['category' => $category->id]) }}" class="product-card-category">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                @endif

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
                </div>
            </div>
        </div>
        @auth
        <form method="POST"
      action="{{ route('product.reviews.store', $product) }}"
      enctype="multipart/form-data"
      class="review-form">
    @csrf

    <label>Оценка</label>
    <select name="rating" required>
        <option value="5">5 — Отлично</option>
        <option value="4">4 — Хорошо</option>
        <option value="3">3 — Нормально</option>
        <option value="2">2 — Плохо</option>
        <option value="1">1 — Ужасно</option>
    </select>

    <label>Отзыв</label>
    <textarea name="text" required placeholder="Напишите отзыв"></textarea>

    <label class="review-upload">
        <input type="file" name="images[]" multiple accept="image/*" id="reviewImages">
        <span>📷 Добавить фото</span>
        <small>Можно выбрать несколько изображений</small>
    </label>

    <div class="review-preview" id="reviewPreview"></div>

    <button type="submit" class="btn">Оставить отзыв</button>
</form>
        @else
        <p>
            Чтобы оставить отзыв, 
            <a href="{{ route('vk.sdk-login') }}">войдите через VK</a>
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

                            @if($review->images->count())
                                <div class="review-images">
                                    @foreach($review->images as $image)
                                        <a href="{{ asset('storage/' . $image->path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Фото отзыва">
                                        </a>
                                    @endforeach
                                </div>
                            @endif

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
<script>
document.addEventListener('change', function (event) {
    if (event.target.id !== 'reviewImages') return;

    const preview = document.getElementById('reviewPreview');
    preview.innerHTML = '';

    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();

        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endsection
