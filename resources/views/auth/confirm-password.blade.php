<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🐶</div>
                <h1>Подтверждение пароля</h1>
                <p>Для безопасности подтвердите пароль перед продолжением</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="auth-error" />
                </div>

                <button type="submit" class="auth-btn">
                    Подтвердить
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>