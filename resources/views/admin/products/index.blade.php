@extends('admin.layouts.app')

@section('title', 'Товары')

@section('content')

<h1>Товары</h1>
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.products.create') }}"
       class="btn btn-primary">
        + Добавить товар
    </a>
</div>
<table class="table">

    <thead>
        <tr>
            <th>ID</th>
            <th>Фото</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Остаток</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
    </thead>

    <tbody>

        @foreach($products as $product)

            <tr>

                <td>
                    {{ $product->id }}
                </td>

                <td>
                    <div class="thumbs">
                        @foreach($product->images->take(2) as $img)
                            <img src="{{ asset('storage/' . $img->image) }}">
                        @endforeach

                        @if($product->images->count() > 2)
                            <div class="more">
                                +{{ $product->images->count() - 2 }}
                            </div>
                        @endif
                    </div>
                </td>

                <td>
                    {{ $product->title }}
                </td>

                <td>
                    {{ $product->price }} ₽
                </td>
                <td>
                    {{ $product->stock }} 
                </td>
                <td>
                    @foreach($product->categories as $category)
                    <span style="
                        display:inline-block;
                        padding:3px 8px;
                        background:#eee;
                        border-radius:6px;
                        margin:2px;
                        font-size:12px;
                        color: black;
                    ">
                        {{ $category->title }}
                    </span>
                @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                   class="btn btn-primary" style="padding: 6px 10px">
                        Редактировать
                    </a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Удалить товар?')">

                        @csrf
                        @method('DELETE')

                         <button class="btn btn-danger" style="padding:6px 10px;">
                            Удалить
                        </button>

                    </form>
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

@endsection