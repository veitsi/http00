<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); 

if (F_LOGGED and User::info("role_id") == 1) {

    include_once(F_PATH_SYS.'lib/cabinet.lib.php');
    $categories = Cabinet::ProductsCategories();
    exit(json_encode($categories, JSON_UNESCAPED_UNICODE));

}