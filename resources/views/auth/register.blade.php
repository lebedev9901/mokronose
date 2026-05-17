<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card auth-card--wide">
            <div class="auth-header">
                <div class="auth-logo">🐾</div>
                <h1>Регистрация</h1>
                <p>Создайте аккаунт для заказов и отзывов</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="auth-grid">
                    <div class="auth-field">
                        <label for="first_name">Имя</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required>
                        <x-input-error :messages="$errors->get('first_name')" class="auth-error" />
                    </div>

                    <div class="auth-field">
                        <label for="last_name">Фамилия</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                        <x-input-error :messages="$errors->get('last_name')" class="auth-error" />
                    </div>

                    <div class="auth-field">
                        <label for="middle_name">Отчество</label>
                        <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}">
                        <x-input-error :messages="$errors->get('middle_name')" class="auth-error" />
                    </div>

                    <div class="auth-field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="auth-error" />
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                    <x-input-error :messages="$errors->get('password')" class="auth-error" />
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                </div>

                <button type="submit" class="auth-btn">Зарегистрироваться</button>
            </form>

            <div class="auth-footer">
                Уже есть аккаунт?
                <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>
</x-guest-layout>