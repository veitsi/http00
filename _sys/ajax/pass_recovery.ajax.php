<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$data = [];
$sdata = filter_input(INPUT_POST, 'data');
parse_str($sdata, $data);

if (empty($data)) {
    $result = new AjaxResponse("error", "Ошибка данных при восстановлении пароля");
    exit($result->json());
}
$email = filter_var($data["login"], FILTER_VALIDATE_EMAIL);
if (empty($email)) {
    $result = new AjaxResponse("error", "Email заполнен некорректно");
    exit($result->json());
}
$nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
$num_rows = $nr->fetchColumn();
if (empty($num_rows)) {
    $result = new AjaxResponse("error", "Такой email не зарегистрирован на сайте");
    exit($result->json());
}

$rs = DB::con()->query("SELECT `login`,`name`,`pass`,`salt` FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
$row = $rs->fetch(PDO::FETCH_ASSOC);

//Отправка email
$hash = Auth::crypt($row['login'].$row['pass'].$row['salt']);
$link = 'http://'.$_SERVER['SERVER_NAME'].'/restore.html?email='.$row['login'].'&h='.$hash;
$name = $row['name'];

ob_start();
include(F_PATH_SYS."tpl/emails/pass_recovery.tpl.php");
$msg = ob_get_clean();

$receivers_array = [trim($row['login'])];
$e_mail = new Email($receivers_array, "Восстановление пароля", $msg);
$err = $e_mail->mailSend();

if ($err != 1) {
    $result = new AjaxResponse("error", $err);
    exit($result->json());
}

$result = new AjaxResponse("success", "На указанный электронный адрес отправлены дальнейшие инструкции по восстановлению доступа к аккаунту");
exit($result->json());