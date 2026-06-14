@extends('admin.layouts.app')

@section('title', 'Редактировать новость')
@section('page-title', 'Редактировать новость')
@section('page-subtitle', $news->title)

@section('content')

<form action="{{ route('admin.news.update', $news) }}"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    @csrf
    @method('PUT')

    <div class="admin-form-card">
        <h3>Основная информация</h3>

        <div class="admin-field">
            <label>Заголовок</label>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" required>
        </div>

        <div class="admin-field">
            <label>Описание</label>
            <textarea name="description">{{ old('description', $news->description) }}</textarea>
        </div>

        @if($news->image)
            <div class="admin-current-news-image">
                <label>Текущее фото</label>
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
            </div>
        @endif

        <div class="admin-field">
            <label>Новое фото</label>
            <input type="file" name="image" accept="image/*">
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Кнопка и публикация</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Текст кнопки</label>
                <input type="text" name="button_text" value="{{ old('button_text', $news->button_text) }}">
            </div>

            <div class="admin-field">
                <label>Ссылка кнопки</label>
                <input type="text" name="button_url" value="{{ old('button_url', $news->button_url) }}">
            </div>

            <div class="admin-field">
                <label>Порядок сортировки</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $news->sort_order) }}">
            </div>

            <div class="admin-field">
                <label>Дата публикации</label>
                <input type="datetime-local"
                       name="published_at"
                       value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>

        <label class="admin-switch">
            <input type="checkbox" name="is_active" {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
            <span>Активна</span>
        </label>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.news') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить
        </button>
    </div>

</form>

@endsection