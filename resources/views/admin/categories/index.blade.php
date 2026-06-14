@extends('admin.layouts.app')

@section('title', 'Категории')
@section('page-title', 'Категории')
@section('page-subtitle', 'Управление категориями и подкатегориями')

@section('content')

<div class="admin-form-card admin-category-create">
    <h3>Добавить категорию</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-category-form">
        @csrf

        <div class="admin-field">
            <label>Название категории</label>
            <input type="text" name="title" placeholder="Например: Сухой корм" required>
        </div>

        <div class="admin-field">
            <label>Родительская категория</label>
            <select name="parent_id">
                <option value="">Без родителя — основная категория</option>

                @foreach($categories->whereNull('parent_id') as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="admin-btn">
            Добавить
        </button>
    </form>
</div>

<div class="admin-page-head">
    <div>
        <h2>Список категорий</h2>
        <p>Всего категорий: {{ $categories->count() }}</p>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Категория</th>
                <th>Тип</th>
                <th>Товаров</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($categories as $cat)
                <tr>
                    <td>
                        <strong>
                            @if($cat->parent_id)
                                — {{ $cat->title }}
                            @else
                                {{ $cat->title }}
                            @endif
                        </strong>
                    </td>

                    <td>
                        @if($cat->parent_id)
                            <span class="admin-status admin-status--info">Подкатегория</span>
                        @else
                            <span class="admin-status admin-status--success">Основная</span>
                        @endif
                    </td>

                    <td>
                        <strong>{{ $cat->products_count }}</strong>
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Удалить категорию?')">
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
                    <td colspan="4" class="admin-empty">
                        Категории пока не добавлены
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection