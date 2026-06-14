@extends('admin.layouts.app')

@section('title', 'Создать промокод')
@section('page-title', 'Создать промокод')
@section('page-subtitle', 'Добавление нового промокода')

@section('content')

<form action="{{ route('admin.promocodes.store') }}"
      method="POST"
      class="admin-form">

    @csrf

    <div class="admin-form-card">
        <h3>Основные данные</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Код промокода</label>
                <input type="text"
                       name="code"
                       value="{{ old('code') }}"
                       placeholder="SALE10"
                       required>
            </div>

            <div class="admin-field">
                <label>Название</label>
                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Скидка на первый заказ">
            </div>

            <div class="admin-field">
                <label>Тип скидки</label>
                <select name="type">
                    <option value="percent">Процент</option>
                    <option value="fixed">Фиксированная сумма</option>
                </select>
            </div>

            <div class="admin-field">
                <label>Значение</label>
                <input type="number"
                       step="0.01"
                       name="value"
                       value="{{ old('value') }}"
                       required>
            </div>

            <div class="admin-field">
                <label>Минимальная сумма заказа</label>
                <input type="number"
                       step="0.01"
                       name="min_order_amount"
                       value="{{ old('min_order_amount') }}">
            </div>

            <div class="admin-field">
                <label>Лимит использований</label>
                <input type="number"
                       name="usage_limit"
                       value="{{ old('usage_limit') }}">
            </div>

            <div class="admin-field">
                <label>Дата начала</label>
                <input type="datetime-local" name="starts_at">
            </div>

            <div class="admin-field">
                <label>Дата окончания</label>
                <input type="datetime-local" name="expires_at">
            </div>
        </div>

        <label class="admin-switch">
            <input type="checkbox" name="is_active" value="1" checked>
            <span>Активный промокод</span>
        </label>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.promocodes.index') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Создать промокод
        </button>
    </div>

</form>

@endsection