<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));
/*************************************************************************************************************
CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV - COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
 *************************************************************************************************************/

//ФУНКЦИИ HEADER
if (preg_match('/(?i)msie [5-8]/', filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'))) {
    include_once(F_PATH_SYS."tpl/inc/ie.tpl.php");
    exit();
}