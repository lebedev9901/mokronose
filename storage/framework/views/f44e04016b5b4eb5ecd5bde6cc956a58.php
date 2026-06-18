<footer class="footer">
    <div class="container">

        <div class="footer__contain">

            <div class="footer__column">

                <h4 class="footer__title">
                    МокроНос
                </h4>

                <p class="footer__text">
                    Натуральные лакомства для собак
                </p>

                <ul class="list-reset footer__list-links">
                    <li>
                        <a href="<?php echo e(route('catalog')); ?>">Каталог</a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('aboute')); ?>">О нас</a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('reviews')); ?>">Отзывы</a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('pay')); ?>">Доставка и оплата</a>
                    </li>

                    <li>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('profile.index')); ?>">
                                Личный кабинет
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>">
                                Вход
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>

            </div>

            <div class="footer__column">

                <h4 class="footer__title">
                    Контакты
                </h4>

                <div class="footer__contacts">

                    <a href="tel:+79772914761">
                        +7 (977) 291-47-61
                    </a>

                    <a href="mailto:mokronose@mail.ru">
                        mokronose@mail.ru
                    </a>

                    <p>
                        Московская область,
                        г.о. Подольск,
                        п. Железнодорожный,
                        д. 28
                    </p>

                   

                </div>

            </div>

            <div class="footer__column">

                <h4 class="footer__title">
                    Реквизиты
                </h4>

                <div class="footer__requisites">

                    <p>
                        ИП Мельникова Анастасия Константиновна
                    </p>

                    <p>
                        ИНН: 504814952507
                    </p>

                    <p>
                        ОГРНИП: 322508100427024
                    </p>

                    <p>
                        Р/С: 40802810400008813384
                    </p>

                    <p>
                        ООО "ТБанк"
                    </p>

                    <p>
                        БИК: 044525974
                    </p>

                    <p>
                        К/С: 30101810145250000974
                    </p>

                </div>

            </div>

        </div>

        <div class="footer__bottom">

            <p>
                © <?php echo e(date('Y')); ?> МокроНос. Все права защищены.
            </p>

            <a href="https://lebedevdev.ru">
                Разработка сайта — LebedevDev
            </a>

        </div>

    </div>
</footer><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/partials/footer.blade.php ENDPATH**/ ?>