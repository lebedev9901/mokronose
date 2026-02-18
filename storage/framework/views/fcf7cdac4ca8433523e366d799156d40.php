<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Laravel'); ?></title>
    <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>
      <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?> <!-- подключение стилей, если используешь Vite -->
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col justify-center items-center">
        <?php echo e($slot); ?>

    </div>
     <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts() ?>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\mokronose\resources\views/layouts/guest.blade.php ENDPATH**/ ?>