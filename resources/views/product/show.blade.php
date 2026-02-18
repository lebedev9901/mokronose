@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->title }}</h1>

    <div class="product-gallery">
        @foreach($product->images as $img)
            <img src="{{ $img->image }}">
        @endforeach
    </div>

    <p>{{ $product->description }}</p>

    <strong>{{ $product->price }} ₽</strong>

    <form action="{{ route('cart.add', $product) }}" method="POST">
    @csrf
    <button type="submit">В корзину</button>
</form>
</div>
@endsection
