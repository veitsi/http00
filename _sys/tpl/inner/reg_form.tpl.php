<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); ?>

<? if (!F_LOGGED): ?>
    <form id="reg_form" name="reg_form">
        Имя и фамилия*:<br />
        <input type="text" name="name" /><br />
        Email*:<br />
        <input type="text" name="login" /><br />
        Пароль*:<br />
        <input type="password" name="pass" /><br />
    </form>
    <div id="reg_error"></div>
    <a href="#js" id="sign_reg">Регистрация</a>
<? endif; ?>
