<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title'); ?></title>
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin.css')); ?> ">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>

<div class="admin-wrapper">

    
    <aside class="sidebar">

        <div class="logo">
            Мокронос Admin
        </div>

        <nav class="menu">

            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->is('admin') ? 'active' : ''); ?>">
                Dashboard
            </a>

            <a href="<?php echo e(route('admin.products')); ?>" class="<?php echo e(request()->is('admin/products*') ? 'active' : ''); ?>">
                Товары
            </a>
           
            <a href="<?php echo e(route('admin.categories')); ?>" class="<?php echo e(request()->is('admin/categories*') ? 'active' : ''); ?>">
                Категории
            </a>


            
            <a href="<?php echo e(route('admin.users')); ?>" class="<?php echo e(request()->is('admin/users*') ? 'active' : ''); ?>">
                Пользователи
            </a>

            <a href="<?php echo e(route('admin.orders')); ?>" class="<?php echo e(request()->is('admin/orders*') ? 'active' : ''); ?>">
                Заказы
            </a>

            <a href="<?php echo e(route('admin.support')); ?>" class="<?php echo e(request()->is('admin/support*') ? 'active' : ''); ?>">
                Чаты
            </a>


        </nav>

    </aside>

    
    <main class="content">

        <header class="header">
            Панель управления
        </header>

        <div class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </main>

</div>

</body>
</html><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>