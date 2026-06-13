@extends('admin.layouts.app')

@section('title', 'Создание промокода')

@section('content')

<div class="container">

    <div class="dashboard-header">
        <h1>Создать промокод</h1>

        <a href="{{ route('admin.promocodes.index') }}" class="btn-secondary">
            Назад
        </a>
    </div>

    <div class="dashboard-card">

        <form action="{{ route('admin.promocodes.store') }}" method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label>Код промокода</label>
                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Название</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Тип скидки</label>

                    <select name="type">
                        <option value="percent">Процент</option>
                        <option value="fixed">Фиксированная сумма</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Значение</label>
                    <input
                        type="number"
                        step="0.01"
                        name="value"
                        value="{{ old('value') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Минимальная сумма заказа</label>
                    <input
                        type="number"
                        step="0.01"
                        name="min_order_amount"
                        value="{{ old('min_order_amount') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Лимит использований</label>
                    <input
                        type="number"
                        name="usage_limit"
                        value="{{ old('usage_limit') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Дата начала</label>
                    <input
                        type="datetime-local"
                        name="starts_at"
                    >
                </div>

                <div class="form-group">
                    <label>Дата окончания</label>
                    <input
                        type="datetime-local"
                        name="expires_at"
                    >
                </div>

            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                    >
                    Активный промокод
                </label>
            </div>

            <button class="btn-primary">
                Создать промокод
            </button>

        </form>

    </div>

</div>

@endsection