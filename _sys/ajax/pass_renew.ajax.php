<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$data = [];
$sdata = filter_input(INPUT_POST, 'data');
parse_str($sdata, $data);

if (empty($data)) {
    $result = new AjaxResponse("error", "Ошибка данных при обновлении пароля");
    exit($result->json());
}
$email = filter_var($data["login"], FILTER_VALIDATE_EMAIL);
if (empty($email)) {
    $result = new AjaxResponse("error", "Email указан некорректно");
    exit($result->json());
}
$nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
$num_rows = $nr->fetchColumn();
if (empty($num_rows)) {
    $result = new AjaxResponse("error", "Такой email не зарегистрирован на сайте");
    exit($result->json());
}

$pass = filter_var($data["pass"]);
$pass2 = filter_var($data["pass2"]);
$h = filter_var($data["h"]);

$err = Auth::passValidation($pass,$pass2);
if (!empty($err)) {
    $result = new AjaxResponse("error", $err);
    exit($result->json());
}

$rs = DB::con()->query("SELECT `login`,`pass`,`salt` FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
$row = $rs->fetch(PDO::FETCH_ASSOC);
$hash = Auth::crypt($row['login'].$row['pass'].$row['salt']);

if ($hash == $h) {
    $new_pass = Auth::crypt_pass($pass, $row['salt']);
    DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET `pass`=".DB::quote($new_pass)." WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
}

$result = new AjaxResponse("success", "Пароль успешно изменен");
exit($result->json());