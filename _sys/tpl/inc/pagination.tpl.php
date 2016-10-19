<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<? if (!empty($pagination)): ?>
    <div class="page_navigation">
        <ul class="nav_cat">
            <? foreach ($pagination as $p): ?>
                <li <?=Editor::getVal($p["class"])?>><a <?=Editor::getVal($p["href"])?>><?=Editor::getVal($p["num"])?></a></li>
            <? endforeach; ?>
        </ul>
        <div class="cb"></div>
    </div>
<? endif; ?>

