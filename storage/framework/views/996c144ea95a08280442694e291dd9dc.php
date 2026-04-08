<?php
$menu_items = [
    ['page' => 'profile', 'title' => 'Мой профиль', 'descr' => 'Редактирование данных'],
    ['page' => 'orders', 'title' => 'История заказов', 'descr' => 'Ваши заказы за всё время'],
    ['page' => 'pet', 'title' => 'Питомец', 'descr' => 'Редактирование, добавление, удаление'],
    ['page' => 'addresses', 'title' => 'Адреса доставки', 'descr' => 'Редактирование, добавление, удаление'],
    ['page' => 'support', 'title' => 'Поддержка', 'descr' => 'Все общения здесь'],
    ['page' => 'reviews', 'title' => 'Мои отзывы', 'descr' => 'Все, что Вы оценивали - здесь'],
    ['page' => 'logout', 'title' => 'Выйти', 'descr' => 'Выйти из профиля'],
];

if(auth()->check() && auth()->user()->role === 'admin'){
    $menu_items[] = ['page' => 'admin', 'title' => 'Админ панель', 'descr' => 'Управление товарами и заказами'];
}
?>

<nav>
    <ul class="dashboard__list flex flex-col list-none gap-2">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $isActive = $item['page'] === $current_page;
            ?>
            <li class="dashboard__list-item">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['page'] === 'logout'): ?>
                    <a href="<?php echo e(route('logout')); ?>" class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <?php elseif($item['page'] === 'admin'): ?>
                    <a href="/admin" class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>">
                <?php else: ?>
                    <?php
$route = $item['page'] === 'profile'
    ? route('profile.page')
    : route('profile.page', ['page' => $item['page']]);
?>

<a href="<?php echo e($route); ?>"
   class="dashboard__list-link <?php echo e($isActive ? 'active' : ''); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <h4 class="dashboard__link-title"><?php echo e($item['title']); ?></h4>
                        <p class="dashboard__link-descr"><?php echo e($item['descr']); ?></p>
                    </a>
            </li>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </ul>
</nav>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/menu.blade.php ENDPATH**/ ?>