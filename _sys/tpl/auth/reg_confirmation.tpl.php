<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <? include_once(F_PATH_SYS."tpl/inc/html.tpl.php") ?>
    </head>
    <body>
    <? include_once(F_PATH_SYS."tpl/inc/header.tpl.php") ?>
    <div class="l-layout" id="content">
        <div class="b-service-title">
            <div class="b-service-text__header">Подтверждение регистрации</div>
            <div class="b-service-text__message"> <?= Editor::getVal($text)?></div>
        </div>
    </div>
    <? include_once(F_PATH_SYS."tpl/inc/footer.tpl.php") ?>
    </body>
</html>