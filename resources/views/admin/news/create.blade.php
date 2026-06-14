@extends('admin.layouts.app')

@section('title', 'Создать новость')
@section('page-title', 'Создать новость')
@section('page-subtitle', 'Добавление новости или баннера на главную')

@section('content')

<form action="{{ route('admin.news.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    @csrf

    <div class="admin-form-card">
        <h3>Основная информация</h3>

        <div class="admin-field">
            <label>Заголовок</label>
            <input type="text" name="title" required>
        </div>

        <div class="admin-field">
            <label>Описание</label>
            <textarea name="description"></textarea>
        </div>

        <div class="admin-field">
            <label>Фото</label>
            <input type="file" name="image" accept="image/*">
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Кнопка и публикация</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Текст кнопки</label>
                <input type="text" name="button_text" placeholder="Подробнее">
            </div>

            <div class="admin-field">
                <label>Ссылка кнопки</label>
                <input type="text" name="button_url" placeholder="/catalog">
            </div>

            <div class="admin-field">
                <label>Порядок сортировки</label>
                <input type="number" name="sort_order" value="0">
            </div>

            <div class="admin-field">
                <label>Дата публикации</label>
                <input type="datetime-local" name="published_at">
            </div>
        </div>

        <label class="admin-switch">
            <input type="checkbox" name="is_active" checked>
            <span>Активна</span>
        </label>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.news') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Создать
        </button>
    </div>

</form>

@endsection