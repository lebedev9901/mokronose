@if($products->count())

    @foreach ($products as $product)
        @php
            $preview = $product->images->where('is_preview', true)->first()
                ?? $product->images->first();

            $ageLabels = [
                'puppy' => 'Щенкам',
                'junior' => 'Юниорам',
                'adult' => 'Взрослым',
            ];

            $breedLabels = [
                'small' => 'Маленьким породам',
                'medium' => 'Средним породам',
                'large' => 'Крупным породам',
                'all' => 'Для всех пород',
            ];

            $ageLabel = $ageLabels[$product->age_group] ?? null;
            $breedLabel = $breedLabels[$product->breed_size] ?? null;
        @endphp

        <article
            class="product-card"
            data-title="{{ e($product->title) }}"
            data-desc="{{ e($product->description) }}"
            data-price="{{ $product->price }}₽"
            data-weight="{{ e($product->weight) }}"
            data-rating="{{ $product->rating }}"
            data-image="{{ $preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png') }}"
            data-link="{{ route('product', $product->id) }}"
        >

            @auth
                @php
                    $isFavorite = in_array($product->id, $favoriteIds ?? []);
                @endphp

                <button
                    type="button"
                    class="favorite-btn {{ $isFavorite ? 'is-active' : '' }}"
                    data-product-id="{{ $product->id }}"
                    onclick="toggleFavorite(this)"
                    aria-label="Добавить в избранное"
                >
                    <svg class="favorite-icon" viewBox="0 0 24 24">
                        <path d="M12 21s-6.8-4.4-9.4-8.5C.8 9.6 1.4 5.8 4.4 4.2c2.1-1.2 4.7-.6 6.1 1.2L12 7.2l1.5-1.8c1.4-1.8 4-2.4 6.1-1.2 3 1.6 3.6 5.4 1.8 8.3C18.8 16.6 12 21 12 21z"/>
                    </svg>
                </button>
            @endauth

            <button type="button" class="product-quick-btn" data-product-id="{{ $product->id }}">
                Быстрый просмотр
            </button>

            <div class="product-image">
                <img
                    src="{{ $preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png') }}"
                    alt="{{ $product->title }}"
                    loading="lazy"
                >
            </div>

            <div class="product-info">

                <div class="product-badges">
                    @if($ageLabel)
                        <span class="product-badge">{{ $ageLabel }}</span>
                    @endif

                    @if($breedLabel)
                        <span class="product-badge product-badge--soft">{{ $breedLabel }}</span>
                    @endif
                </div>

                <a href="{{ route('product', $product->id) }}" class="product-title">
                    {{ $product->title }}
                </a>

                <p class="product-desc">
                    {{ $product->description }}
                </p>

                <div class="product-rating">
                    <span class="rating_text">⭐ {{ $product->rating }}</span>
                </div>

                <div class="product-meta">
                    <span class="product-weight">{{ $product->weight }}</span>
                    <span class="product-price">{{ $product->price }}₽</span>
                </div>

                <div class="product-actions" data-id="{{ $product->id }}">

                    <form class="product-cart-form">
                        @csrf

                        @php
                            $cartQty = $cartQuantities[$product->id] ?? 0;
                        @endphp

                        <div class="product-cart-control" data-product="{{ $product->id }}">

                            <button
                                type="button"
                                class="btn product-btn add-to-cart"
                                data-id="{{ $product->id }}"
                                style="{{ $cartQty > 0 ? 'display:none;' : '' }}"
                            >
                                В корзину
                            </button>

                            <div class="cart-qty-control {{ $cartQty > 0 ? '' : 'hidden' }}">

                                <button type="button" class="qty-btn qty-minus">−</button>

                                <span class="qty-value">
                                    {{ $cartQty > 0 ? $cartQty : 1 }}
                                </span>

                                <button type="button" class="qty-btn qty-plus">+</button>

                            </div>

                        </div>
                    </form>

                    <a href="{{ route('product', $product->id) }}" class="btn-accent product__link">
                        Подробнее
                    </a>

                </div>
                
            </div>
                
        </article>
    @endforeach

@else

    <div class="catalog-empty">
        <h3>Товары не найдены</h3>
        <p>Попробуйте изменить фильтры или выбрать другую категорию.</p>
    </div>

@endif