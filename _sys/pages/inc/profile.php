<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

$user = new GetUser(User::info("id"));
$data = $user->getData();

$subscriptions = Subscriptions::getList(User::info("id"));

if (!empty($data)) {
    $select_bodytype = new Select("bodytype_id");
    $select_bodytype->setValue("0", "Не указана");
    $select_bodytype->getArrayFromDB("users_bodytypes","id","name");
    $select_bodytype->setOptionSelected([$data["bodytype_id"]]);
    
    $template_path = F_PATH_SYS."tpl/cabinet/profile.tpl.php";
} else {
    die(include_once(F_PATH_SYS.'pages/404.php'));
}