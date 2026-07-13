@extends('layouts.app')


@section('content')

<div class="container">


    <h1>
        ✅ Оплата прошла успешно!
    </h1>


    <p>
        Спасибо за заказ.
        Мы уже начали его обработку.
    </p>



    <a href="{{ route('home') }}">

        Вернуться в магазин

    </a>


</div>

@endsection