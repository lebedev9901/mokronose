<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🐶</div>
                <h1>Восстановление пароля</h1>
                <p>Введите email, и мы отправим ссылку для сброса пароля</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="auth-error" />
                </div>

                <button type="submit" class="auth-btn">
                    Отправить ссылку
                </button>
            </form>

            <div class="auth-footer">
                Вспомнили пароль?
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>
</x-guest-layout>