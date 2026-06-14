@extends('admin.layouts.app')

@section('title', 'Новости')
@section('page-title', 'Новости')
@section('page-subtitle', 'Управление баннерами и новостями на главной')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Список новостей</h2>
        <p>Всего новостей: {{ $news->count() }}</p>
    </div>

    <a href="{{ route('admin.news.create') }}" class="admin-btn">
        + Создать новость
    </a>
</div>

<div class="admin-news-grid">
    @forelse($news as $item)
        <div class="admin-news-card">

            <div class="admin-news-card__image">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                @else
                    <span>Нет фото</span>
                @endif
            </div>

            <div class="admin-news-card__body">
                <div class="admin-news-card__top">
                    @if($item->is_active)
                        <span class="admin-status admin-status--success">Активна</span>
                    @else
                        <span class="admin-status admin-status--danger">Скрыта</span>
                    @endif

                    <span class="admin-muted">Сортировка: {{ $item->sort_order }}</span>
                </div>

                <h3>{{ $item->title }}</h3>

                <p>{{ \Illuminate\Support\Str::limit($item->description, 140) }}</p>

                @if($item->published_at)
                    <div class="admin-news-date">
                        Дата публикации: {{ $item->published_at->format('d.m.Y H:i') }}
                    </div>
                @endif

                <div class="admin-actions">
                    <a href="{{ route('admin.news.edit', $item) }}" class="admin-btn-light">
                        Редактировать
                    </a>

                    <form action="{{ route('admin.news.destroy', $item) }}"
                          method="POST"
                          onsubmit="return confirm('Удалить новость?')">
                        @csrf
                        @method('DELETE')

                        <button class="admin-btn-danger">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @empty
        <div class="admin-form-card">
            <p class="admin-empty-text">Новостей пока нет.</p>
        </div>
    @endforelse
</div>

@endsection