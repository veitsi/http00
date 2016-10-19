<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<li class="b-nav__item b-active">
    <a class="b-nav__link" href="/cabinet/users.html">Пользователи<span class="badge">??</span></a>
</li>
<li class="b-nav__item">
    <a class="b-nav__link" href="#">Луки<span class="badge">??</span></a>
</li>
<li class="b-nav__item">
    <a class="b-nav__link" href="#">Стилисты<span class="badge">??</span></a>
</li>
<li class="b-nav__item">
    <div class="dropdown">
        <button class="b-nav__button dropdown-toggle" type="button" data-toggle="dropdown">
            Категории
            <span class="b-user-block__caret caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <li><a href="">Категории луков</a></li>
            <!--<li><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
            <li><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>-->
            <li><a href="">Категории товаров</a></li>
        </ul>
    </div>
</li>