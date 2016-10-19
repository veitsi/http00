<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

if (F_LOGGED and User::info("role_id") == 1) {

    $data = [];
    $sdata = filter_input(INPUT_POST, 'data');
    parse_str($sdata, $data);

    //Валидация
    if (!isset($data["name"]) or empty($data["name"])) {
        $result = new AjaxResponse("error", "Не указано название категории");
        exit($result->json());
    }
    if ($data["id"] != 0) {
        $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."products_categories` WHERE `id`=".DB::quote($data["id"])) or die(Fianta::err(__FILE__, __LINE__));
        $num_rows = $nr->fetchColumn();
        if ($num_rows != 1) {
            $result = new AjaxResponse("error", "Такой категории больше не существует, возможно она был удалена");
            exit($result->json());
        }
    }
    $fields = [
        "name" => strip_tags(trim($data["name"])),
        "parent_id" => strip_tags(trim($data["parent_id"])),
        "enabled" => Editor::getVal($data["enabled"], 0),
        "updated" => DB::toUnixDate(date("Y-m-d H:i:s")),
        "user_id" => User::info("id")
    ];
    $qb = new QueryBuilder($fields);
    if ($data["id"] != 0) {
        DB::con()->query("UPDATE `".F_DB_PREFIX."products_categories` SET ".$qb->update_string." WHERE `id`=".DB::quote($data["id"])) or die(Fianta::err(__FILE__, __LINE__));
        $result = new AjaxResponse("success", "Успешно сохранено");
        exit($result->json());
    } else {
        DB::con()->query("INSERT INTO `".F_DB_PREFIX."products_categories` (".$qb->insert_fields.") VALUES (".$qb->insert_values.")") or die(Fianta::err(__FILE__, __LINE__));
        $d["last_id"] = DB::con()->lastInsertId();
        $_SESSION["o_result"] = "Успешно добавлено";
        $result = new AjaxResponse("success", "Успешно добавлено", $d);
        exit($result->json());
    }

} else {
    $result = new AjaxResponse("error", "Отсутствует доступ");
    exit($result->json());
}