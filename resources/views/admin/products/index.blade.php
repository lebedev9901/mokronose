@extends('admin.layouts.app')

@section('title', 'Товары')

@section('page-title', 'Товары')
@section('page-subtitle', 'Управление товарами магазина')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Список товаров</h2>
        <p>Всего товаров: {{ $products->count() }}</p>
    </div>

    <a href="{{ route('admin.products.create') }}" class="admin-btn">
        + Добавить товар
    </a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Остаток</th>
                <th>Категории</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td class="admin-muted">#{{ $product->id }}</td>

                    <td>
                        <div class="admin-thumbs">
                            @forelse($product->images->take(2) as $img)
                                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $product->title }}">
                            @empty
                                <div class="admin-no-image">Нет фото</div>
                            @endforelse

                            @if($product->images->count() > 2)
                                <div class="admin-more">
                                    +{{ $product->images->count() - 2 }}
                                </div>
                            @endif
                        </div>
                    </td>

                    <td>
                        <strong class="admin-product-title">
                            {{ $product->title }}
                        </strong>
                    </td>

                    <td>
                        <strong>{{ number_format($product->price, 0, ',', ' ') }} ₽</strong>
                    </td>

                    <td>
                        @if($product->stock > 0)
                            <span class="admin-status admin-status--success">
                                {{ $product->stock }} шт.
                            </span>
                        @else
                            <span class="admin-status admin-status--danger">
                                Нет
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="admin-tags">
                            @forelse($product->categories as $category)
                                <span>{{ $category->title }}</span>
                            @empty
                                <span>Без категории</span>
                            @endforelse
                        </div>
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Удалить товар?')">
                                @csrf
                                @method('DELETE')

                                <button class="admin-btn-danger">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="admin-empty">
                        Товары пока не добавлены
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection