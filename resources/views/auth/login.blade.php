<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🐶</div>
                <h1>Вход в аккаунт</h1>
                <p>Войдите, чтобы оформлять заказы и оставлять отзывы</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="auth-error" />
                </div>

                <div class="auth-field">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                    <x-input-error :messages="$errors->get('password')" class="auth-error" />
                </div>

                <div class="auth-row">
                    <label class="auth-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Запомнить меня</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    @endif
                </div>

                <button type="submit" class="auth-btn">Войти</button>
            </form>
            
            <div class="auth-footer">
                Нет аккаунта?
                <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>

                        <div id="vkid-login"></div>

<script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>

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
        container: document.getElementById('vkid-login'),
        showAlternativeLogin: true,
        styles: {
            borderRadius: 16,
            width: 320
        },
        oauthList: [
            'mail_ru',
            'ok_ru'
        ]
    })
    .on(VKID.WidgetEvents.ERROR, function(error) {
        console.error('VK ERROR:', error);
        console.log('Ошибка VK ID');
    })
    .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function(payload) {
        const code = payload.code;
        const deviceId = payload.device_id;

        VKID.Auth.exchangeCode(payload.code, payload.device_id)
    .then(function (data) {
        return VKID.Auth.userInfo(data.access_token)
            .then(function (profile) {
                return fetch('{{ route('vk.sdk-login') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: data.user_id,
                        access_token: data.access_token,
                        id_token: data.id_token,
                        email: data.email,
                        phone: data.phone,
                        profile: profile
                    })
                });
            });
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        if (data.ok) {
            window.location.href = '/';
        } else {
            alert(data.message || 'Ошибка VK');
        }
    })
    .catch(error => {
        console.error('VK LOGIN ERROR:', error);
    });
    });
}
                    </script>
        </div>
    </div>
</x-guest-layout>
