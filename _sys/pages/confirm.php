<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

//Ошибка при многомерной ссылке
if (isset($F_URL) and count($F_URL) > 1) die(include_once(F_PATH_SYS.'pages/404.php'));

//Библиотеки
include_once(F_PATH_SYS.'lib/header.lib.php');
include_once(F_PATH_SYS.'lib/footer.lib.php');

//Заполняем переменные шаблона
$F_PAGE_GEN['title'] = "title";
$F_PAGE_GEN['description'] = "description";
$F_PAGE_GEN['keywords'] = "meta_keys";
$F_PAGE_GEN['robots'] = 'all';

$email = filter_input(INPUT_GET, 'reg', FILTER_VALIDATE_EMAIL);
$cid = filter_input(INPUT_GET, 'cid');

if (!empty($email) and !empty($cid)) {
        $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
        $num_rows = $nr->fetchColumn();

        if ($num_rows > 0) {
            $rs = DB::con()->query("SELECT `id`,`pass`,`salt`,`confirmed` FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote($email)) or die(Fianta::err(__FILE__, __LINE__));
            $row = $rs->fetch(PDO::FETCH_ASSOC);
            
            if ($row['confirmed'] == 1) {
                $text = 'Email уже был подтвержден ранее. Вы можете войти на сайт.';
            } else {
                if (Auth::crypt_pass($row["pass"], $row["salt"]) !== $cid) {
                    $text = "Неверный код подтверждения";
                } else {
                    DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET `confirmed`='1' WHERE `id`=".$row['id']) or die(Fianta::err(__FILE__, __LINE__));
                    if (F_LOGGED) {
                        header("Location: http://".filter_input(INPUT_SERVER,'HTTP_HOST')."/cabinet.html");
                    } else {
                        $text = 'Email успешно подтвержден. Вы можете войти на сайт.';
                    }
                }
            }
        } else {
            $text = "Такой пользователь не найден";
        }
} else {
    die(include_once(F_PATH_SYS.'pages/404.php'));
}

//Подключаем шаблон
include_once(F_PATH_SYS."tpl/auth/reg_confirmation.tpl.php");