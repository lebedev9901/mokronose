<div class="profile-content">

    <div class="profile-section-head">
        <div>
            <h1 class="section-title">Адреса доставки</h1>
            <p>Добавляйте и управляйте адресами доставки</p>
        </div>

        <button type="button" class="btn-primary" id="openAddressModal">
            + Добавить адрес
        </button>
    </div>

    <div class="addresses-grid" id="addressList">

        <?php $__currentLoopData = auth()->user()->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="address-card" data-id="<?php echo e($address->id); ?>">

                <div class="address-card-top">

                    <h3>
                        <?php echo e($address->city ?: 'Адрес доставки'); ?>

                    </h3>

                    <span class="badge">
                        <?php echo e($address->is_default ? 'Основной' : 'Дополнительный'); ?>

                    </span>

                </div>

                <p class="address-text">
                    <?php echo e($address->street); ?>,
                    <?php echo e($address->house); ?>


                    <?php if($address->apartment): ?>
                        , кв. <?php echo e($address->apartment); ?>

                    <?php endif; ?>
                </p>

                <?php if($address->comment): ?>
                    <p class="address-text-light">
                        <?php echo e($address->comment); ?>

                    </p>
                <?php endif; ?>

                <div class="address-actions">

                    <button
                        type="button"
                        class="btn-secondary edit-address"
                        data-id="<?php echo e($address->id); ?>"
                        data-city="<?php echo e($address->city); ?>"
                        data-street="<?php echo e($address->street); ?>"
                        data-house="<?php echo e($address->house); ?>"
                        data-apartment="<?php echo e($address->apartment); ?>"
                        data-comment="<?php echo e($address->comment); ?>"
                    >
                        Редактировать
                    </button>

                    <button
                        type="button"
                        class="btn-danger delete-address"
                        data-url="<?php echo e(route('addresses.destroy', $address->id)); ?>"
                    >
                        Удалить
                    </button>

                    <?php if(!$address->is_default): ?>
                        <button
                            type="button"
                            class="btn-primary set-main-address"
                            data-id="<?php echo e($address->id); ?>"
                        >
                            Сделать основным
                        </button>
                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <?php if(auth()->user()->addresses->isEmpty()): ?>
        <div class="empty-state" id="addressEmptyState">

            <p>У вас пока нет адресов</p>

            <button
                type="button"
                class="btn-primary"
                id="openFirstAddressModal"
            >
                Добавить первый адрес
            </button>

        </div>
    <?php endif; ?>

</div>

<div id="addressModal" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3 id="addressModalTitle">Новый адрес</h3>
            <button type="button" id="closeAddressModal" class="modal-close">×</button>
        </div>

        <form id="addressForm" class="address-form">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="id" id="address_id">

            <div class="form-grid">

                <div class="form-group">
                    <label>Город</label>
                    <input type="text" name="city" placeholder="Например: Воронеж">
                </div>

                <div class="form-group">
                    <label>Улица *</label>
                    <input type="text" name="street" placeholder="Ленина" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Дом *</label>
                        <input type="text" name="house" placeholder="10" required>
                    </div>

                    <div class="form-group">
                        <label>Квартира</label>
                        <input type="text" name="apartment" placeholder="25">
                    </div>
                </div>

                <div class="form-group">
                    <label>Комментарий</label>
                    <input type="text" name="comment" placeholder="Подъезд, домофон и т.д.">
                </div>

            </div>

            <button type="submit" class="btn-primary full-width">
                Сохранить адрес
            </button>

        </form>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const modal = document.getElementById('addressModal');
    const openBtn = document.getElementById('openAddressModal');
    const openFirstBtn = document.getElementById('openFirstAddressModal');
    const closeBtn = document.getElementById('closeAddressModal');
    const form = document.getElementById('addressForm');
    const list = document.getElementById('addressList');
    const title = document.getElementById('addressModalTitle');
    const addressId = document.getElementById('address_id');

    function openModal() {
        modal.classList.add('is-open');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        form.reset();
        addressId.value = '';
        title.textContent = 'Новый адрес';
    }

    openBtn?.addEventListener('click', function () {
        closeModal();
        openModal();
    });

    openFirstBtn?.addEventListener('click', function () {
        closeModal();
        openModal();
    });

    closeBtn?.addEventListener('click', closeModal);

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    function renderAddress(a) {
        return `
            <div class="address-card" data-id="${a.id}">

                <div class="address-card-top">
                    <h3>${a.city || 'Адрес'}</h3>

                    <span class="badge">
                        ${a.is_default ? 'Основной' : 'Дополнительный'}
                    </span>
                </div>

                <p class="address-text">
                    ${a.street}, ${a.house}
                    ${a.apartment ? ', кв. ' + a.apartment : ''}
                </p>

                ${a.comment ? `
                    <p class="address-text-light">
                        ${a.comment}
                    </p>
                ` : ''}

                <div class="address-actions">

                    <button
                        class="btn-secondary edit-address"
                        type="button"
                        data-id="${a.id}"
                        data-city="${a.city || ''}"
                        data-street="${a.street || ''}"
                        data-house="${a.house || ''}"
                        data-apartment="${a.apartment || ''}"
                        data-comment="${a.comment || ''}"
                    >
                        Редактировать
                    </button>

                    <button
                        class="btn-danger delete-address"
                        type="button"
                        data-url="/addresses/${a.id}"
                    >
                        Удалить
                    </button>

                    ${!a.is_default ? `
                        <button
                            class="btn-primary set-main-address"
                            type="button"
                            data-id="${a.id}"
                        >
                            Сделать основным
                        </button>
                    ` : ''}

                </div>

            </div>
        `;
    }

    function removeEmptyState() {
        const empty = document.getElementById('addressEmptyState');

        if (empty) {
            empty.remove();
        }
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const id = addressId.value;

        const url = id
            ? `/addresses/${id}`
            : `<?php echo e(route('addresses.store')); ?>`;

        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (!data.success) {
            alert(data.message || 'Ошибка сохранения адреса');
            return;
        }

        const a = data.address;
        const old = list.querySelector(`.address-card[data-id="${a.id}"]`);

        removeEmptyState();

        if (old) {
            old.outerHTML = renderAddress(a);
        } else {
            list.insertAdjacentHTML('beforeend', renderAddress(a));
        }

        closeModal();
    });

    document.addEventListener('click', async function (e) {

        if (e.target.classList.contains('edit-address')) {
            const b = e.target;

            addressId.value = b.dataset.id;
            form.querySelector('[name="city"]').value = b.dataset.city || '';
            form.querySelector('[name="street"]').value = b.dataset.street || '';
            form.querySelector('[name="house"]').value = b.dataset.house || '';
            form.querySelector('[name="apartment"]').value = b.dataset.apartment || '';
            form.querySelector('[name="comment"]').value = b.dataset.comment || '';

            title.textContent = 'Редактировать адрес';
            openModal();
        }

        if (e.target.classList.contains('delete-address')) {
            if (!confirm('Удалить адрес?')) return;

            const btn = e.target;
            const card = btn.closest('.address-card');

            const res = await fetch(btn.dataset.url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (data.success) {
                card.remove();
            }
        }

        if (e.target.classList.contains('set-main-address')) {
            const id = e.target.dataset.id;

            const res = await fetch(`/addresses/${id}/main`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (!data.success) return;

            document.querySelectorAll('.address-card').forEach(card => {
                const badge = card.querySelector('.badge');
                const actions = card.querySelector('.address-actions');
                const cardId = card.dataset.id;

                if (badge) badge.textContent = 'Дополнительный';

                if (actions && !actions.querySelector('.set-main-address')) {
                    actions.insertAdjacentHTML('beforeend', `
                        <button
                            class="btn-primary set-main-address"
                            type="button"
                            data-id="${cardId}"
                        >
                            Сделать основным
                        </button>
                    `);
                }
            });

            const active = document.querySelector(`.address-card[data-id="${data.address_id}"]`);

            if (active) {
                const badge = active.querySelector('.badge');
                const mainBtn = active.querySelector('.set-main-address');

                if (badge) badge.textContent = 'Основной';
                if (mainBtn) mainBtn.remove();
            }
        }

    });
});
</script><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/addresses.blade.php ENDPATH**/ ?>