<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); ?>

<? if (!F_LOGGED): ?>
    <form id="rec_form" name="rec_form">
        Email*:<br />
        <input type="text" name="login" /><br />
    </form>
    <div id="rec_error"></div>
    <a href="#js" id="sign_rec">Восстановить</a>
<? endif; ?>
