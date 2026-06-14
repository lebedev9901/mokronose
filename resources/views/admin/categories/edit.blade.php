@extends('admin.layouts.app')

@section('title', 'Редактирование категории')
@section('page-title', 'Редактирование категории')
@section('page-subtitle', $category->title)

@section('content')

<form action="{{ route('admin.categories.update', $category->id) }}"
      method="POST"
      class="admin-form">

    @csrf
    @method('PUT')

    <div class="admin-form-card">
        <h3>Данные категории</h3>

        <div class="admin-field">
            <label>Название</label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $category->title) }}"
                   required>
        </div>

        <div class="admin-field">
            <label>Родительская категория</label>

            <select name="parent_id">
                <option value="">Без родителя — основная категория</option>

                @foreach($categories->whereNull('parent_id') as $parent)
                    @if($parent->id !== $category->id)
                        <option value="{{ $parent->id }}"
                            @selected(old('parent_id', $category->parent_id) == $parent->id)>
                            {{ $parent->title }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.categories') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить
        </button>
    </div>

</form>

@endsection