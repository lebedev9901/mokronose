@extends('admin.layouts.app')

@section('title', 'Редактирование промокода')

@section('content')

<div class="container">

    <div class="dashboard-header">
        <h1>Редактирование промокода</h1>

        <a href="{{ route('admin.promocodes.index') }}" class="btn-secondary">
            Назад
        </a>
    </div>

    <div class="dashboard-card">

        <form
            action="{{ route('admin.promocodes.update', $promocode) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Код промокода</label>
                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $promocode->code) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Название</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $promocode->title) }}"
                    >
                </div>

                <div class="form-group">
                    <label>Тип скидки</label>

                    <select name="type">
                        <option
                            value="percent"
                            @selected($promocode->type === 'percent')
                        >
                            Процент
                        </option>

                        <option
                            value="fixed"
                            @selected($promocode->type === 'fixed')
                        >
                            Фиксированная сумма
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Значение</label>
                    <input
                        type="number"
                        step="0.01"
                        name="value"
                        value="{{ old('value', $promocode->value) }}"
                    >
                </div>

                <div class="form-group">
                    <label>Минимальная сумма заказа</label>
                    <input
                        type="number"
                        step="0.01"
                        name="min_order_amount"
                        value="{{ old('min_order_amount', $promocode->min_order_amount) }}"
                    >
                </div>

                <div class="form-group">
                    <label>Лимит использований</label>
                    <input
                        type="number"
                        name="usage_limit"
                        value="{{ old('usage_limit', $promocode->usage_limit) }}"
                    >
                </div>

            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        @checked($promocode->is_active)
                    >
                    Активный промокод
                </label>
            </div>

            <button class="btn-primary">
                Сохранить изменения
            </button>

        </form>

    </div>

</div>

@endsection