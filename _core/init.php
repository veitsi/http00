<?php
/*************************************************************************************************
CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV
Запрещено использование данного программного кода или его части в любых целях без согласия автора. 
COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
**************************************************************************************************/
//FIANTRY ENTRY

//Вывод всех ошибок
error_reporting(E_ALL);

//Пути
define('F_PATH_CORE', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').F_CORE_FOLDER_PATH);
define('F_PATH_SYS', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').F_SYS_FOLDER_PATH);
define('F_PATH_WWW', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')."/");

//Проверка версии PHP
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
if (PHP_VERSION_ID < 70000) {
    die("Для корректной работы сайта на сервере требуется версия PHP7 или выше");
}

//Использовать только cookie для передачи идентификатора сессии
ini_set('session.use_trans_sid', false); 
ini_set('session.use_only_cookies', true);
session_name("F_SID");
session_set_cookie_params(0, "/", "", false, true);
session_start();

//Константа доступа к файлам
define('FIANTA_ACC', 1);

//Версия ядра
define('FIANTA_VER', "6.1");

//Константы доступа
define('CAN_CREATE', 1 << 0); // 0000001
define('CAN_READ_OWN', 1 << 1);   // 0000010
define('CAN_UPDATE_OWN', 1 << 2);   // 0000100
define('CAN_DELETE_OWN', 1 << 3); // 0001000
define('CAN_READ_ANY', 1 << 4);   // 0010000
define('CAN_UPDATE_ANY', 1 << 5);   // 0100000
define('CAN_DELETE_ANY', 1 << 6); // 1000000

//Функционал
require_once(F_PATH_CORE.'lib/core.lib.php');

//Аутентификация
define('F_LOGGED', Auth::check());