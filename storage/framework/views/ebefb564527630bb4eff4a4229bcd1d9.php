<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="yandex-verification" content="93a14333f280d765" >
        <title><?php echo $__env->yieldContent('title', 'Мокронос — зоомагазин'); ?></title>
        <meta name="description" content="<?php echo $__env->yieldContent('description', 'Интернет-магазин товаров для животных. Корма, игрушки, аксессуары и товары для питомцев.'); ?>">
        <meta name="keywords" content="зоомагазин, товары для животных, корм для собак, корм для кошек, аксессуары для животных">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="<?php echo e(url()->current()); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'Мокронос — зоомагазин'); ?>">
        <meta property="og:description" content="<?php echo $__env->yieldContent('description', 'Интернет-магазин товаров для животных.'); ?>">
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">
        <meta property="og:site_name" content="Мокронос">       
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', 'Мокронос — зоомагазин'); ?>">
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', 'Интернет-магазин товаров для животных.'); ?>">
        <meta name="twitter:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/normalize.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/advantages.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/cart.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/catalog.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/faq.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/footer.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/header.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/hero.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/modal-login.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/process.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/product_preview.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/product.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/reviews.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/profile.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dashboard.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/form.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/product__visual.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/category_visual.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/aboute.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/pay.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/order__check.css')); ?> ">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/news.css')); ?> ">
        <!-- Scripts -->
       <script src="<?php echo e(asset('assets/js/catalog.js')); ?>" defer></script>
       <script src="<?php echo e(asset('assets/js/cart-page.js')); ?>" defer></script>
       <script src="<?php echo e(asset('assets/js/cart.js')); ?>" defer></script>
       <script src="<?php echo e(asset('assets/js/script.js')); ?>" defer></script>
  
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    </head>
    <body class="font-sans antialiased">
        <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page Content -->
            <main class="min-h-screen">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        
            <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </body>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</html>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/layouts/app.blade.php ENDPATH**/ ?>