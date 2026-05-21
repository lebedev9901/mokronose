@extends('admin.layouts.app')

@section('title', 'Редактирование категории')

@section('content')

<h1>Редактирование категории</h1>

<form action="{{ route('admin.categories.update', $category->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    {{-- TITLE --}}
    <div>
        <label>Название</label>
        <input type="text"
               name="title"
               value="{{ old('title', $category->title) }} required">

        <label>Родительская категория</label>
    <select name="parent_id">
        <option value="">Без родителя — основная категория</option>

        @foreach($categories->whereNull('parent_id') as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>
                {{ $parent->title }}
            </option>
        @endforeach
    </select>
    </div>

    <button class="btn btn-primary">
        Сохранить
    </button>

</form>

@endsection