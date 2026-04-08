@extends('layouts.app')

@section('title', 'Отзывы')

@section('content')
<div class="container">
    <div class="reviews__contain flex">

  

    <h1>Отзывы клиентов</h1>

    <div class="reviews__cards-contain flex">

        @foreach($reviews as $review)
            <div class="reviews__card flex">

                {{-- Текст отзыва --}}
                <p class="reviews__card-text">
                    "{{ $review->text }}"
                </p>

                {{-- Рейтинг --}}
                <div class="reviews__card-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <span>
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        </span>
                    @endfor
                </div>

                {{-- Пользователь --}}
                <div class="reviews__card-user flex">
                    👤 {{ $review->user->name }}
                </div>

                {{-- Товар --}}
                <div class="reviews__card-product">
                    📦 {{ $review->product->title }}
                </div>

            </div>
        @endforeach
      </div>
           <div class="custom-pagination">
    @if ($reviews->onFirstPage())
        <span class="disabled">«</span>
    @else
        <a href="{{ $reviews->previousPageUrl() }}">«</a>
    @endif

    @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
        @if ($page == $reviews->currentPage())
            <span class="active">{{ $page }}</span>
        @else
            <a href="{{ $url }}">{{ $page }}</a>
        @endif
    @endforeach

    @if ($reviews->hasMorePages())
        <a href="{{ $reviews->nextPageUrl() }}">»</a>
    @else
        <span class="disabled">»</span>
    @endif
</div>
    </div>
</div>
@endsection