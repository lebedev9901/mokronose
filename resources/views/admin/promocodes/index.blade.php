@extends('admin.layouts.app')

@section('title', 'Промокоды')

@section('content')

<div class="container">

    <div class="dashboard-header">
        <h1>Промокоды</h1>

        <a href="{{ route('admin.promocodes.create') }}" class="btn-primary">
            Создать промокод
        </a>
    </div>

    <div class="dashboard-card">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Значение</th>
                    <th>Использовано</th>
                    <th>Активен</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            @forelse($promocodes as $promocode)

                <tr>

                    <td>{{ $promocode->id }}</td>

                    <td>
                        <strong>{{ $promocode->code }}</strong>
                    </td>

                    <td>
                        {{ $promocode->title }}
                    </td>

                    <td>
                        @if($promocode->type === 'percent')
                            Процент
                        @else
                            Фиксированная
                        @endif
                    </td>

                    <td>
                        @if($promocode->type === 'percent')
                            {{ $promocode->value }}%
                        @else
                            {{ $promocode->value }} ₽
                        @endif
                    </td>

                    <td>
                        {{ $promocode->used_count }}

                        @if($promocode->usage_limit)
                            / {{ $promocode->usage_limit }}
                        @endif
                    </td>

                    <td>
                        @if($promocode->is_active)
                            <span class="status status-success">
                                Активен
                            </span>
                        @else
                            <span class="status status-danger">
                                Выключен
                            </span>
                        @endif
                    </td>

                    <td>

                        <div class="table-actions">

                            <a
                                href="{{ route('admin.promocodes.edit', $promocode) }}"
                                class="btn-small"
                            >
                                Изменить
                            </a>

                            <form
                                action="{{ route('admin.promocodes.destroy', $promocode) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn-small btn-danger"
                                    onclick="return confirm('Удалить промокод?')"
                                >
                                    Удалить
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8">
                        Промокодов пока нет
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div style="margin-top:20px;">
            {{ $promocodes->links() }}
        </div>

    </div>

</div>

@endsection