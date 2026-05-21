
<footer class="footer">
            <div class="container">
                <div class="footer__contain flex">
                    <ul class="list-reset footer__list-links flex">
                        <li class="footer__list-item">
                            <a href="<?php echo e(route('catalog')); ?>">Каталог</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="<?php echo e(route('aboute')); ?>">О нас</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="<?php echo e(route('reviews')); ?>">Отзывы</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="<?php echo e(route('pay')); ?>">Доставка и оплата</a>
                        </li>
                        <li class="footer__list-item">
                              <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('profile.index')); ?>" class="btn-reset header__user">
                                        ЛК   
                                    </a>
                                <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-reset header__login" id="login">Вход
                                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#prefix__clip0_705_5)" fill="#f5f5f5"><path d="M21 24h-3v-5a2 2 0 00-2-2H8a2 2 0 00-2 2v5H3v-5a5.006 5.006 0 015-5h8a5.006 5.006 0 015 5v5zM12 12a6 6 0 110-12 6 6 0 010 12zm0-9a3 3 0 100 6 3 3 0 000-6z"/></g><defs><clipPath id="prefix__clip0_705_5"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></svg>
</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <a class="footer__desing" href="https://vk.com/lebedew136">{ } LebedevDev</a>
                    <div class="copyrite flex">
                        <h4 class="copyrite__title">МокроНос</h4>
                        <p class="copyrite__descr">лакоства для собак</p>
                        <p class="copyrite__date">
                            <?php echo e(date('Y')); ?>

                        </p>
                    </div>
                    <div class="footer__contacts">
                        <a href="tel:+79772914761">+7 (977) 291-47-61</a>
                        <p>📍 Москва</p>
                        <a href="mailto:mokronose@mail.ru">mokronose@mail.ru</a>
                    </div>
                </div>
            </div>
        </footer>

<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/partials/footer.blade.php ENDPATH**/ ?>