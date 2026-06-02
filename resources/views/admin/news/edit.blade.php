@extends('admin.layouts.app')

@section('title', 'Редактировать новость')

@section('content')

<h1>Редактировать новость</h1>

<form action="{{ route('admin.news.update', $news) }}"
      method="POST"
      enctype="multipart/form-data"
      style="display:grid; gap:15px; max-width:700px;">

    @csrf
    @method('PUT')

    <div>
        <label>Заголовок</label>
        <input type="text" name="title" value="{{ $news->title }}" required>
    </div>

    <div>
        <label>Описание</label>
        <textarea name="description">{{ $news->description }}</textarea>
    </div>

    @if($news->image)
        <div>
            <label>Текущее фото</label>
            <br>
            <img src="{{ asset('storage/' . $news->image) }}"
                 style="width:200px; height:120px; object-fit:cover; border-radius:12px;">
        </div>
    @endif

    <div>
        <label>Новое фото</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <div>
        <label>Текст кнопки</label>
        <input type="text" name="button_text" value="{{ $news->button_text }}">
    </div>

    <div>
        <label>Ссылка кнопки</label>
        <input type="text" name="button_url" value="{{ $news->button_url }}">
    </div>

    <div>
        <label>Порядок сортировки</label>
        <input type="number" name="sort_order" value="{{ $news->sort_order }}">
    </div>

    <div>
        <label>Дата публикации</label>
        <input
            type="datetime-local"
            name="published_at"
            value="{{ $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '' }}"
        >
    </div>

    <label>
        <input type="checkbox" name="is_active" {{ $news->is_active ? 'checked' : '' }}>
        Активна
    </label>

    <button class="btn btn-primary">
        Сохранить
    </button>

</form>

@endsection