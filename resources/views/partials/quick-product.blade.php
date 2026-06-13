@php
    $preview = $product->images->where('is_preview', true)->first()
        ?? $product->images->first();
@endphp

<div class="quick-product">
    <div class="quick-product__image">
        <img
            src="{{ $preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png') }}"
            alt="{{ $product->title }}"
        >
    </div>

    <div class="quick-product__info">
        <h3>{{ $product->title }}</h3>

        <p class="quick-product__desc">
            {{ $product->description }}
        </p>

        <div class="quick-product__meta">
            <span>{{ $product->weight }}</span>
            <strong>{{ $product->price }}₽</strong>
        </div>

        <div class="quick-product__badges">
            @if($product->age_group === 'puppy')
                <span>Щенкам</span>
            @elseif($product->age_group === 'junior')
                <span>Юниорам</span>
            @elseif($product->age_group === 'adult')
                <span>Взрослым</span>
            @endif

            @if($product->breed_size === 'small')
                <span>Маленькие породы</span>
            @elseif($product->breed_size === 'medium')
                <span>Средние породы</span>
            @elseif($product->breed_size === 'large')
                <span>Крупные породы</span>
            @elseif($product->breed_size === 'all')
                <span>Для всех пород</span>
            @endif
        </div>

        <a href="{{ route('product', $product->id) }}" class="quick-product__link">
            Перейти к товару
        </a>
    </div>
</div>