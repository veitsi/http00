<? defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')) ?>
<table width="100%" style="border-left:1px solid #550f81;border-right:1px solid #550f81;font-size:16px;padding-left:10px">
    <tr>
        <td colspan="3">
            <p style="font-family:Arial;color:#404040;font-size:25px;padding-left:20px;border-left:5px solid #ff8a00;padding-top:0;padding-bottom:0;margin:10px 0">
                Подтверждение регистрации
            </p>
        </td>
    </tr>
    <tr>
        <td>
            Добро пожаловать, <?=$name?>!<br /><br />
            Благодарим Вас за регистрацию<br />
            Для подтверждения электронного адреса, пожалуйста, перейдите по ссылке: <a href="<?=$link?>"><?=$link?></a><br /><br />
            Это сообщение отправлено автоматически, пожалуйста, не отвечайте на него<br />
        </td>
    </tr>
    <tr>
        <td>
            <span style="color:#cccccc;font-size: 13px;"><?=date('Y/m/d H:i:s')?></span>
        </td>
    </tr>
</table>