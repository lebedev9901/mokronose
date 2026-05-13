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
               value="{{ $category->title }}">
    </div>

    <button class="btn btn-primary">
        Сохранить
    </button>

</form>

@endsection