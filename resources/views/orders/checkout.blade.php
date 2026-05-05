@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container">

  <div class="checkout">

    <h1 class="section-title">Оформление заказа</h1>

    {{-- Состав заказа --}}
    <div class="order-summary">
        <h3>Ваш заказ</h3>

            <div class="checkout-items">
                @foreach($cartItems as $item)
                    <div class="checkout-item">
                        <span>{{ $item->product->title }}</span>
                        <span>{{ $item->qty }} × {{ $item->product->price }} ₽</span>
                    </div>
                @endforeach
            </div>

            <div class="checkout-total">
                <span>Итого:</span>
                <strong>{{ number_format($total, 2) }} ₽</strong>
            </div>

            <button type="submit" form="checkout-form" class="btn-primary">
                Подтвердить заказ
            </button>

        </div>

    </div>

</div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const container = document.getElementById('delivery-extra');
    const selectedBox = document.getElementById('selected-delivery');
    const submitBtn = document.querySelector('button[type="submit"]');

    function clearContainer() {
        container.innerHTML = '';
        selectedBox.innerHTML = '';
        submitBtn.disabled = false;
    }

    // --------------------------
    // COURIER
    // --------------------------
    function renderCourier() {

        if (!window.userAddresses.length) {
            container.innerHTML = `
                <p>У вас нет адресов</p>
                <a href="/profile" class="btn-primary">Добавить адрес</a>
            `;
            submitBtn.disabled = true;
            return;
        }

        const defaultAddress = window.userAddresses.find(a => a.is_default);

        container.innerHTML = `
            <h4>Выберите адрес доставки</h4>

            ${window.userAddresses.map(a => `
                <label class="radio">
                    <input type="radio" name="address_id"
                           value="${a.id}"
                           ${defaultAddress && a.id === defaultAddress.id ? 'checked' : ''}
                           required>

                    ${a.city ?? ''}, ${a.street} ${a.house}

                    ${a.is_default ? '<strong>(Основной)</strong>' : ''}
                </label>
            `).join('')}
        `;

        // сразу показать выбранный (если есть основной)
        if (defaultAddress) {
            renderSelectedAddress(defaultAddress);
        }
    }

    function renderSelectedAddress(a) {
        selectedBox.innerHTML = `
            <div style="padding:10px; border:1px solid #eee; border-radius:8px;">
                <strong>Доставка:</strong><br>
                ${a.city ?? ''}, ${a.street} ${a.house}
                ${a.apartment ? ', кв. ' + a.apartment : ''}
            </div>
        `;
    }

    // --------------------------
    // PICKUP
    // --------------------------
    function renderPickup() {
        container.innerHTML = `
            <h4>Выберите пункт самовывоза</h4>

            <label class="radio">
                <input type="radio" name="pickup_point" value="Ленина 10" required>
                Воронеж, ул. Ленина 10
            </label>

            <label class="radio">
                <input type="radio" name="pickup_point" value="Московский проспект 5">
                Воронеж, Московский проспект 5
            </label>
        `;
    }

    // --------------------------
    // CDEK
    // --------------------------
    function renderCdek() {
        container.innerHTML = `
            <h4>Пункт СДЭК</h4>
            <input type="text" name="cdek_point" placeholder="Введите пункт выдачи" required>
        `;
    }

    // --------------------------
    // POST
    // --------------------------
    function renderPost() {
        container.innerHTML = `
            <h4>Адрес для почты</h4>
            <input type="text" name="post_address" placeholder="Полный адрес" required>
        `;
    }

    // --------------------------
    // SWITCH DELIVERY
    // --------------------------
    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function () {

            clearContainer();

            switch (this.value) {
                case 'courier':
                    renderCourier();
                    break;

                case 'pickup':
                    renderPickup();
                    break;

                case 'cdek':
                    renderCdek();
                    break;

                case 'post':
                    renderPost();
                    break;
            }

        });
    });

    // --------------------------
    // LISTEN CHANGES
    // --------------------------
    document.addEventListener('change', function(e) {

        // адрес
        if (e.target.name === 'address_id') {
            let a = window.userAddresses.find(x => x.id == e.target.value);
            renderSelectedAddress(a);
        }

        // самовывоз
        if (e.target.name === 'pickup_point') {
            selectedBox.innerHTML = `
                <div style="padding:10px; border:1px solid #eee; border-radius:8px;">
                    <strong>Самовывоз:</strong><br>
                    ${e.target.value}
                </div>
            `;
        }

    });

});

const nameInput = document.querySelector('input[name="name"]');
const phoneInput = document.querySelector('input[name="phone"]');

let timeout;

function autoSave() {

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        fetch('/profile/save-contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: nameInput.value,
                phone: phoneInput.value
            })
        });

    }, 800); // задержка чтобы не спамить

}

nameInput.addEventListener('input', autoSave);
phoneInput.addEventListener('input', autoSave);
</script>
@endpush