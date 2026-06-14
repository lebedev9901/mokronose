@extends('admin.layouts.app')

@section('title', 'Редактирование промокода')
@section('page-title', 'Редактирование промокода')
@section('page-subtitle', $promocode->code)

@section('content')

<form action="{{ route('admin.promocodes.update', $promocode) }}"
      method="POST"
      class="admin-form">

    @csrf
    @method('PUT')

    <div class="admin-form-card">
        <h3>Основные данные</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Код промокода</label>
                <input type="text"
                       name="code"
                       value="{{ old('code', $promocode->code) }}"
                       required>
            </div>

            <div class="admin-field">
                <label>Название</label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $promocode->title) }}">
            </div>

            <div class="admin-field">
                <label>Тип скидки</label>
                <select name="type">
                    <option value="percent" @selected(old('type', $promocode->type) === 'percent')>
                        Процент
                    </option>

                    <option value="fixed" @selected(old('type', $promocode->type) === 'fixed')>
                        Фиксированная сумма
                    </option>
                </select>
            </div>

            <div class="admin-field">
                <label>Значение</label>
                <input type="number"
                       step="0.01"
                       name="value"
                       value="{{ old('value', $promocode->value) }}"
                       required>
            </div>

            <div class="admin-field">
                <label>Минимальная сумма заказа</label>
                <input type="number"
                       step="0.01"
                       name="min_order_amount"
                       value="{{ old('min_order_amount', $promocode->min_order_amount) }}">
            </div>

            <div class="admin-field">
                <label>Лимит использований</label>
                <input type="number"
                       name="usage_limit"
                       value="{{ old('usage_limit', $promocode->usage_limit) }}">
            </div>

            <div class="admin-field">
                <label>Дата начала</label>
                <input type="datetime-local"
                       name="starts_at"
                       value="{{ old('starts_at', $promocode->starts_at ? $promocode->starts_at->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="admin-field">
                <label>Дата окончания</label>
                <input type="datetime-local"
                       name="expires_at"
                       value="{{ old('expires_at', $promocode->expires_at ? $promocode->expires_at->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>

        <label class="admin-switch">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   @checked(old('is_active', $promocode->is_active))>
            <span>Активный промокод</span>
        </label>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.promocodes.index') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить изменения
        </button>
    </div>

</form>

@endsection