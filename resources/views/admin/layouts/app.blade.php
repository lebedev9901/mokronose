<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админка') | Мокронос</title>

    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    <script src="{{ asset('assets/js/script.js') }}" defer></script>
</head>
<body class="admin-body">

<div class="admin">

    <aside class="admin-sidebar">

        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            🐾 Мокронос
            <span>Admin panel</span>
        </a>

        <nav class="admin-nav">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Главная
            </a>

            <a href="{{ route('admin.products') }}"
               class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                Товары
            </a>

            <a href="{{ route('admin.categories') }}"
               class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                Категории
            </a>

            <a href="{{ route('admin.orders') }}"
               class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                Заказы
            </a>

            <a href="{{ route('admin.users') }}"
               class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                Пользователи
            </a>

            <a href="{{ route('admin.support') }}"
               class="{{ request()->routeIs('admin.support*') ? 'active' : '' }}">
                Поддержка
            </a>

            <a href="{{ route('admin.news') }}"
               class="{{ request()->routeIs('admin.news*') ? 'active' : '' }}">
                Новости
            </a>

            <a href="{{ route('admin.promocodes.index') }}"
               class="{{ request()->routeIs('admin.promocodes*') ? 'active' : '' }}">
                Промокоды
            </a>

        </nav>

        <a href="{{ route('home') }}" class="admin-site-link">
            ← На сайт
        </a>

    </aside>

    <main class="admin-main">

        <header class="admin-header">

            <div>
                <h1>@yield('page-title', 'Панель управления')</h1>
                <p>@yield('page-subtitle', 'Управление магазином Мокронос')</p>
            </div>

            <div class="admin-header__actions">

                @auth
                    <div class="notification-widget admin-notification-widget">

                        <button
                            type="button"
                            class="notification-btn admin-notification-btn"
                            id="notificationBtn"
                        >
                            🔔

                            <span
                                id="notificationCount"
                                class="notification-count is-hidden"
                            >
                                0
                            </span>
                        </button>

                        <div
                            class="notification-dropdown admin-notification-dropdown"
                            id="notificationDropdown"
                        >

                            <div class="notification-dropdown__head">
                                <strong>Уведомления</strong>

                                <button
                                    type="button"
                                    id="notificationReadAll"
                                >
                                    Прочитать всё
                                </button>
                            </div>

                            <div
                                id="notificationList"
                                class="notification-list"
                            >
                                <div class="notification-empty">
                                    Загрузка...
                                </div>
                            </div>

                        </div>

                    </div>
                @endauth

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="admin-logout">
                        Выйти
                    </button>
                </form>

            </div>

        </header>

        @if(session('success'))
            <div class="admin-alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </main>

</div>

@stack('scripts')

</body>
</html>