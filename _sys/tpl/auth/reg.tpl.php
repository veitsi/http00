<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <? include_once(F_PATH_SYS."tpl/inc/html.tpl.php") ?>
    </head>
    <body>
        <? include_once(F_PATH_SYS."tpl/inc/header.tpl.php") ?>
        <div id="content">
            <? include_once(F_PATH_SYS."tpl/inner/reg_form.tpl.php") ?>
            <br /><br />
            <? include_once(F_PATH_SYS."tpl/inner/recovery_form.tpl.php") ?>
        </div>
        <? include_once(F_PATH_SYS."tpl/inc/footer.tpl.php") ?>
    </body>
</html>