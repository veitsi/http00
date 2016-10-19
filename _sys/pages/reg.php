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

//Подключаем шаблон
include_once(F_PATH_SYS."tpl/auth/reg.tpl.php");