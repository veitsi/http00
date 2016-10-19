<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>

<div id="profile_error"></div>

<form id="profile_main" name="profile_main">
    <input type="text" name="name" value="<?=$data["name"]?>" placeholder="Имя и фамилия" /><br />
    <input type="text" name="city" value="<?=$data["city"]?>" placeholder="Город" /><br />
    <input type="text" name="email" value="<?=$data["login"]?>" disabled placeholder="Email" /><br />
    <textarea name="about" placeholder="Обо мне"><?=$data["about"]?></textarea><br />
    <input type="radio" <? if ($data["gender"] == 1): ?>checked<? endif; ?> name="gender" value="1" />Мальчик<br />
    <input type="radio" <? if ($data["gender"] == 2): ?>checked<? endif; ?> name="gender" value="2" />Девочка
    <?=$select_bodytype->getHTML() ?>
</form>
<a id="profile_main_save" href="#js">Обновить информацию</a>

<br /><br /><br />

<? if(!empty($subscriptions)): ?>
<form id="profile_subscriptions" name="profile_subscriptions">
    <? foreach ($subscriptions as $s): ?>
        <?=$s["name"]?><input type="checkbox" name="sub[<?=$s["id"]?>]" <? if ($s["subscribed"] == 1): ?>checked<? endif; ?> value="1" />
    <? endforeach; ?>
</form>
<a id="profile_subscriptions_save" href="#js">Обновить подписки</a>
<? endif ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#profile_main_save").on("click", function(e) {
            e.preventDefault();
            $("#profile_error").html();
            form_data = $("#profile_main").serialize();
            $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'profile', data: form_data}, function(r) {
                try {
                    result = jQuery.parseJSON(r);
                } catch(err){
                    alert(err);
                }
                if (result.status == "success") {
                    alert(result.mes);
                } else {
                    $("#profile_error").html(result.mes);
                }
            });
        });
        $("#profile_subscriptions_save").on("click", function(e) {
            e.preventDefault();
            $("#profile_error").html();
            form_data = $("#profile_subscriptions").serialize();
            $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'profile_subscriptions', data: form_data}, function(r) {
                try {
                    result = jQuery.parseJSON(r);
                } catch(err){
                    alert(err);
                }
                if (result.status == "success") {
                    alert(result.mes);
                } else {
                    $("#profile_error").html(result.mes);
                }
            });
        });
    });
</script>