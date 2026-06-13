<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
 <link rel="stylesheet" href="{{asset('assets/css/admin.css')}} ">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="admin-wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">

        <div class="logo">
            Мокронос Admin
        </div>

        <nav class="menu">

            <a href="{{route('admin.dashboard')}}" class="{{ request()->is('admin') ? 'active' : ''}}">
                Dashboard
            </a>

            <a href="{{route('admin.products')}}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                Товары
            </a>
           
            <a href="{{route('admin.categories')}}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                Категории
            </a>


            
            <a href="{{route('admin.users')}}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                Пользователи
            </a>

            <a href="{{route('admin.orders')}}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                Заказы
            </a>

            <a href="{{route('admin.support')}}" class="{{ request()->is('admin/support*') ? 'active' : '' }}">
                Чаты
            </a>

            <a href="{{route('admin.news')}}" class="{{ request()->is('admin/news*') ? 'active' : '' }}">
                Новости 
            </a>
            <a href="{{route('admin.promocodes.index')}}" class="{{ request()->is('admin/promocodes*') ? 'active' : '' }}">
                Промокоды 
            </a>

        </nav>

    </aside>

    {{-- Content --}}
    <main class="content">

        <header class="header">
            Панель управления
        </header>

        <div class="page-content">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>