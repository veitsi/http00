<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$data = [];
$sdata = filter_input(INPUT_POST, 'data');
parse_str($sdata, $data);

if (!empty($data) and $data["auth_type"] == 1) {
    $err = Auth::login($data["email"], $data["pass"]);
    if(!empty($err)) {
        $result = new AjaxResponse("error", $err);
        exit($result->json());
    } else {
        $result = new AjaxResponse("success");
        exit($result->json());
    }
} elseif (!empty($data) and $data["auth_type"] == 0) {
    if (F_LOGGED) {
        Auth::logout();
    }
} else {
    $result = new AjaxResponse("error", "Ошибка типа авторизации");
    exit($result->json());
}