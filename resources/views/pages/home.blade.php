@extends('layouts.app')

@section('title', 'МокроНос')

@section('content')

@section('description', 'Товары для животных в интернет-магазине Мокронос.')

<section class="hero-new">
    <div class="container">
        <div class="hero-new__card">
            <div class="hero-new__content">
                <span class="hero-new__label">натуральные лакомства</span>
                <span class="hero-new__label">собственное производство</span>
                <span class="hero-new__label">100% мяса</span>
                <span class="hero-new__label">ручная сушка</span>
                <span class="hero-new__label">без химии</span>

                <h1 class="hero-new__title">
                    Лакомства для собак ручной работы
                </h1>

                <p class="hero-new__text">
                    Сделай первый заказ со скидкой 10% по
                    промокоду: <strong>MOKRONOS10</strong>
                </p>

                <a href="{{ route('catalog') }}" class="hero-new__btn">
                    Заказать лакомство
                </a>

                <p class="hero-new__note">
                    С любовью, МокроНос
                </p>
            </div>

            <div class="hero-new__slider swiper heroVerticalSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/hero_img1.jpg') }}" alt="Лакомства МокроНос">
                    </div>

                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/hero_img2.jpg') }}" alt="Натуральные лакомства">
                    </div>

                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/hero_img3.jpg') }}" alt="Товары для собак">
                    </div>

                    <div class="swiper-slide">
                        <img src="{{ asset('assets/img/hero_img4.jpg') }}" alt="Лакомства для питомцев">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($news->isNotEmpty())
<section class="stories-news">
    <div class="container">
        <div class="stories-news__head">
            <h2>Новости МокроНос</h2>
            <p>Акции, обновления и полезная информация для владельцев собак</p>
        </div>

        <div class="stories-news__list">
            @foreach($news as $item)
                <button
                    class="stories-news__item"
                    type="button"
                    data-news-title="{{ $item->title }}"
                    data-news-text="{{ $item->description }}"
                    data-news-date="{{ optional($item->published_at ?? $item->created_at)->format('d.m.Y') }}"
                    data-news-image="{{ asset('storage/' . $item->image) }}"
                    data-news-button-text="{{ $item->button_text }}"
                    data-news-button-url="{{ $item->button_url }}"
                >
                    <span class="stories-news__circle">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </span>

                    <span class="stories-news__name">
                        {{ Str::limit($item->title, 18) }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>
</section>

<div class="news-modal" id="newsModal">
    <div class="news-modal__overlay" data-news-close></div>

    <div class="news-modal__content">
        <button class="news-modal__close" type="button" data-news-close>×</button>

        <img class="news-modal__image" id="newsModalImage" src="" alt="">

        <div class="news-modal__body">
            <span class="news-modal__date" id="newsModalDate"></span>
            <h3 class="news-modal__title" id="newsModalTitle"></h3>
            <p class="news-modal__text" id="newsModalText"></p>

            <a class="news-modal__button" id="newsModalButton" href="#" style="display:none;">
                Подробнее
            </a>
        </div>
    </div>
</div>
@endif

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
<div class="site-notice-modal" id="orderNoticeModal">
    <div class="site-notice-modal__overlay" data-notice-close></div>

    <div class="site-notice-modal__card">
        <button type="button" class="site-notice-modal__close" data-notice-close>
            ×
        </button>

        <div class="site-notice-modal__icon">🐶</div>

        <h2>Приём заказов в выходные</h2>

        <p>
        МокроНос принимает заказы без выходных. Если вы оформили заказ после 18:00 пятницы или в выходные дни, мы обработаем его в понедельник и свяжемся с вами для подтверждения.
        </p>

        <button type="button" class="site-notice-modal__btn" data-notice-close>
            Понятно
        </button>
    </div>
</div>

<div class="site-notice-modal" id="vkNoticeModal">
    <div class="site-notice-modal__overlay" data-vk-notice-close></div>

    <div class="site-notice-modal__card">
        <button type="button" class="site-notice-modal__close" data-vk-notice-close>
            ×
        </button>

        <div class="site-notice-modal__icon">💬</div>

        <h2>Уведомления в VK</h2>

        <p>
            Для получения уведомлений о заказе, необходимо написать нам в сообщество, если ранее чата с сообществом не было. 
            <a href="https://vk.me/mokronose" target="_blank" class="btn-secondary">
                Написать в VK
            </a>
        </p>

        <button type="button" class="site-notice-modal__btn" data-vk-notice-close>
            Хорошо
        </button>
    </div>
</div>


<script>
console.log('JS работает');
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.heroVerticalSwiper', {
        direction: 'vertical',
        loop: true,
        speed: 700,
        autoplay: {
            delay: 2800,
            disableOnInteraction: false,
        },
        effect: 'slide',
        slidesPerView: 1,
        allowTouchMove: true,
        mousewheel: false,
    });
});
</script>
@endpush

@endsection