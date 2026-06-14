@php
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
@endphp
<button class="profile-menu-toggle" type="button" id="profileMenuToggle">
    ☰ Меню профиля
</button>
<nav class="profile-sidebar-nav" id="profileSidebarNav">
    <ul class="dashboard__list list-reset">
        @foreach($menu_items as $item)
            @php
                $isActive = $item['page'] === $current_page;
            @endphp
            <li class="dashboard__list-item">
                @if($item['page'] === 'logout')
                    <a href="{{ route('logout') }}" class="dashboard__list-link {{ $isActive ? 'active' : '' }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                @elseif($item['page'] === 'admin')
                    <a href="{{route('admin.dashboard')}}" class="dashboard__list-link {{ $isActive ? 'active' : '' }}">
                @else
                    @php
$route = $item['page'] === 'profile'
    ? route('profile.page')
    : route('profile.page', ['page' => $item['page']]);
@endphp

<a href="{{ $route }}"
   class="dashboard__list-link {{ $isActive ? 'active' : '' }}">
                @endif
                        <h4 class="dashboard__link-title">{{ $item['title'] }}</h4>
                        <p class="dashboard__link-descr">{{ $item['descr'] }}</p>
                    </a>
            </li>
        @endforeach
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
</script>