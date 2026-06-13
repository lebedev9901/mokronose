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

        @foreach(auth()->user()->addresses as $address)

            <div class="address-card" data-id="{{ $address->id }}">

                <div class="address-card-top">

                    <h3>
                        {{ $address->city ?: 'Адрес доставки' }}
                    </h3>

                    <span class="badge">
                        {{ $address->is_default ? 'Основной' : 'Дополнительный' }}
                    </span>

                </div>

                <p class="address-text">
                    {{ $address->street }},
                    {{ $address->house }}

                    @if($address->apartment)
                        , кв. {{ $address->apartment }}
                    @endif
                </p>

                @if($address->comment)
                    <p class="address-text-light">
                        {{ $address->comment }}
                    </p>
                @endif

                <div class="address-actions">

                    <button
                        type="button"
                        class="btn-secondary edit-address"
                        data-id="{{ $address->id }}"
                        data-city="{{ $address->city }}"
                        data-street="{{ $address->street }}"
                        data-house="{{ $address->house }}"
                        data-apartment="{{ $address->apartment }}"
                        data-comment="{{ $address->comment }}"
                    >
                        Редактировать
                    </button>

                    <button
                        type="button"
                        class="btn-danger delete-address"
                        data-url="{{ route('addresses.destroy', $address->id) }}"
                    >
                        Удалить
                    </button>

                    @if(!$address->is_default)
                        <button
                            type="button"
                            class="btn-primary set-main-address"
                            data-id="{{ $address->id }}"
                        >
                            Сделать основным
                        </button>
                    @endif

                </div>

            </div>

        @endforeach

    </div>

    @if(auth()->user()->addresses->isEmpty())
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
    @endif

</div>

<div id="addressModal" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h3 id="addressModalTitle">Новый адрес</h3>
            <button type="button" id="closeAddressModal" class="modal-close">×</button>
        </div>

        <form id="addressForm" class="address-form">
            @csrf

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
            : `{{ route('addresses.store') }}`;

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
</script>