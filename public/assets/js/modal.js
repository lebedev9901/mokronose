document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('authModal');
    const openBtn = document.querySelector('.header__enter button');
    const closeBtn = modal.querySelector('.modal-close');
    const overlay = modal.querySelector('.modal-overlay');
    const title = modal.querySelector('.modal-title');
    const switcher = modal.querySelector('.modal-switch span');
    const form = modal.querySelector('.auth-form');

    let mode = 'login';

    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
    });

    function closeModal() {
        modal.classList.remove('active');
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);

    switcher.addEventListener('click', () => {
        mode = mode === 'login' ? 'register' : 'login';

        title.textContent = mode === 'login' ? 'Вход' : 'Регистрация';
        switcher.textContent = mode === 'login'
            ? 'Зарегистрироваться'
            : 'Уже есть аккаунт? Войти';

        form.querySelector('.auth-btn').textContent =
            mode === 'login' ? 'Войти' : 'Зарегистрироваться';
    });

    form.addEventListener('submit', e => {
    e.preventDefault();
    console.log('Форма отправлена');

    const formData = new FormData(form);
    formData.append('action', mode);

    const url = mode === 'login' ? './actions/login.php' : './actions/registration.php';
    console.log('Отправляем на URL:', url);

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('Ответ сервера:', res);
        return res.json();
    })
    .then(data => {
    if (!data.success) {
        alert(data.message);
        return;
    }

    if (data.redirect) {
        window.location.href = data.redirect;
    }

    if (data.reload) {
        location.reload();
    }
})
    .catch(err => console.error('Ошибка fetch:', err));
});
});