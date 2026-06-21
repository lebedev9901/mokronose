<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">🐶</div>
                <h1>Подтвердите email</h1>
                <p>Мы отправили письмо со ссылкой подтверждения на ваш email</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="auth-success">
                    Новая ссылка подтверждения отправлена на ваш email.
                </div>
            @endif

            <div class="auth-footer">
                Не получили письмо?
            </div>

            <form method="POST" action="{{ route('verification.send') }}" class="auth-form">
                @csrf

                <button type="submit" class="auth-btn">
                    Отправить письмо ещё раз
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="auth-form">
                @csrf

                <button type="submit" class="auth-link-btn">
                    Выйти из аккаунта
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>