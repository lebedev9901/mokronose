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

            <a href="{{ route('vk.redirect') }}" class="auth-vk-btn">
                Войти через VK
            </a>
            
            <div class="auth-footer">
                Нет аккаунта?
                <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</x-guest-layout>