<?php defined('FIANTA_ACC') or die(include_once($_SERVER['DOCUMENT_ROOT'].'/404.php'));

//Ошибка при многомерной ссылке
if (isset($F_URL) and count($F_URL) > 1) die(include_once(F_PATH_SYS.'pages/404.php'));

$h = filter_input(INPUT_GET, 'h');
$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);

if (empty($h) or empty($email)) {
    die(include_once(F_PATH_SYS.'pages/404.php'));
}
$rs = DB::con()->query("SELECT `login`,`pass`,`salt` FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
$row = $rs->fetch(PDO::FETCH_ASSOC);
$hash = Auth::crypt($row['login'].$row['pass'].$row['salt']);
if ($hash != $h) {
    die(include_once(F_PATH_SYS.'pages/404.php'));
}

//Библиотеки
include_once(F_PATH_SYS.'lib/header.lib.php');
include_once(F_PATH_SYS.'lib/footer.lib.php');

//Заполняем переменные шаблона
$F_PAGE_GEN['title'] = "Восстановление пароля";
$F_PAGE_GEN['robots'] = "none"; 

//Подключаем шаблон
include_once(F_PATH_SYS."tpl/auth/pass_recovery.tpl.php");