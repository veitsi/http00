<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$data = [];
$sdata = filter_input(INPUT_POST, 'data');
parse_str($sdata, $data);

if (!empty($data)) {
    $data["confirmed"] = 0;
    $data["role_id"] = 3;

//    $p = strpos(trim($data["fio"]), " ");
//    if ($p === false) {
//        $data["name"] = $data["fio"];
//        $data["sname"] = "";
//    } else {
//        $data["name"] = trim(substr($data["fio"], 0, $p));
//        $data["sname"] = trim(substr($data["fio"], $p + 1));
//    }
    if (!isset($data["name"]) or empty($data["name"])) {
        $result = new AjaxResponse("success", "Не указано: Имя и фамилия");
        exit($result->json());
    }

    $err = Auth::reg($data, $data["pass"], $data["pass"]);
    if (empty($err)) {
        $result = new AjaxResponse("success", "Регистрация прошла успешно, на ваш email отправлено письмо с активацией учетной записи");
        exit($result->json());
    } else {
        $result = new AjaxResponse("error", $err);
        exit($result->json());
    }
} else {
    $result = new AjaxResponse("error", "Ошибка данных при регистрации");
    exit($result->json());
}