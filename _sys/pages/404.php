<?php
header('HTTP/1.0 404 not found');

//Инициализация ядра
require_once(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').F_CORE_FOLDER_PATH.'init.php');

if (file_exists(F_PATH_SYS.'tpl/404.tpl.php')) {
    require_once(F_PATH_SYS.'tpl/404.tpl.php');
} else {
    header('HTTP/1.0 404 not found');
    echo '404 NOT FOUND';
}