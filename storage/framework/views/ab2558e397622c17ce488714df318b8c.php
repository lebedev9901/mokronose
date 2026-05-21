<div class="profile-content">

            <div class="profile-header">
                <h1>Адреса доставки</h1>
                <button class="btn-primary" id="openAddressModal" >+ Добавить адрес</button>
            </div>

            <div id="addressModal" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3>Новый адрес</h3>
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

            <div class="addresses-grid" id="addressList">

                <?php $__empty_1 = true; $__currentLoopData = auth()->user()->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="address-card">

                        <div class="address-card-top">
                            <h3><?php echo e($address->city); ?></h3>
                            <span class="badge">
                                <?php echo e($address->is_default ? 'Основной' : 'Дополнительный'); ?>

                            </span>
                        </div>

                        <p class="address-text">
                            <?php echo e($address->street); ?>, <?php echo e($address->house); ?>

                        </p>

                        <p class="address-text-light">
                            <?php echo e($address->comment); ?>

                        </p>

                        <div class="address-actions">

                            <button class="btn-secondary edit-address"
                                    data-id="<?php echo e($address->id); ?>"
                                    data-city="<?php echo e($address->city); ?>"
                                    data-street="<?php echo e($address->street); ?>"
                                    data-house="<?php echo e($address->house); ?>"
                                    data-apartment="<?php echo e($address->apartment); ?>">
                                Редактировать
                            </button>
                            <button class="btn-danger delete-address" data-id="<?php echo e($address->id); ?>">
                                Удалить
                            </button>
                                                        <button class="btn-primary set-main-address"
                                    data-id="<?php echo e($address->id); ?>">
                                Сделать основным
                            </button>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state">
                        <p>У вас пока нет адресов</p>
                        <button class="btn-primary">Добавить первый адрес</button>
                    </div>
                <?php endif; ?>

            </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('addressModal');
    const openBtn = document.getElementById('openAddressModal');
    const closeBtn = document.getElementById('closeAddressModal');
    const form = document.getElementById('addressForm');
    const list = document.getElementById('addressList');

    // --------------------------
    // OPEN
    // --------------------------
    openBtn.addEventListener('click', function () {
        form.reset();
        document.getElementById('address_id').value = '';
        modal.style.display = 'block';
    });

    // --------------------------
    // CLOSE
    // --------------------------
    closeBtn.addEventListener('click', () => modal.style.display = 'none');

    window.addEventListener('click', function (e) {
        if (e.target === modal) modal.style.display = 'none';
    });

    // --------------------------
    // RENDER
    // --------------------------
    function renderAddress(a) {
        return `
            <div class="address-card" data-id="${a.id}">

                <div class="address-card-top">
                    <h3>${a.city ?? ''}</h3>

                    <span class="badge">
                        ${a.is_default ? 'Основной' : 'Дополнительный'}
                    </span>
                </div>

                <p class="address-text">
                    ${a.street} ${a.house}
                    ${a.apartment ? ', кв. ' + a.apartment : ''}
                </p>

                <p class="address-text-light">
                    ${a.comment ?? ''}
                </p>

                <div class="address-actions">

                    <button class="btn-secondary edit-address"
                        data-id="${a.id}"
                        data-city="${a.city ?? ''}"
                        data-street="${a.street}"
                        data-house="${a.house}"
                        data-apartment="${a.apartment ?? ''}"
                        data-comment="${a.comment ?? ''}">
                        Редактировать
                    </button>

                    <button class="btn-danger delete-address"
                        data-id="${a.id}">
                        Удалить
                    </button>

                    <button class="btn-primary set-main-address"
                        data-id="${a.id}">
                        Сделать основным
                    </button>

                </div>

            </div>
        `;
    }

    // --------------------------
    // SUBMIT (CREATE + UPDATE)
    // --------------------------
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        let id = document.getElementById('address_id').value;

        let url = id
            ? `/addresses/${id}`
            : `<?php echo e(route('addresses.store')); ?>`;

        let res = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: new FormData(form)
        });

        let data = await res.json();
        if (!data.success) return;

        const a = data.address;

        let old = list.querySelector(`[data-id="${a.id}"]`);

        if (old) {
            old.outerHTML = renderAddress(a);
        } else {
            list.insertAdjacentHTML('beforeend', renderAddress(a));
        }

        form.reset();
        document.getElementById('address_id').value = '';
        modal.style.display = 'none';
    });

    // --------------------------
    // SINGLE CLICK HANDLER
    // --------------------------
    document.addEventListener('click', function (e) {

        // DELETE
        if (e.target.classList.contains('delete-address')) {

            let id = e.target.dataset.id;

            fetch(`/addresses/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(r => r.json())
            .then(data => {

                if (data.success) {
                    let card = document.querySelector(`.address-card[data-id="${id}"]`);
                    if (card) card.remove();
                }

            });
        }

        // EDIT
        if (e.target.classList.contains('edit-address')) {

            const b = e.target;

            document.getElementById('address_id').value = b.dataset.id;
            document.querySelector('[name="city"]').value = b.dataset.city;
            document.querySelector('[name="street"]').value = b.dataset.street;
            document.querySelector('[name="house"]').value = b.dataset.house;
            document.querySelector('[name="apartment"]').value = b.dataset.apartment;
            document.querySelector('[name="comment"]').value = b.dataset.comment;

            modal.style.display = 'block';
        }

        // MAIN
        if (e.target.classList.contains('set-main-address')) {

            let id = e.target.dataset.id;

            fetch(`/addresses/${id}/main`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {

                if (!data.success) return;

                document.querySelectorAll('.address-card').forEach(card => {

                    let badge = card.querySelector('.badge');
                    if (badge) badge.textContent = 'Дополнительный';

                });

                let active = document.querySelector(`.address-card[data-id="${data.address_id}"]`);

                if (active) {
                    let badge = active.querySelector('.badge');
                    if (badge) badge.textContent = 'Основной';
                }

            });

        }

    });

});
</script><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/addresses.blade.php ENDPATH**/ ?>