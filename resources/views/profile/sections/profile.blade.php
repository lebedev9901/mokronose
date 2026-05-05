<div class="profile-card">

    <div class="profile-avatar">
        <img class="profile-avatar-img"
             src="{{ $user->avatar ?? '/img/default-avatar.png' }}" alt="">
        <span class="status"></span>
    </div>

    <div class="profile-info">

        <h2 id="profile-name">
            {{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}
        </h2>

        <p>Email: <span id="profile-email">{{ $user->email }}</span></p>

        <p>Телефон: <span id="profile-phone">{{ $user->phone ?? 'не указан' }}</span></p>

        <p>
            VK ID: {{ $user->vk_id ?? 'не привязан' }}
        </p>

        <span class="profile-role">
            {{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}
        </span>

        <p class="profile-meta">
            Зарегистрирован: {{ $user->created_at->format('d.m.Y') }}
        </p>

    </div>

    <div class="profile-actions flex">

        <button class="btn-primary" id="openProfileModal">
            Редактировать профиль
        </button>

        @if(!$user->vk_id)
            <a href="{{ route('vk.redirect') }}" class="btn-primary">
                Привязать VK
            </a>
        @else
            <button class="btn-secondary" disabled>VK привязан</button>
        @endif

        <a href="https://vk.me/your_group" target="_blank" class="btn-secondary">
            Написать в VK
        </a>

    </div>

</div>

<div class="modal" id="profileModal">

    <div class="modal-content">

        <div class="modal-header">
            <h3>Редактирование профиля</h3>
            <button class="modal-close" id="closeProfileModal">×</button>
        </div>

        <form id="profileForm">
            @csrf

            <div class="form-grid">

                <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="Имя">
                <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Фамилия">
                <input type="text" name="middle_name" value="{{ $user->middle_name }}" placeholder="Отчество">

                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Телефон">
                <input type="email" name="email" value="{{ $user->email }}" placeholder="Email">

                <input type="file" name="avatar">

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

    // OPEN MODAL
    openBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    // CLOSE MODAL
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // SUBMIT
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const res = await fetch("{{ route('profile.update') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (!data.success) return;

        const user = data.user;

        // FULL NAME
        const fullName =
            `${user.last_name ?? ''} ${user.first_name ?? ''} ${user.middle_name ?? ''}`;

        if (nameEl) nameEl.textContent = fullName.trim();
        if (phoneEl) phoneEl.textContent = user.phone ?? 'не указан';
        if (emailEl) emailEl.textContent = user.email ?? '';

        // AVATAR
        if (avatarEl) {
            avatarEl.src = user.avatar
                ? user.avatar
                : '/img/default-avatar.png';
        }

        modal.style.display = 'none';
    });

});
</script>
