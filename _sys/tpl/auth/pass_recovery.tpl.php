<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <? include_once(F_PATH_SYS."tpl/inc/html.tpl.php") ?>
    </head>
    <body>
    <? include_once(F_PATH_SYS."tpl/inc/header.tpl.php") ?>
    <div class="l-layout" id="content">
        <div class="b-login b-login_wrapped">
            <div class="b-login__header">Смена пароля</div>
            <form class="b-login-form" id="passw_renew" name="passw_renew" method="post">
                <input type="hidden" name="h" value="<?=$h?>" />
                <div class="b-login-form-item">
                    <label for="login_rec" class="b-login-form__label">Логин (email):</label>
                    <input class="b-login-form__input b-input" id="login_rec" readonly name="login" value="<?=$email?>" >
                </div>
                <div class="b-login-form-item">
                    <label for="pass" class="b-login-form__label">Введите новый пароль:</label>
                    <input class="b-login-form__input b-input" id="pass" type="password" name="pass" >
                </div>
                <div class="b-login-form-item">
                    <label for="pass2" class="b-login-form__label">Введите пароль еще раз:</label>
                    <input class="b-login-form__input b-input" id="pass2" type="password" name="pass2" >
                </div>
                <button class="b-button b-button_green" href="#js" id="passw">Сменить пароль</button>
            </form>
        </div>
    </div>
    <? include_once(F_PATH_SYS."tpl/inc/footer.tpl.php") ?>
    </body>
    <script type="text/javascript">
        $(function() {
            $("#passw").on("click", function(e) {
                e.preventDefault();
                $("#passw_error").html();
                form_data = $("#passw_renew").serialize();
                $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'pass_renew', data: form_data}, function(r) {
                    try {
                        result = jQuery.parseJSON(r);
                    } catch(err){
                        alert(err);
                    }
                    if (result.status == "success") {
                        window.location.href = "/";
                    } else {
                        $("#passw_error").html(result.mes);
                    }
                });
            });
        });
    </script>
</html>
