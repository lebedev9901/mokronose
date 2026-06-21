<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🐶</div>
                <h1>Новый пароль</h1>
                <p>Придумайте новый пароль для вашего аккаунта</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    <x-input-error :messages="$errors->get('email')" class="auth-error" />
                </div>

                <div class="auth-field">
                    <label for="password">Новый пароль</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="auth-error" />
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                </div>

                <button type="submit" class="auth-btn">
                    Сохранить новый пароль
                </button>
            </form>

            <div class="auth-footer">
                Уже есть доступ?
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>
</x-guest-layout>