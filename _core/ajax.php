<?php
/* * ***********************************************************************************************
  CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV
  Запрещено использование данного программного кода или его части в любых целях без согласия автора.
  COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
 * ************************************************************************************************ */

//FIANTRY AJAX
if (!empty(filter_input_array(INPUT_POST))) {

    //Инициализация ядра
    require_once('init.php');

    //Проверяем AJAX-токен
    if (isset($_SESSION['token']) and filter_input(INPUT_POST, 'token') == $_SESSION['token']) {

        //Обрабатываем данные Ajax и направляем в нужную функцию
        $file = filter_input(INPUT_POST, 'file');
        $handler = filter_input(INPUT_POST, 'handler');
        $mod_file = filter_input(INPUT_POST, 'mod_file');
        $F_MOD = filter_input(INPUT_POST, 'mod');
        
        if (!empty($file)) {
            if (file_exists(F_PATH_SYS.'ajax/'.$file.'.ajax.php')) {
                include_once(F_PATH_SYS.'ajax/'.$file.'.ajax.php');
            } else {
                $result = new AjaxResponse("error", "Ошибка AJAX запроса, обработчик не найден (".date('H:i:s').")");
                exit($result->json());
            }
        } elseif (!empty($handler)) { 
            if (file_exists(F_PATH_CORE.'cms/ajax/'.$handler.'.ajax.php')) {
                include_once(F_PATH_CORE.'cms/ajax/'.$handler.'.ajax.php');
            } else {
                $result = new AjaxResponse("error", "Ошибка AJAX запроса, обработчик не найден (".date('H:i:s').")");
                exit($result->json());
            }
        } elseif (!empty($F_MOD) and !empty($mod_file)) { 
            if (file_exists(F_PATH_CORE.'cms/mod/'.$F_MOD.'/ajax/'.$mod_file.'.ajax.php')) {
                include_once(F_PATH_CORE.'cms/mod/'.$F_MOD.'/ajax/'.$mod_file.'.ajax.php');
            } else {
                $result = new AjaxResponse("error", "Ошибка AJAX запроса, обработчик модуля не найден (".date('H:i:s').")");
                exit($result->json());
            }
        } else {
            $result = new AjaxResponse("error", "Ошибка AJAX запроса, обработчик не указан (".date('H:i:s').")");
            exit($result->json());
        }
    } else {
        $result = new AjaxResponse("error", "Ошибка безопасности при выполнении AJAX запроса. Попробуйте обновить страницу (".date('H:i:s').")");
        exit($result->json());
    }
} else {
    include_once("_404.php");
}