<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); 

if (F_LOGGED and User::info("role_id") == 1) {

    $data = [];
    $sdata = filter_input(INPUT_POST, 'data');
    parse_str($sdata, $data);

    //Валидация
    $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `id`=".DB::quote($data["id"])) or die(Fianta::err(__FILE__, __LINE__));
    $num_rows = $nr->fetchColumn();
    if ($num_rows != 1) {
        $result = new AjaxResponse("error", "Такого пользователя больше не существует, возможно он был удален");
        exit($result->json());
    }
    if (!isset($data["name"]) or empty($data["name"])) {
        $result = new AjaxResponse("error", "Не указано: Имя и фамилия");
        exit($result->json());
    }
    $fields = [
        "name" => strip_tags(trim($data["name"])),
        "city" => strip_tags(trim($data["city"])),
        "role_id" => strip_tags(trim($data["role_id"])),
        "comment" => strip_tags(trim($data["comment"])),
        "updated" => DB::toUnixDate(date("Y-m-d H:i:s")),
        "user_id" => User::info("id")
    ];
    $qb = new QueryBuilder($fields);
    DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET ".$qb->update_string." WHERE `id`=".DB::quote($data["id"])) or die(Fianta::err(__FILE__, __LINE__));

    if (User::info("id") == $data["id"]) {
        Auth::relogin();
    }

    $result = new AjaxResponse("success", "Успешно сохранено");
    exit($result->json());

} else {
    $result = new AjaxResponse("error", "Отсутствует доступ");
    exit($result->json());
}