@extends('admin.layouts.app')

@section('title', 'Создать товар')

@section('content')

<h1>Создать товар</h1>

<form action="{{ route('admin.products.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    {{-- Название --}}
    <div>
        <label>Название</label>
        <input type="text" name="title" required>
    </div>

    {{-- Описание --}}
    <div>
        <label>Описание</label>
        <textarea name="description"></textarea>
    </div>

    {{-- Вес --}}
    <div>
        <label>Вес (кг)</label>
        <input type="number" step="0.01" name="weight" required>
    </div>

    {{-- Цена --}}
    <div>
        <label>Цена</label>
        <input type="number" step="0.01" name="price" required>
    </div>

    {{-- Склад --}}
    <div>
        <label>Остаток</label>
        <input type="number" name="stock" value="0">
    </div>

    <select name="category_id">

    @foreach($categories as $category)
    <label style="display:block;">
        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
        {{ $category->title }}
    </label>
@endforeach

</select>

    {{-- Фото --}}
    <div>
        <label>Фото товара</label>
        <input type="file" name="images[]" multiple accept="image/*">
    </div>

    {{-- выбор превью --}}
    <div>
        <label>Какое фото сделать главным?</label>
        <small>Сделаем позже визуально — пока индексом</small>

        <input type="number" name="preview_index" value="0" min="0">
    </div>

    <button type="submit">
        Создать товар
    </button>

</form>

@endsection