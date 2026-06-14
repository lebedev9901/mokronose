@extends('layouts.app')

@section('title', 'Отзывы')

@section('content')
<div class="container">
    <div class="reviews__contain flex">

  

    <h1>Отзывы клиентов</h1>

    <div class="reviews-grid">

        @foreach($reviews as $review)
            <div class="reviews__card">

    <!-- ⭐ Рейтинг -->
    <div class="reviews__card-rating">
        @for($i = 1; $i <= 5; $i++)
            <span class="{{ $i <= $review->rating ? 'star active' : 'star' }}">
                ★
            </span>
        @endfor
    </div>

    <!-- 💬 Текст -->
    <p class="reviews__card-text">
        {{ $review->text }}
    </p>

    <!-- 👤 Пользователь -->
    <div class="reviews__card-user">
        <div class="avatar">
    @if($review->user?->avatar)
        <img
            src="{{ $review->user->avatar }}"
            alt="{{ $review->user?->name }}"
            class="avatar-img"
        >
    @else
        {{ mb_substr($review->user?->name ?? 'П', 0, 1) }}
    @endif
</div>
        <div>
            <div class="name">{{ $review->user->name }}</div>
            <div class="date">{{ $review->created_at->format('d.m.Y') }}</div>
        </div>
    </div>

    <!-- 📦 Товар -->
    <a href="{{ route('product', $review->product->id) }}" class="reviews__card-product">
        {{ $review->product->title }}
    </a>

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