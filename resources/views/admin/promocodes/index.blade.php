@extends('admin.layouts.app')

@section('title', 'Промокоды')
@section('page-title', 'Промокоды')
@section('page-subtitle', 'Управление скидками и промокодами')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Список промокодов</h2>
        <p>Всего промокодов: {{ $promocodes->total() }}</p>
    </div>

    <a href="{{ route('admin.promocodes.create') }}" class="admin-btn">
        + Создать промокод
    </a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Код</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Значение</th>
                <th>Использовано</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($promocodes as $promocode)
                <tr>
                    <td class="admin-muted">#{{ $promocode->id }}</td>

                    <td>
                        <span class="admin-promocode-code">
                            {{ $promocode->code }}
                        </span>
                    </td>

                    <td>
                        <strong>{{ $promocode->title ?? 'Без названия' }}</strong>
                    </td>

                    <td>
                        @if($promocode->type === 'percent')
                            <span class="admin-status admin-status--info">Процент</span>
                        @else
                            <span class="admin-status admin-status--warning">Фиксированная</span>
                        @endif
                    </td>

                    <td>
                        <strong>
                            @if($promocode->type === 'percent')
                                {{ $promocode->value }}%
                            @else
                                {{ number_format($promocode->value, 0, ',', ' ') }} ₽
                            @endif
                        </strong>
                    </td>

                    <td>
                        {{ $promocode->used_count }}
                        @if($promocode->usage_limit)
                            / {{ $promocode->usage_limit }}
                        @endif
                    </td>

                    <td>
                        @if($promocode->is_active)
                            <span class="admin-status admin-status--success">Активен</span>
                        @else
                            <span class="admin-status admin-status--danger">Выключен</span>
                        @endif
                    </td>

                    <td>
                        <div class="admin-actions">
                            <a href="{{ route('admin.promocodes.edit', $promocode) }}"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form action="{{ route('admin.promocodes.destroy', $promocode) }}"
                                  method="POST"
                                  onsubmit="return confirm('Удалить промокод?')">
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
                    <td colspan="8" class="admin-empty">
                        Промокодов пока нет
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-pagination">
    {{ $promocodes->links() }}
</div>

@endsection