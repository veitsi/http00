<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<header class="b-header">
    <nav class="b-nav">
        <ul class="b-nav-list">
            <li class="b-nav__item">
                <a class="b-nav__logo" href="/"></a>
            </li>
            <? if (isset($role_template) and file_exists(F_PATH_SYS."tpl/cabinet/".$role_template."/menu.tpl.php")): ?>
                <? include_once(F_PATH_SYS."tpl/cabinet/".$role_template."/menu.tpl.php") ?>
            <? endif ?>
        </ul>
    </nav>

    <? if (!F_LOGGED): ?>

        <nav class="b-nav">
            <ul class="b-nav-list">
                <li class="b-nav__item">
                    <a class="b-nav__link" href="/" data-el="login_trigger">Войти</a>
                </li>
            </ul>
        </nav>

    <? else: ?>
        <div class="b-nav">
            <ul class="b-nav-list">
                <li class="b-nav__item">
                    <div class="dropdown">
                        <button class="b-nav__button dropdown-toggle" type="button" data-toggle="dropdown">
                            <?=User::info("name")?>
                            <span class="b-user-block__caret caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                            <li><a role="menuitem" tabindex="-1" href="/cabinet.html">Мой кабинет</a></li>
                            <!--<li><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                            <li><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>-->
                            <li class="divider"></li>
                            <li><a id="sign_logout" role="menuitem" tabindex="-1" href="#js">Выход</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    <? endif; ?>
</header>