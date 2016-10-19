<?php
/*************************************************************************************************
CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV
Запрещено использование данного программного кода или его части в любых целях без согласия автора. 
COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
**************************************************************************************************/

//FIANTRY ENTRY
header('Content-Type: text/html; charset=utf-8');

//Инициализация ядра
require_once('init.php');

//Ajax токен 
Auth::token();

//Контроллер запросов
$url = filter_input(INPUT_GET, 'a');
if (!empty($url)) {
    $F_URL = explode("/",$url);
}

if (strpos(filter_input(INPUT_SERVER, 'REQUEST_URI'), "/_fianta.php") === 0) { 
    include_once(F_PATH_SYS."pages/404.php"); return;
}

if (empty($url)) {	
    include_once(F_PATH_SYS."pages/index.php");	
} else {
    (file_exists(F_PATH_SYS."pages/".$F_URL[0].".php"))?include_once(F_PATH_SYS."pages/".$F_URL[0].".php"):include_once(F_PATH_SYS."pages/404.php");		
}