 
 
 @php
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

$current_page = ['page', 'profile'];

@endphp

 {{-- Боковое меню --}}
    <nav class="profile-menu" style="min-width:250px;">
        <ul class="dashboard__list flex flex-col list-none gap-2">
            @foreach ($menu_items as $item)
                @php
                    $isActive = $item['page'] === $current_page;
                @endphp
                <li class="dashboard__list-item">
                    @if($item['page'] === 'logout')
                        <a href="{{ route('logout') }}" class="dashboard__list-link {{ $isActive ? 'active' : '' }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    @elseif($item['page'] === 'admin')
                        <a href="/admin" class="dashboard__list-link {{ $isActive ? 'active' : '' }}">
                    @else
                        <a href="{{ route('profile.page', $item['page']) }}" class="dashboard__list-link {{ $isActive ? 'active' : '' }}">
                    @endif
                        <h4 class="dashboard__link-title">{{ $item['title'] }}</h4>
                        <p class="dashboard__link-descr">{{ $item['descr'] }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    