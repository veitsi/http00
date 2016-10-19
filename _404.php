<?php

//Обработчик 404
require_once('_config.php');
if (file_exists(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').F_SYS_FOLDER_PATH.'pages/404.php')) {
    require_once(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').F_SYS_FOLDER_PATH.'pages/404.php');
} else {
    header('HTTP/1.0 404 not found');
    echo '404 NOT FOUND';
}