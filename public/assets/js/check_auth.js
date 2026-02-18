document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');

    checkoutBtn.addEventListener('click', function() {
        // Проверяем авторизацию
        const isLoggedIn = window.USER_LOGGED_IN || false; // передаем через шаблон PHP

        if (isLoggedIn) {
            // Пользователь авторизован – переходим на страницу оформления
            window.location.href = window.BASE_URL + '/index.php?page=checkout';
        } else {
            // Не авторизован – открываем модалку регистрации
            // openRegistrationModal();
             const modal = document.getElementById('authModal');
            if (modal) modal.classList.add('active');
        }
    });

    // function openRegistrationModal() {
    //     // Можно сделать через свой попап или библиотеку
    //     const modal = document.getElementById('authModal');
    //         if (modal) modal.classList.add('active');
    //     // alert('Пожалуйста, зарегистрируйтесь или войдите!');
    // }
});
