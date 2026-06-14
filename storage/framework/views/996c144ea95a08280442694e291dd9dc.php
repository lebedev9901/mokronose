<?php
$menu_items = [
    ['page' => 'profile', 'title' => 'Мой профиль', 'descr' => 'Личный кабинет'],
    ['page' => 'favorites', 'title' => 'Избранное', 'descr' => 'Товары, который вы оценили'],
    ['page' => 'orders', 'title' => 'История заказов', 'descr' => 'Ваши заказы за всё время'],
    ['page' => 'pet', 'title' => 'Питомец', 'descr' => 'Ваши друзья тоже здесь'],
    ['page' => 'addresses', 'title' => 'Адреса доставки', 'descr' => 'Доставим по России'],
    ['page' => 'support', 'title' => 'Поддержка', 'descr' => 'Все общения здесь'],
    ['page' => 'reviews', 'title' => 'Мои отзывы', 'descr' => 'Все, что Вы оценивали - здесь'],
    ['page' => 'logout', 'title' => 'Выйти', 'descr' => 'Выйти из профиля'],
];

if(auth()->check() && auth()->user()->role === 'admin'){
    $menu_items[] = ['page' => 'admin', 'title' => 'Админ панель', 'descr' => 'Управление товарами и заказами'];
}
?>
<button class="profile-menu-toggle" type="button" id="profileMenuToggle">
    ☰ Меню профиля
</button>
<nav class="profile-sidebar-nav" id="profileSidebarNav">
    <ul class="dashboard__list list-reset">
        <?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isActive = $item['page'] === $current_page;
            ?>
            <li class="dashboard__list-item">
                <?php if($item['page'] === 'logout'): ?>
                    <a href="<?php echo e(route('logout')); ?>" class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <?php elseif($item['page'] === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>">
                <?php else: ?>
                    <?php
$route = $item['page'] === 'profile'
    ? route('profile.page')
    : route('profile.page', ['page' => $item['page']]);
?>

<a href="<?php echo e($route); ?>"
   class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>">
                <?php endif; ?>
                        <h4 class="dashboard__link-title"><?php echo e($item['title']); ?></h4>
                        <p class="dashboard__link-descr"><?php echo e($item['descr']); ?></p>
                    </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</nav>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('profileMenuToggle');
    const nav = document.getElementById('profileSidebarNav');

    toggle?.addEventListener('click', function () {
        nav.classList.toggle('is-open');
    });
});
</script><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/menu.blade.php ENDPATH**/ ?>