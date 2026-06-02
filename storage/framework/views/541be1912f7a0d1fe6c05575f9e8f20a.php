<div class="profile-card">

    <div class="profile-avatar">
        <img class="profile-avatar-img"
             src="<?php echo e($user->avatar ?? '/img/default-avatar.png'); ?>" alt="">
        <span class="status"></span>
    </div>

    <div class="profile-info">

        <h2 id="profile-name">
            <?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?> <?php echo e($user->middle_name); ?>

        </h2>

        <p>Email: <span id="profile-email"><?php echo e($user->email); ?></span></p>

        <p>Телефон: <span id="profile-phone"><?php echo e($user->phone ?? 'не указан'); ?></span></p>

        <p>
            VK ID: <?php echo e($user->vk_id ?? 'не привязан'); ?>

        </p>

        <span class="profile-role">
            <?php echo e($user->role === 'admin' ? 'Администратор' : 'Пользователь'); ?>

        </span>

        <p class="profile-meta">
            Зарегистрирован: <?php echo e($user->created_at->format('d.m.Y')); ?>

        </p>

    </div>

    <div class="profile-actions flex">

        <button class="btn-primary" id="openProfileModal">
            Редактировать профиль
        </button>

        <?php if(!$user->vk_id): ?>
            <div id="vkid-profile-link" class="btn-primary"></div>
        <?php else: ?>
            <button class="btn-secondary" disabled>VK привязан</button>
        <?php endif; ?>

        <a href="https://vk.me/mokronose" target="_blank" class="btn-secondary">
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

        <form method="POST"id="profileForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="form-grid">

                <input type="text" name="first_name" value="<?php echo e($user->first_name); ?>" placeholder="Имя">
                <input type="text" name="last_name" value="<?php echo e($user->last_name); ?>" placeholder="Фамилия">
                <input type="text" name="middle_name" value="<?php echo e($user->middle_name); ?>" placeholder="Отчество">

                <input type="text" name="phone" value="<?php echo e($user->phone); ?>" placeholder="Телефон">
                <input type="email" name="email" value="<?php echo e($user->email); ?>" placeholder="Email">

                <input type="file" name="avatar">

            </div>

            <button class="btn-primary full-width" type="submit">
                Сохранить
            </button>

        </form>

    </div>

</div>


<section class="profile-favorites">
    <h2>❤️ Избранные товары</h2>

    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="profile-favorite-card">
            <?php
                $preview = $product->images->where('is_preview', true)->first()
                    ?? $product->images->first();
            ?>

          
                <img src="<?php echo e($preview
                            ? asset('storage/' . $preview->image)
                            : asset('assets/img/no-image.png')); ?>"
                        alt="<?php echo e($product->title); ?>">
            

            <div>
                <h3><a href="<?php echo e(route('product', $product->id)); ?>"><?php echo e($product->title); ?></a></h3>
                <p><?php echo e($product->price); ?> ₽</p>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>В избранном пока нет товаров.</p>
    <?php endif; ?>
</section>


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

        const res = await fetch("<?php echo e(route('profile.update')); ?>", {
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

<script src="https://unpkg.com/@vkid/sdk@latest/dist-sdk/umd/index.js"></script>
<script>
if ('VKIDSDK' in window) {
    const VKID = window.VKIDSDK;

    VKID.Config.init({
        app: 54596619,
        redirectUrl: 'https://mokronos.ru/vk/callback',
        responseMode: VKID.ConfigResponseMode.Callback,
        source: VKID.ConfigSource.LOWCODE,
        scope: 'email phone',
    });

    const oneTap = new VKID.OneTap();

    oneTap.render({
        container: document.getElementById('vkid-profile-link'),
        showAlternativeLogin: true
    })
    .on(VKID.WidgetEvents.ERROR, function(error) {
        console.error('VK ERROR:', error);
    })
    .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function(payload) {
        VKID.Auth.exchangeCode(payload.code, payload.device_id)
            .then(function(data) {
                return fetch('<?php echo e(route('vk.link')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        user_id: data.user_id,
                        access_token: data.access_token,
                        email: data.email,
                        phone: data.phone
                    })
                });
            })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Ошибка VK');
                }
            });
    });
}
</script>
<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/profile.blade.php ENDPATH**/ ?>