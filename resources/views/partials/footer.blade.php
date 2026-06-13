
<footer class="footer">
            <div class="container">
                <div class="footer__contain flex">
                    <ul class="list-reset footer__list-links flex">
                        <li class="footer__list-item">
                            <a href="{{ route('catalog')}}">Каталог</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="{{ route('aboute')}}">О нас</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="{{route('reviews')}}">Отзывы</a>
                        </li>
                        <li class="footer__list-item">
                            <a href="{{route('pay')}}">Доставка и оплата</a>
                        </li>
                        <li class="footer__list-item">
                              @auth
                                    <a href="{{route('profile.index')}}" class="btn-reset header__user">
                                        Личный кабинет   
                                    </a>
                                @else
                            <a href="{{route('login')}}" class="btn-reset header__login" id="login">Вход</a>
                            @endauth
                        </li>
                    </ul>
                    <a class="footer__desing" href="https://mokronos.ru/download/mokronose.apk">Мобильное приложение</a>
                    <a class="footer__desing" href="https://vk.com/lebedew136">{ } LebedevDev</a>
                    <div class="copyrite flex">
                        <h4 class="copyrite__title">МокроНос</h4>
                        <p class="copyrite__descr">лакомства для собак</p>
                        <p class="copyrite__date">
                            {{date('Y')}}
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

