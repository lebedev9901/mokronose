@extends('layouts.app')

@section('title', $product->title . ' — Мокронос')
@section('description', Str::limit(strip_tags($product->description), 160))

@section('content')
@php
    $preview = $product->images->where('is_preview', true)->first()
        ?? $product->images->first();

    $mainImage = $preview
        ? asset('storage/' . $preview->image)
        : asset('assets/img/no-image.png');

    $ages = [
        'all' => 'Все возрасты',
        'puppy' => 'Щенки',
        'junior' => 'Юниоры',
        'adult' => 'Взрослые',
    ];

    $breeds = [
        'all' => 'Все породы',
        'small' => 'Мелкие породы',
        'medium' => 'Средние породы',
        'large' => 'Крупные породы',
    ];
@endphp

<div class="container">
    <section class="product-page">

        <div class="product-page__grid">

            <div class="product-gallery">
                <div class="product-main-image-wrapper">
                    <img
                        id="mainProductImage"
                        src="{{ $mainImage }}"
                        class="product-main-img"
                        alt="{{ $product->title }}"
                    >
                </div>

                <div class="product-thumbs">
                    @forelse($product->images as $image)
                        <img
                            src="{{ asset('storage/' . $image->image) }}"
                            class="product-thumb {{ $preview && $preview->id === $image->id ? 'active' : '' }}"
                            onclick="changeProductImage(this)"
                            alt="{{ $product->title }}"
                        >
                    @empty
                        <img
                            src="{{ asset('assets/img/no-image.png') }}"
                            class="product-thumb active"
                            onclick="changeProductImage(this)"
                            alt="{{ $product->title }}"
                        >
                    @endforelse
                </div>
            </div>

            <div class="product-info__show">

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

                <p class="product-desc-show">
                    {{ $product->description }}
                </p>

                <div class="product-price">
                    {{ $product->price }} ₽
                </div>

                <div class="product-actions" data-product-id="{{ $product->id }}">
                    <button type="button" class="btn product-btn add-to-cart" data-id="{{ $product->id }}">
                        В корзину
                    </button>

                    @auth
                        @php
                            $isFavorite = in_array($product->id, $favoriteIds ?? []);
                        @endphp

                        <button
                            type="button"
                            class="favorite__btn {{ $isFavorite ? 'is-active' : '' }}"
                            data-product-id="{{ $product->id }}"
                            onclick="toggleFavorite(this)"
                        >
                            {{ $isFavorite ? 'В избранном' : 'В избранное' }}
                        </button>
                    @endauth
                </div>

                <div class="product-benefits">
                    <div>🐶 100% натуральный состав</div>
                    <div>🚚 Быстрая доставка</div>
                    <div>🦴 Подходит для ежедневного рациона</div>
                </div>

            </div>
        </div>

        <div class="product-specs">
            <h3>Характеристики</h3>

            <div class="product-spec-row">
                <span>Подходит для</span>
                <strong>
                    {{ $ages[$product->age_group ?? 'all'] ?? 'Все возрасты' }}
                    /
                    {{ $breeds[$product->breed_size ?? 'all'] ?? 'Все породы' }}
                </strong>
            </div>

            @if($product->weight)
                <div class="product-spec-row">
                    <span>Вес</span>
                    <strong>{{ $product->weight }}</strong>
                </div>
            @endif

            @if($product->proteins)
                <div class="product-spec-row">
                    <span>Белки</span>
                    <strong>{{ $product->proteins }}</strong>
                </div>
            @endif

            @if($product->fats)
                <div class="product-spec-row">
                    <span>Жиры</span>
                    <strong>{{ $product->fats }}</strong>
                </div>
            @endif

            @if($product->carbohydrates)
                <div class="product-spec-row">
                    <span>Углеводы</span>
                    <strong>{{ $product->carbohydrates }}</strong>
                </div>
            @endif

            @if($product->energy_value)
                <div class="product-spec-row">
                    <span>Энергоценность</span>
                    <strong>{{ $product->energy_value }}</strong>
                </div>
            @endif

            @if($product->shelf_life)
                <div class="product-spec-row">
                    <span>Срок годности</span>
                    <strong>{{ $product->shelf_life }}</strong>
                </div>
            @endif
        </div>

        @if($product->composition)
            <div class="product-info-block">
                <h3>Состав</h3>
                <p>{{ $product->composition }}</p>
            </div>
        @endif

        @if($product->storage_conditions)
            <div class="product-info-block">
                <h3>Условия хранения</h3>
                <p>{{ $product->storage_conditions }}</p>
            </div>
        @endif

        @if($product->recommendations)
            <div class="product-info-block">
                <h3>Рекомендации по кормлению</h3>
                <p>{{ $product->recommendations }}</p>
            </div>
        @endif

        @auth
            <form
                method="POST"
                action="{{ route('product.reviews.store', $product) }}"
                enctype="multipart/form-data"
                class="review-form"
            >
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

                <button type="submit" class="btn product-btn">
                    Оставить отзыв
                </button>
            </form>
        @else
            <p class="no-reviews">
                Чтобы оставить отзыв, <a href="{{ route('login') }}">авторизуйтесь</a>.
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
                                            src="{{ $review->user->avatar }}"
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

    </section>
</div>

<script>
function changeProductImage(el) {
    const mainImage = document.getElementById('mainProductImage');

    if (!mainImage) return;

    mainImage.src = el.src;

    document.querySelectorAll('.product-thumb').forEach((img) => {
        img.classList.remove('active');
    });

    el.classList.add('active');
}

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

function toggleFavorite(button) {
    const productId = button.dataset.productId;

    fetch(`/favorites/${productId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        button.textContent = data.is_favorite ? 'В избранном' : 'В избранное';
        button.classList.toggle('is-active', data.is_favorite);
    });
}
</script>
@endsection