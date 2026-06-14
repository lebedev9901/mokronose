<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Админка'); ?> | Мокронос</title>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/normalize.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin.css')); ?>">

    <script src="<?php echo e(asset('assets/js/script.js')); ?>" defer></script>
</head>
<body class="admin-body">

<div class="admin">

    <aside class="admin-sidebar">

        <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-logo">
            🐾 Мокронос
            <span>Admin panel</span>
        </a>

        <nav class="admin-nav">

            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                Главная
            </a>

            <a href="<?php echo e(route('admin.products')); ?>"
               class="<?php echo e(request()->routeIs('admin.products*') ? 'active' : ''); ?>">
                Товары
            </a>

            <a href="<?php echo e(route('admin.categories')); ?>"
               class="<?php echo e(request()->routeIs('admin.categories*') ? 'active' : ''); ?>">
                Категории
            </a>

            <a href="<?php echo e(route('admin.orders')); ?>"
               class="<?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                Заказы
            </a>

            <a href="<?php echo e(route('admin.users')); ?>"
               class="<?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                Пользователи
            </a>

            <a href="<?php echo e(route('admin.support')); ?>"
               class="<?php echo e(request()->routeIs('admin.support*') ? 'active' : ''); ?>">
                Поддержка
            </a>

            <a href="<?php echo e(route('admin.news')); ?>"
               class="<?php echo e(request()->routeIs('admin.news*') ? 'active' : ''); ?>">
                Новости
            </a>

            <a href="<?php echo e(route('admin.promocodes.index')); ?>"
               class="<?php echo e(request()->routeIs('admin.promocodes*') ? 'active' : ''); ?>">
                Промокоды
            </a>

        </nav>

        <a href="<?php echo e(route('home')); ?>" class="admin-site-link">
            ← На сайт
        </a>

    </aside>

    <main class="admin-main">

        <header class="admin-header">

            <div>
                <h1><?php echo $__env->yieldContent('page-title', 'Панель управления'); ?></h1>
                <p><?php echo $__env->yieldContent('page-subtitle', 'Управление магазином Мокронос'); ?></p>
            </div>

            <div class="admin-header__actions">

                <?php if(auth()->guard()->check()): ?>
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
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>

                    <button class="admin-logout">
                        Выйти
                    </button>
                </form>

            </div>

        </header>

        <?php if(session('success')): ?>
            <div class="admin-alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>

    </main>

</div>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>