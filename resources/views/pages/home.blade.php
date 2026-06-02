@extends('layouts.app')

@section('title', 'МокроНос')

@section('content')

@section('description', 'Товары для животных в интернет-магазине Мокронос.')
@if($news->isNotEmpty())
<section class="home-news">
<div class="container">
    <div class="home-news__header">
        <h2>Новости МокроНос</h2>
        <p>Акции, обновления и полезная информация для владельцев собак</p>
    </div>

    <div class="home-news__slider">
        @foreach($news as $item)
            <article class="home-news-card">

    <img
        src="{{ asset('storage/' . $item->image) }}"
        alt="{{ $item->title }}"
        class="home-news-card__image"
    >

    <div class="home-news-card__overlay"></div>

    <div class="home-news-card__content">

        <h3>{{ $item->title }}</h3>

        <p>
            {{ Str::limit($item->description, 90) }}
        </p>

        <div class="home-news-card__buttons">

            @if($item->button_text && $item->button_url)
                <a href="{{ $item->button_url }}">
                    {{ $item->button_text }}
                </a>
            @endif

        </div>

    </div>
<script>
document.querySelectorAll('.home-news__slider').forEach(slider => {
    slider.addEventListener('wheel', function(e) {
        if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
            e.preventDefault();
            slider.scrollLeft += e.deltaY;
        }
    }, { passive: false });
});
</script>
</article>
        @endforeach
    </div>
</div>
</section>
@endif
<div class="hero">
                <div class="container">
                    <div class="hero__contain flex">
                        <h1 class="hero__title">
                            Натуральные лакомства для собак
                        </h1>
                        <div class="hero__bottom">
                            <ul class="list-reset flex hero__subtitle">
                                <li class="hero__subtitle-item">
                                    100% мясо
                                </li>
                                <li class="hero__subtitle-item">
                                    без химии 
                                </li>
                                <li class="hero__subtitle-item">
                                    ручная сушка
                                </li>
                            </ul>
                            <div class="hero__image">
                                <img src="{{asset('assets/img/hero_img1.jpg')}}" alt="hero1">
                                <img src="{{asset('assets/img/hero_img2.jpg')}}" alt="hero2">
                                <img src="{{asset('assets/img/hero_img3.jpg')}}" alt="hero3">
                                <img src="{{asset('assets/img/hero_img4.jpg')}}" alt="hero4">
                                <img src="{{asset('assets/img/hero_img5.jpg')}}" alt="hero5">
                                <img src="{{asset('assets/img/hero_img6.jpg')}}" alt="hero6">
                            </div>
                            
                            <a href="{{route('catalog')}}" class="hero__btn ">
                                Перейти в каталог
                            </a>
                            <p class="hero__subdesc">
                                Сделай первый заказ для совего любимца со скидкой 10%, с любовью МокоНос!
                            </p>
                            <p class="hero__note">
                                * Все товары сертифицированы. Актуальную информацию читайте в описании товара
                            </p>
                        </div>
                       
                    </div>
                </div>
            </div>
            <section class="advantages">
                <div class="container">
                    <h2 class="advantages__title">
                        Почему выбирают «МокроНос»
                    </h2>

                    <ul class="advantages__list list-reset">
                        <li class="advantages__item">
                            <span class="advantages__icon">🔥</span>
                            <h3>Индивидуальность</h3>
                            <p>Найдет подход к каждому клиенту</p>
                        </li>

                        <li class="advantages__item">
                            <span class="advantages__icon">🥩</span>
                            <h3>Сделано руками</h3>
                            <p>Ручная механическая обработка сырья</p>
                        </li>

                        <li class="advantages__item">
                            <span class="advantages__icon">🐶</span>
                            <h3>Наличие</h3>
                            <p>Широкий ассортимент на любой вкус</p>
                        </li>

                        <li class="advantages__item">
                            <span class="advantages__icon">🩺</span>
                            <h3>Ветеринарный контроль</h3>
                            <p>Контроль качества на каждом этапе</p>
                        </li>

                        <li class="advantages__item">
                            <span class="advantages__icon">🤝</span>
                            <h3>Стиль работы</h3>
                            <p>Прозрачность и честность</p>
                        </li>

                        <li class="advantages__item">
                            <span class="advantages__icon">📦</span>
                            <h3>Удобная доставка</h3>
                            <p>Быстро и аккуратно по всей России</p>
                        </li>
                    </ul>
                </div>
        </section>
        <section class="products-preview">
    <div class="container">
        <h2 class="section__title">Популярные лакомства</h2>

        <div class="products__contain">
            @foreach($products as $product)
            <article class="product-card" >
                <div class="product-image" >
                   @php
                        $preview = $product->images->where('is_preview', true)->first()
                            ?? $product->images->first();
                    @endphp

                    <img
                        src="{{ $preview
                            ? asset('storage/' . $preview->image)
                            : asset('assets/img/no-image.png') }}"
                        alt="{{ $product->title }}"
                    >
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
                        
                         <form>
                        @csrf

                        @php 
                            $cartQty = $cartQuantities[$product->id] ?? 0;
                        @endphp

                        <div
                            class="product-cart-control"
                            data-product="{{ $product->id }}"
                        >
                            <button
                                type="button"
                                class="btn product-btn add-to-cart"
                                data-id="{{ $product->id }}"
                                style="{{ $cartQty > 0 ? 'display:none;' : '' }}"
                            >
                                В корзину
                            </button>

                            <div class="cart-qty-control {{ $cartQty > 0 ? '' : 'hidden' }}">
                                
                                <button type="button" class="qty-btn qty-minus">
                                    −
                                </button>

                                <span class="qty-value">
                                    {{ $cartQty > 0 ? $cartQty : 1 }}
                                </span>

                                <button type="button" class="qty-btn qty-plus">
                                    +
                                </button>

                            </div>
                        </div>
                        </form>
                           <a href="{{route('product', $product->id)}}" class="btn-accent product__link">
                                Подробнее
                            </a>
                        </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
<section class="process">
    <div class="container">
        <h2 class="section-title">Как мы делаем лакомства</h2>
        <p class="section-subtitle">
            Никакой химии — только польза и контроль качества
        </p>

        <div class="process-grid">
            <div class="process-card">
                <span class="step-num">#1</span>
                <h3 class="process-title">Отбор сырья</h3>
                <p class="process-descr">Используем только свежее мясо от проверенных поставщиков</p>
            </div>

            <div class="process-card">
                <span class="step-num">#2</span>
                <h3 class="process-title">Ручная обработка</h3>
                <p class="process-descr">Нарезка и подготовка без автоматизированных линий</p>
            </div>

            <div class="process-card">
                <span class="step-num">#3</span>
                <h3 class="process-title">Сушка</h3>
                <p class="process-descr">Низкотемпературная сушка для сохранения пользы</p>
            </div>

            <div class="process-card">
                <span class="step-num">#4</span>
                <h3 class="process-title">Контроль и упаковка</h3>
                <p class="process-descr">Проверка каждой партии и герметичная упаковка</p>
            </div>
        </div>
    </div>
</section>
<section class="reviews">
    <div class="container">
        <h2 class="section-title">Отзывы наших клиентов</h2>

        <div class="reviews-grid">
            @forelse($reviews as $review)
                <article class="review-card">
                    <div class="review-card-top">
                        <span class="review-rating">⭐ {{ $review->rating }}</span>
                        <span class="review-date">{{ $review->created_at->format('d.m.Y') }}</span>
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
                                <img src="{{ $review->user->avatar }}" alt="{{ $review->user?->name }}">
                            @else
                                <span>{{ mb_substr($review->user?->name ?? 'П', 0, 1) }}</span>
                            @endif
                        </div>

                        <div class="review-right">
                            <strong class="review-name">
                                {{ $review->user?->first_name ?? $review->user?->name ?? 'Пользователь' }}
                            </strong>

                            <a href="{{ route('product', $review->product) }}" class="reviews-product">
                                {{ $review->product->title }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="no-reviews">
                    Никто не оставил отзыв
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="faq">
    <div class="container">
        <h2 class="section-title">Часто задаваемые вопросы</h2>

        <div class="faq-list">

            <details class="faq-item">
                <summary>Из чего сделаны лакомства?</summary>
                <p>Для наших продуктов мы выбираем только лучшее: сырье первой категории, которое безопасно для употребления в пищу людьми. Это легкое, печень, сердца, желудки и филе разных животных. Вы не найдете у нас "мяса для собак" – это сырье самого низкого качества, которое часто идет на утилизацию. Все, что не предназначено для прилавков магазинов для людей, например, бычьи пенисы, бараньи носы с шерстью или говяжьи уши, проходит строгий личный контроль нашего технолога. Он лично оценивает качество каждого такого ингредиента, даже если есть все необходимые документы.</p>
            </details>

            <details class="faq-item">
                <summary>Подойдут ли лакомства для щенков?</summary>
                <p>Конечно, лакомства для щенков – это прекрасный выбор! Они не только служат отличным инструментом для дрессировки и поощрения, но и часто обогащены полезными веществами, которые важны для правильного развития вашего малыша.</p>
            </details>

            <details class="faq-item">
                <summary>Есть ли в составе химия или добавки?</summary>
                <p>Ни в коем случае! Мы сами любим своих питомцев и хотим давать им только самое лучшее. Поэтому в наших лакомствах только натуральные продукты, без всякой химии и добавок.</p>
            </details>

            <details class="faq-item">
                <summary>Как хранить лакомства?</summary>
                <p>Все наши лакомства нужно хранить сухом темном месте при температуре от 10 до 25 градусов при относительной влажности менее 75% не более 6 месяцев в таком месте, чтобы хвостик не смог их достать.</p>
                <p>Лакомства полностью высушены, поэтому их можно хранить в тех упаковках, в которых они к вам приехали. Если вы вскрыли упаковку, вы можете оставить хранить лакомства в ней, используя прищепку, либо их можно пересыпать в контейнер или банку с  крышкой. Мы рекомендуем закрывать лакомства, чтобы они сохраняли свой вкусный запах, и в них не могли проникнуть насекомые.</p>

            </details>

            <details class="faq-item">
                <summary>Как оформить заказ?</summary>
                <p>Вы проходите регистрацию на сайте и далее добавляете нужные вам позиции в корзину и проходите оформление доставки. Все заказы, сформированные на сайте, осуществляются по 100% предоплате
                Сроки сборки заказа лакомств из наличия на сайте 2-4 рабочих дня. (сб, вс - нерабочие дни).</p>
                <p>
                    После вашей заявки на сайте менеджер проверяет состав заказа. Если в заказе будут лакомства, которые по мнению менеджера не подходят вашей собаке (размер лакомств не соответствует размеру собаки, либо вы выбрали лакомства, которые вашему щенку еще рано кушать), он сообщит об этом и предложит альтернативу.
                </p>
            </details>

            <details class="faq-item">
                <summary>Можно ли получить консультацию?</summary>
                <p>Конечно, вы всегда можете написать в поддержку, где вас проконсультируют по лакомствам и подскажут, что лучше может подойти </p>
            </details>

        </div>
    </div>
</section>
<script>
console.log('JS работает');
</script>
@endsection