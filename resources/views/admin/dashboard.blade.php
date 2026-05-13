@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard">

    <h1 class="mb-4">📊 Dashboard</h1>

    <div class="dashboard-grid">

        <div class="card">
            <h3>📦 Товары</h3>
            <p>{{ $productsCount }}</p>
        </div>

        <div class="card">
            <h3>📦 В наличии</h3>
            <p>{{ $productsInStock }}</p>
        </div>

        <div class="card">
            <h3>🧾 Заказы</h3>
            <p>{{ $ordersCount }}</p>
        </div>

        <div class="card">
            <h3>👤 Пользователи</h3>
            <p>{{ $usersCount }}</p>
        </div>

        <div class="card highlight">
            <h3>💰 Продажи</h3>
            <p>{{ number_format($totalSales, 0, ',', ' ') }} ₽</p>
        </div>

    </div>

</div>

@endsection