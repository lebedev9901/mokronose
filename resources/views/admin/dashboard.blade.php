@extends('admin.layouts.app')

@section('title', 'Панель управления')

@section('page-title', 'Панель управления')
@section('page-subtitle', 'Статистика магазина Мокронос')

@section('content')

<div class="dashboard-cards">

    <div class="dashboard-card">
        <div class="dashboard-card__icon">📦</div>
        <div>
            <span>Всего товаров</span>
            <strong>{{ $productsCount }}</strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">✅</div>
        <div>
            <span>В наличии</span>
            <strong>{{ $productsInStock }}</strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">🧾</div>
        <div>
            <span>Заказы</span>
            <strong>{{ $ordersCount }}</strong>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-card__icon">👤</div>
        <div>
            <span>Пользователи</span>
            <strong>{{ $usersCount }}</strong>
        </div>
    </div>

    <div class="dashboard-card dashboard-card--sales">
        <div class="dashboard-card__icon">💰</div>
        <div>
            <span>Продажи</span>
            <strong>{{ number_format($totalSales, 0, ',', ' ') }} ₽</strong>
        </div>
    </div>

</div>

@endsection