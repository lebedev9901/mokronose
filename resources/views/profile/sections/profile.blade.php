<div class="profile-content">

    <section class="profile-hero">
        <div class="profile-hero__content">
            <span class="profile-hero__badge">Личный кабинет</span>

            <h1>Привет, {{ $user->first_name ?? 'друг' }} 👋</h1>

            <p>
                Добро пожаловать в Мокронос. Здесь ваши заказы, питомцы, избранное и поддержка.
            </p>

            <div class="profile-hero__stats">
                <span>{{ $stats['orders'] }} заказов</span>
                <span>{{ $stats['pets'] }} питомцев</span>
                <span>{{ $stats['favorites'] }} избранных</span>
                <span>{{ $stats['reviews'] }} отзывов</span>
            </div>

            <a href="{{ route('catalog') }}" class="btn-primary">
                Перейти в каталог
            </a>
        </div>

        <div class="profile-hero__icon">🐶</div>
    </section>


    <section class="profile-card">
        <div class="profile-card__left">

            <div class="profile-avatar">
                <img
                    class="profile-avatar-img"
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/default-avatar.png') }}"
                    alt="{{ $user->first_name ?? 'Профиль' }}"
                >
                <span class="status"></span>
            </div>

            <div class="profile-info">
                <h2 id="profile-name">
                    {{ trim($user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name) ?: 'Пользователь' }}
                </h2>

                <p>Email: <span id="profile-email">{{ $user->email }}</span></p>
                <p>Телефон: <span id="profile-phone">{{ $user->phone ?? 'не указан' }}</span></p>
                <p>VK ID: {{ $user->vk_id ?? 'не привязан' }}</p>

                <span class="profile-role">
                    {{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}
                </span>

                <p class="profile-meta">
                    Зарегистрирован: {{ $user->created_at->format('d.m.Y') }}
                </p>
            </div>

        </div>

        <div class="profile-actions">
            <button class="btn-primary" id="openProfileModal" type="button">
                Редактировать профиль
            </button>

            @if(!$user->vk_id)
                <div id="vkid-profile-link"></div>
            @else
                <button class="btn-secondary" disabled type="button">
                    VK привязан
                </button>
            @endif

            <a href="https://vk.me/mokronose" target="_blank" class="btn-secondary">
                Написать в VK
            </a>
        </div>
    </section>


    <section class="profile-quick-actions">

        <a href="{{ route('profile.page', ['page' => 'pet']) }}" class="profile-quick-card">
            <span>🐾</span>
            <div>
                <h3>Мои питомцы</h3>
                <p>Карточки питомцев</p>
            </div>
        </a>

        <a href="{{ route('profile.page', ['page' => 'orders']) }}" class="profile-quick-card">
            <span>📦</span>
            <div>
                <h3>Мои заказы</h3>
                <p>История покупок</p>
            </div>
        </a>

        <a href="{{ route('favorites.index') }}" class="profile-quick-card">
            <span>❤️</span>
            <div>
                <h3>Избранное</h3>
                <p>Сохранённые товары</p>
            </div>
        </a>

        <a href="{{ route('support.index') }}" class="profile-quick-card">
            <span>💬</span>
            <div>
                <h3>Поддержка</h3>
                <p>Вопросы и обращения</p>
            </div>
        </a>

    </section>


    <section class="profile-latest-orders">

        <div class="profile-section-head">
            <div>
                <h2>📦 Последние заказы</h2>
                <p>Ваши последние покупки в Мокроносе</p>
            </div>

            <a href="{{ route('profile.page', ['page' => 'orders']) }}" class="btn-secondary">
                Все заказы
            </a>
        </div>

        <div class="profile-orders-list">
            @forelse($latestOrders as $order)
                <div class="profile-order-card">

                    <div class="profile-order-main">
                        <strong>Заказ №{{ $order->id }}</strong>
                        <span>{{ $order->created_at->format('d.m.Y') }}</span>
                    </div>

                    <div class="profile-order-info">
                        <span class="order-status status-{{ $order->status }}">
                            {{ $order->status_label ?? $order->status }}
                        </span>

                        <strong>
                            {{ number_format($order->total_price ?? $order->total ?? 0, 0, '.', ' ') }} ₽
                        </strong>
                    </div>

                    <a href="{{ route('orders.show', $order->id) }}" class="btn-primary">
                        Подробнее
                    </a>

                </div>
            @empty
                <div class="empty-block">
                    У вас пока нет заказов.
                </div>
            @endforelse
        </div>

    </section>


    <section class="profile-favorites">

        <div class="profile-section-head">
            <div>
                <h2>❤️ Избранные товары</h2>
                <p>Товары, которые вы сохранили</p>
            </div>

            <a href="{{ route('profile.page', ['page' => 'favorites']) }}" class="btn-secondary">
                Все избранное
            </a>
        </div>

        <div class="profile-favorites-grid">
            @forelse($products->take(4) as $product)
                @php
                    $preview = $product->images->where('is_preview', true)->first()
                        ?? $product->images->first();
                @endphp

                <a href="{{ route('product', $product->id) }}" class="profile-favorite-card">
                    <img
                        src="{{ $preview ? asset('storage/' . $preview->image) : asset('assets/img/no-image.png') }}"
                        alt="{{ $product->title }}"
                    >

                    <div>
                        <h3>{{ $product->title }}</h3>
                        <p>{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                    </div>
                </a>
            @empty
                <div class="empty-block">
                    В избранном пока нет товаров.
                </div>
            @endforelse
        </div>

    </section>

</div>


<div class="modal" id="profileModal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Редактирование профиля</h3>
            <button class="modal-close" id="closeProfileModal" type="button">×</button>
        </div>

        <form method="POST" id="profileForm" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Фамилия">
                <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="Имя">
                <input type="text" name="middle_name" value="{{ $user->middle_name }}" placeholder="Отчество">
                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Телефон">
                <input type="email" name="email" value="{{ $user->email }}" placeholder="Email">
                <input type="file" name="avatar" accept="image/*">
            </div>

            <button class="btn-primary full-width" type="submit">
                Сохранить
            </button>
        </form>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profileForm');
    const modal = document.getElementById('profileModal');
    const openBtn = document.getElementById('openProfileModal');
    const closeBtn = document.getElementById('closeProfileModal');

    const nameEl = document.getElementById('profile-name');
    const phoneEl = document.getElementById('profile-phone');
    const emailEl = document.getElementById('profile-email');
    const avatarEl = document.querySelector('.profile-avatar-img');

    openBtn?.addEventListener('click', () => modal.classList.add('is-open'));
    closeBtn?.addEventListener('click', () => modal.classList.remove('is-open'));

    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('is-open');
    });

    form?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const res = await fetch("{{ route('profile.update') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (!data.success) {
            alert(data.message || 'Ошибка сохранения');
            return;
        }

        const user = data.user;
        const fullName = `${user.last_name ?? ''} ${user.first_name ?? ''} ${user.middle_name ?? ''}`.trim();

        nameEl.textContent = fullName || 'Пользователь';
        phoneEl.textContent = user.phone ?? 'не указан';
        emailEl.textContent = user.email ?? '';

        avatarEl.src = user.avatar
            ? user.avatar
            : '/assets/img/default-avatar.png';

        modal.classList.remove('is-open');
    });
});
</script>