@extends('layouts.app')

@section('title', 'Доставка и оплата')

@section('content')
<div class="container">
 <h1 class="pay__title">Доставка и оплата</h1>

<div class="pay__container flex">

   

    <div class="pay__card flex">
        <span class="pay__card-num">#1</span>
        <div class="pay__card-text flex">
            <h2 class="pay__card-text-title">Общие условия</h2>
            <p class="pay__card-text-descr">
                Оформить заказ на интересующий Вас товар можно на нашем сайте самостоятельно и круглосуточно.
                Сроки сборки заказа лакомств на сайте 2–4 рабочих дня.
            </p>
        </div>
        
    </div>

    <div class="pay__card flex">
         <span class="pay__card-num">#2</span>
         <div class="pay__card-text flex">
            <h2 class="pay__card-text-title">Оплата</h2>
            <p class="pay__card-text-descr">
                Вы можете оплатить заказ онлайн после подтверждения менеджером (Telegram или на сайте).
                Оплата возможна всеми картами РФ.
            </p>
        </div>
    </div>

    <div class="pay__card flex">
        <span class="pay__card-num">#3</span>
        <div class="pay__card-text flex">
        <h2 class="pay__card-text-title">Доставка</h2>
    <p class="pay__card-text-descr">
        Варианты доставки:
    </p>

    <ul class="pay__list">
        <li>г. Подольск</li>
        <li>г. Москва (м. Алма-Атинская)</li>
        <li>доставка по всей России</li>
    </ul>
        
    <div class="pay__delivery-services">

        <div class="pay__service">
            <img src="{{ asset('assets/img/cdek.svg') }}" alt="СДЭК">
            <span>СДЭК</span>
        </div>

        <div class="pay__service">
            <img src="{{ asset('assets/img/yandex-market.png') }}" alt="Яндекс Маркет">
            <span>Яндекс Маркет</span>
        </div>

        <div class="pay__service">
            <img src="{{ asset('assets/img/pochta_russia.png') }}" alt="Почта России">
            <span>Почта России</span>
        </div>

    </div>
</div>
    <p class="pay__card-text">
        Доставка за рубеж осуществляется Почтой России. Стоимость рассчитывается индивидуально.
    </p>

    <p class="pay__card-highlight">
        Доставка до двери только через СДЭК.
    </p>

</div>

    <div class="pay__card flex">
    <span class="pay__card-num">#4</span>
    <div class="pay__card-text flex">
        <h2 class="pay__card-text-title"> Обмен и возврат</h2>
        
        <p class="pay__card-text-descr"><strong>Обмен возможен если:</strong></p>

        <ul class="pay__list">
            <li>товар ненадлежащего качества</li>
            <li>перепутан товар</li>
        </ul>

        <p class="pay__card-text">
            Если товар не подошёл питомцу (аллергия, не понравился и т.д.) — возврат невозможен,
            так как это продовольственный товар.
        </p>

        <p class="pay__card-text"><strong>Если сомневаетесь — обратитесь к менеджеру.</strong></p>
    </div>

</div>
</div>
@endsection