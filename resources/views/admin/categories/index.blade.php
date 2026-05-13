@extends('admin.layouts.app')

@section('title', 'Категории')

@section('content')

<h1>Категории</h1>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <input type="text" name="title" placeholder="Название категории">
    <button class="btn btn-primary">Добавить</button>

</form>

<hr>

<table class="table">

    <tr>
        <th>Категория</th>
        <th>Товаров</th>
        <th>Действия</th>
    </tr>

    @foreach($categories as $cat)

    <tr>

        <td>{{ $cat->title }}</td>

        {{-- 📦 СКОЛЬКО ТОВАРОВ --}}
        <td>
            {{ $cat->products_count }}
        </td>

        <td>

            <a href="{{ route('admin.categories.edit', $cat->id) }}"
               class="btn btn-primary" style="padding:5px 10px;">
                Edit
            </a>

            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                  method="POST"
                  style="display:inline-block;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger" style="padding:5px 10px;">
                    Delete
                </button>

            </form>

        </td>

    </tr>

    @endforeach

</table>

@endsection