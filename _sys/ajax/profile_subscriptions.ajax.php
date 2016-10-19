<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$data = [];
$sdata = filter_input(INPUT_POST, 'data');
parse_str($sdata, $data);

//Обнуление подписки
DB::con()->query("DELETE FROM `".F_DB_PREFIX."users_subscriptions` WHERE `user_id`=".DB::quote(User::info("id"))) or die(Fianta::err(__FILE__, __LINE__));

//Сохраняем остальные подписки
if (!empty($data["sub"])) {
    $sud_ids = array_keys($data["sub"]);
    $pr = DB::con()->prepare("INSERT INTO `".F_DB_PREFIX."users_subscriptions` (`user_id`,`subscription_id`) VALUES (".DB::quote(User::info("id")).",?)") or die(Fianta::err(__FILE__, __LINE__));
    foreach ($sud_ids as $d) {
        $pr->bindParam(1, $d);
        $pr->execute();
    }
}

$result = new AjaxResponse("success", "Успешно сохранено");
exit($result->json());