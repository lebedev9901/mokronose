<div class="profile-reviews">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">⭐ Мои отзывы</h1>
            <p>Отзывы, которые вы оставляли на товары</p>
        </div>
    </div>

    @forelse($reviews as $review)
        @php
            $product = $review->product;
            $preview = $product?->images->where('is_preview', true)->first()
                ?? $product?->images->first();
        @endphp

        <div class="review-card">

            <div class="review-card__image">
                @if($preview)
                    <img src="{{ asset('storage/' . $preview->image) }}" alt="{{ $product->title }}">
                @else
                    <span>Нет фото</span>
                @endif
            </div>

            <div class="review-card__content">

                <div class="review-card__top">
                    <div>
                        <h3>
                            @if($product)
                                <a href="{{ route('product', $product->id) }}">
                                    {{ $product->title }}
                                </a>
                            @else
                                Товар удалён
                            @endif
                        </h3>

                        <div class="review-date">
                            {{ $review->created_at->format('d.m.Y') }}
                        </div>
                    </div>

                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>

                <p class="review-text">
                    {{ $review->text ?? $review->comment ?? 'Без текста' }}
                </p>

                @if($product)
                    <a href="{{ route('product', $product->id) }}" class="btn-secondary">
                        Смотреть товар
                    </a>
                @endif

            </div>

        </div>
    @empty
        <div class="empty-block">
            <h3>⭐ У вас пока нет отзывов</h3>
            <p>После покупки товара вы сможете оставить отзыв.</p>

            <a href="{{ route('catalog') }}" class="btn-primary">
                Перейти в каталог
            </a>
        </div>
    @endforelse

</div>