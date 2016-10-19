<?php 

defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

/* * ***********************************************************************************************
  CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV
  Запрещено использование данного программного кода или его части в любых целях без согласия автора.
  COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
 * ************************************************************************************************ */

//АУНТЕФИКАЦИЯ
class Auth {

    // PRIVATE
    static private function userInfo($login) {
        //Проверяем есть ли запись с таким логином
        $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote(trim($login))) or die(Fianta::err(__FILE__, __LINE__));
        $num_rows = $nr->fetchColumn();
        if ($num_rows == 1) {
            //Тянем все данные из базы о юзере
            $rs = DB::con()->query("SELECT * FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote(trim($login))) or die(Fianta::err(__FILE__, __LINE__));
            return $rs->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    static private function userAuth($login) {
        //Генерируем случайный UID (идентификатор сессии) и хешируем его
        $uid = self::crypt(random_int(1000000000, 2147483647));
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, ["options" => ["default" => "0.0.0.0"]]);

        //Заносим в БД, сессию и куки
        DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET `uid`=".DB::quote($uid).",`ip`=".DB::quote($ip).",`logindate`=".DB::quote(DB::toUnixDate(date("d.m.Y H:i:s")))." WHERE `login`=".DB::quote(trim($login))) or die(Fianta::err(__FILE__, __LINE__));

        $_SESSION['UID'] = $uid;
        setcookie("UID", "", time() - 3600, "/", "", false, true);
        setcookie("UID", $uid, time() + 60 * 60 * 24, "/", "", false, true);
    }

    static private function refreshCockies($current_val) {
        //Продлеваем жизнь кукам еще на 5 часов и возвращаем TRUE
        setcookie("UID", "", time() - 3600, "/", "", false, true);
        setcookie("UID", $current_val, time() + 60 * 60 * 24, "/", "", false, true);
    }

    static private function setUserSession(array $user_data) {
        $_SESSION['user'] = $user_data;
        unset($_SESSION['user']['pass']);
        unset($_SESSION['user']['salt']);
    }

    static function passValidation($password, $password2) {
        if ($password == "") {
            return "Не указан пароль";
        }
        if ($password2 == "") {
            return "Не указано подтверждение пароля";
        }
        if ($password != $password2) {
            return "Пароли не совпадают";
        }
        if (strlen($password) < 6) {
            return "Минимальная длина пароля 6 символов";
        }
        if (strlen($password) > 50) {
            return "Максимальная длина пароля 50 символов";
        }
    }

    static private function sendConfirmation($link, $login, $name) {
        ob_start();
        include(F_PATH_SYS."tpl/emails/reg_confirmation.tpl.php");
        $msg = ob_get_clean();

        $receivers_array = [trim($login)];
        $e_mail = new Email($receivers_array, "Подтверждение регистрации", $msg);
        $result = $e_mail->mailSend();

        if ($result != 1) {
            return $result;
        }
    }

    //PUBLIC
    //Токен
    static function token() {
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = hash('sha256', random_int(1000000000, 2147483647));
        }
        return $_SESSION['token'];
    }

    //Хеширование
    static function crypt($str) {
        $crypted = hash('sha256', $str);
        return $crypted;
    }
    
    //Криптование пароля
    static function crypt_pass($password, $salt) {
        return self::crypt(self::crypt($password).$salt);
    }

    //Регистрация
    static function reg($post_fields, $password, $password2) {
        
        $allow_keys = ["login" => 1, "name" => 1, "sname" => 1, "mname" => 1, "phone" => 1, "gender" => 1, "photo" => 1, "confirmed" => 1, "role_id" => 1];
        $fields = array_intersect_key($post_fields, $allow_keys);

        if (trim($fields["login"]) == "") {
            return "Не указан email";
        }
        if (!filter_var(trim($fields["login"]), FILTER_VALIDATE_EMAIL)) {
            return "Email указан некорректно";
        }
        $error = self::passValidation($password, $password2);
        if (!empty($error)) {
            return $error;
        }

        $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote(trim($fields["login"]))) or die(Fianta::err(__FILE__, __LINE__));
        $num_rows = $nr->fetchColumn();
        if ($num_rows > 0) {
            return "Такой email уже зарегистрирован";
        } else {
            $fields["salt"] = mt_rand(100000, 999999);
            $fields["pass"] = self::crypt_pass(trim($password), $fields["salt"]);
            $fields["regdate"] = DB::toUnixDate(date("d.m.Y H:i:s"));
            $fields["updated"] = $fields["regdate"];
            $fields["ip"] = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, ["options" => ["default" => "0.0.0.0"]]);

            //Отправка подтверждения регистрации при необходимости
            if (isset($fields["confirmed"]) and  $fields["confirmed"] == 0) {
                $cid = self::crypt_pass($fields["pass"], $fields["salt"]);
                $link = 'http://'.filter_input(INPUT_SERVER, 'SERVER_NAME').'/confirm.html?reg='.trim($fields["login"]).'&cid='.$cid;
                $err = self::sendConfirmation($link, $fields["login"], Editor::getVal($fields["name"]));
            } 

            if (isset($err) and !empty($err)) {
                return "SMTP Error: ".$err;
            } else {
                $qb = new QueryBuilder($fields);
                DB::con()->query("INSERT INTO `".F_DB_PREFIX."users` (".$qb->insert_fields.") VALUES (".$qb->insert_values.")") or die(Fianta::err(__FILE__, __LINE__));
            }

        }
    }
    
    //Редактирование профиля
    static function profile($id, $post_fields, $password = NULL, $password2 = NULL) {
        
        $allow_keys = ["login" => 1, "name" => 1, "sname" => 1, "mname" => 1, "phone" => 1, "gender" => 1, "photo" => 1, "role_id" => 1];
        $fields = array_intersect_key($post_fields, $allow_keys);
        
        if (isset($fields["login"])) {
            if (trim($fields["login"]) == "") {
                return "Не указан email";
            }
            if (!filter_var(trim($fields["login"]), FILTER_VALIDATE_EMAIL)) {
                return "Email указан некорректно";
            }
            $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `login`=".DB::quote(trim($fields["login"]))." AND `id`!=".DB::quote($id)) or die(Fianta::err(__FILE__, __LINE__));
            $num_rows = $nr->fetchColumn();
            if ($num_rows > 0) {
                return "Такой email уже зарегистрирован";
            }
        }

        //Редактирование профиля
        $fields["updated"] = DB::toUnixDate(date("d.m.Y H:i:s"));
        $fields["ip"] = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, ["options" => ["default" => "0.0.0.0"]]);
        
        if (!empty($password)) {
            $error = self::passValidation(trim($password), trim($password2));
            if (!empty($error)) {
                return $error;
            } 
            $fields["salt"] = mt_rand(100000, 999999);
            $fields["pass"] = self::crypt_pass(trim($password), $fields["salt"]);
        }
        
        $qb = new QueryBuilder($fields);
        DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET ".$qb->update_string." WHERE `id`=".DB::quote($id)) or die(Fianta::err(__FILE__, __LINE__));
        self::relogin();
        
    }

    //Авторизация
    static function login($login, $pass) {

        if (!empty($login) and ! empty($pass)) {

            $user_info = self::userInfo($login);
            if ($user_info) {
                //Сверяем пароли
                if (self::crypt_pass(trim($pass), $user_info['salt']) == $user_info['pass']) {
                    //Проверяем активирована ли учетная запись
                    if ($user_info['confirmed'] == 1) {
                        self::userAuth($login);
                        //Записываем нужны данные о юзере в сессию
                        self::setUserSession($user_info);
                    } else {
                        //ДОБАВИТЬ ПОВТОРНУЮ ОТПРАВКУ ПИСЬМА									
                        return "Учетная запись не активирована, ссылка для активации была отправлена на e-mail, указанный при регистрации";
                    }
                } else {
                    return "Пароль или логин указан неверно";
                }
            } else {
                return "Пароль или логин указан неверно";
            }
        } else {
            return "Необходимо заполнить логин и пароль";
        }
    }

    //Выход из системы
    static function logout() {
        if (isset($_SESSION['UID'])) {
            $uid = $_SESSION['UID'];
            $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `uid`=".DB::quote($uid)) or die(Fianta::err(__FILE__, __LINE__));
            $num_rows = $nr->fetchColumn();
            if ($num_rows == 1) {
                DB::con()->query("UPDATE `".F_DB_PREFIX."users` SET `uid`='',`ip`='' WHERE `uid`=".DB::quote($uid)) or die(Fianta::err(__FILE__, __LINE__));
            }
        }
        session_unset();
        session_destroy();
        setcookie("UID", "", time() - 3600, "/", "", false, true);
        session_start();
    }

    //Обновление авторизации
    static function relogin() {
        unset($_SESSION['user']);
        self::check();
    }

    static function check() {

        //Если установлен UID сессии и UID в куках
        $cookie_uid = filter_input(INPUT_COOKIE, 'UID');

        if (isset($_SESSION['UID']) and ( !empty($cookie_uid))) {
            //Если UID сессии и в куках равны
            if ($_SESSION['UID'] == $cookie_uid) {
                self::refreshCockies($cookie_uid);
                return true;
            } else {
                //Вызываем LOGOUT для полной чистки данных в куках и сессии и возвращаем FALSE
                self::logout();
                return false;
            }
        }

        //Если установлена только сессия
        elseif (isset($_SESSION['UID'])) {
            $session_uid = $_SESSION['UID'];
            //Проверяем есть ли запись с таким идентификатором
            $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `uid`=".DB::quote($session_uid)) or die(Fianta::err(__FILE__, __LINE__));
            $num_rows = $nr->fetchColumn();
            if ($num_rows == 1) {
                self::refreshCockies($session_uid);
                return true;
            } else {
                return false;
            }
        }

        //Если установлена только кука (то сверяем еще и последний IP)
        elseif (!empty($cookie_uid)) {
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP, ["options" => ["default" => "0.0.0.0"]]);
            $nr = DB::con()->query("SELECT COUNT(*) FROM `".F_DB_PREFIX."users` WHERE `uid`=".DB::quote($cookie_uid)." AND `ip`=".DB::quote($ip)) or die(Fianta::err(__FILE__, __LINE__));
            $num_rows = $nr->fetchColumn();
            if ($num_rows == 1) {
                //Записываем UID сессию и возвращаем TRUE
                $_SESSION['UID'] = $cookie_uid;
                //Если данные о юзере также не в сессии, то записываем
                if (!isset($_SESSION['user'])) {
                    $rs = DB::con()->query("SELECT * FROM `".F_DB_PREFIX."users` WHERE `uid`=".DB::quote($cookie_uid)) or die(Fianta::err(__FILE__, __LINE__));
                    $row = $rs->fetch(PDO::FETCH_ASSOC);
                    self::setUserSession($row);
                }
                return true;
            }
        } else {
            return false;
        }
    }

}

class User {

    static function info($field) {

        if (F_LOGGED) {

            if (isset($_SESSION["user"][$field]) and $field != "acl") {

                return $_SESSION['user'][$field];
            } else {

                $rs = DB::con()->query("SELECT u.`id`, u.`login`, u.`name`, u.`gender`, u.`photo`, u.`phone`, u.`role_id`, ur.`name` AS `role`, "
                        ."ur.`name` AS `role`, ur.`name` AS `role` FROM `".F_DB_PREFIX."users` u "
                        ."JOIN `".F_DB_PREFIX."users_roles` ur ON u.`role_id`= ur.`id` "
                        ."WHERE u.`uid`='".Editor::getVal($_SESSION["UID"])."'") or die(Fianta::err(__FILE__, __LINE__));
                $user = $rs->fetch(PDO::FETCH_ASSOC);

                //Права доступа
                $acl = [];
                $rs_acl = DB::con()->query("SELECT `mod_alias`,`access` FROM `".F_DB_PREFIX."users_acl` WHERE `role_id`=".DB::quote($user["role_id"])) or die(Fianta::err(__FILE__, __LINE__));
                while ($row = $rs_acl->fetch(PDO::FETCH_ASSOC)) {
                    $acl[$row["mod_alias"]] = $row["access"];
                }
                $user["acl"] = $acl;

                $_SESSION['user'] = $user;

                if (isset($user[$field])) {
                    return $user[$field];
                } else {
                    return false;
                }
            }
        } else {

            return false;
        }
    }

    //Данные о любом пользователе
    static function byId($user_id) {
        $rs = DB::con()->query("SELECT u.`id`, u.`login`, u.`name`, u.`gender`, u.`photo`, u.`phone`, u.`role_id`, ur.`name` AS `role`, "
                ."ur.`name` AS `role`, ur.`name` AS `role` FROM `".F_DB_PREFIX."users` u "
                ."JOIN `".F_DB_PREFIX."users_roles` ur ON u.`role_id`= ur.`id` "
                ."WHERE u.`id`=".DB::quote($user_id)) or die(Fianta::err(__FILE__, __LINE__));
        $user_info = $rs->fetch(PDO::FETCH_ASSOC);
        return $user_info;
    }

}

class Permission {

    //Права доступа на модули
    static function mod($mod) {
        $acl = User::info("acl");

        //Права на модуль
        $mod_perm = Editor::getVal($acl[$mod], 0);

        //$mod_perm = decbin(Editor::getVal($acl[$mod], 0));
        if (User::info("role_id") == 1) {
            $mod_perm = CAN_CREATE | CAN_READ_OWN | CAN_UPDATE_OWN | CAN_DELETE_OWN | CAN_READ_ANY | CAN_UPDATE_ANY | CAN_DELETE_ANY;
        }

        return $mod_perm;
    }

}



//ГЛОБАЛЬНЫЕ ФУНКЦИИ
class DB {

    static private $db = [];
    private function __construct() {}
    private function __clone() {}

    //Соединение с базой данных PDO     
    static function con($db_name = false, $db_host = false, $db_user = false, $db_pass = false, $db_drv = false, $db_chr = false) {

        //Указываем БД
        if (!$db_name) {
            $db_name = F_DB_NAME;
        }

        // Создаем PDO подключение, если его еще не существует
        if (!isset(self::$db[$db_name])) {
            if (!$db_drv) {
                $db_drv = F_DB_DRIVER;
            }
            if (!$db_host) {
                $db_host = F_DB_HOST;
            }
            if (!$db_user) {
                $db_user = F_DB_USER;
            }
            if (!$db_pass) {
                $db_pass = F_DB_PASS;
            }
            if (!$db_chr) {
                $db_chr = F_DB_CHR;
            }

            try {
                self::$db[$db_name] = new PDO($db_drv.':host='.$db_host.';dbname='.$db_name, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".$db_chr."'"));
                //array(PDO::ATTR_PERSISTENT => true)
                self::$db[$db_name]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } catch (PDOException $e) {
                header('Content-Type: text/html; charset=windows-1251');
                die("Error: ".$e->getMessage());
            }
        }

        return self::$db[$db_name];
    }
    
    static function quote($field) {
        return self::con()->quote($field);
    }

    //Конвертирование из Unix-даты
    static function fromUnixDate($date, $time = false, $second = false) {
        if ($date == 0) {
            return "";
        }
        if ($time) {
            if ($second) {
                $d = date("d.m.Y H:i:s", $date);
            } else {
                $d = date("d.m.Y H:i", $date);
            }
        } else {
            $d = date("d.m.Y", $date);
        }
        return $d;
    }

    //Конвертирование в Unix-дату	 
    static function toUnixDate($date) {
        $d = strtotime($date);
        return $d;
    }

}

class QueryBuilder {
    
    public $update_string = "";
    public $insert_fields = "";
    public $insert_values = "";
    
    function __construct(array $fields) {
        
        if (!empty($fields)) {
            $ins_fld = [];
            $ins_val = [];
            $upd = [];

            foreach ($fields as $dt_id => $dt) {
                $ins_fld[] = "`".$dt_id."`";
                $ins_val[] = DB::quote($dt);
                $upd[] = "`".$dt_id."`=".DB::quote($dt);
            }
            $this->insert_fields = implode(",", $ins_fld);
            $this->insert_values = implode(",", $ins_val);
            $this->update_string = implode(",", $upd);
        }
        
    }
    
}

class AjaxResponse {

    private $status;
    private $mes;
    private $data;

    function __construct($status, $mes = "", $data = "") {
        $this->status = $status;
        $this->mes = $mes;
        $this->data = $data;
    }

    function json() {
        $result["status"] = $this->status;
        $result["mes"] = $this->mes;
        $result["data"] = $this->data;
        return json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}

class Fianta {

    //Вывод ошибок
    static function err($fname, $pos) {
        return "CMS FIANTA ".FIANTA_VER." ERROR CODE: ".basename(strtoupper($fname))."_".$pos;
    }

    //Логирование ошибок
    static function log($filename, $data) {
        file_put_contents(F_PATH_CORE."logs/".$filename."_".date("Y_m_d_H_i_s").".log", $data);
    }
    
    static function debug($val) {
        if (is_array($val) or is_object($val)) {
            echo '<pre>'; 
                print_r($val); 
            echo '<pre>'; 
            exit();
        } else {
            echo $val; 
            die();	
        }
    }

}

class Validation {

    static function date($date, $format = 'd.m.Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    static function jpg_png($f, $min_size = 10, $max_size = 5000000) {
        
        $allowed_img_types = [
            'image/jpeg' => [
                'min_size' => $min_size,
                'max_size' => $max_size,
                'const_type' => 2,
                'ext' => ['jpg', 'jpe', 'jpeg']
            ],
            'image/png' => [
                'min_size' => $min_size,
                'max_size' => $max_size,
                'const_type' => 3,
                'ext' => ['png']
            ]
        ];
        if (is_uploaded_file($f["tmp_name"])) {
            $ext = pathinfo($f["name"], PATHINFO_EXTENSION);
            $post_file_type = $f["type"];
            $real_file_type = exif_imagetype($f["tmp_name"]);
            $post_file_size = $f["size"];
            $real_file_size = filesize($f["tmp_name"]);

            if (!isset($allowed_img_types[$post_file_type]) or $allowed_img_types[$post_file_type]["const_type"] !== $real_file_type) {
                return "Не загружено. Допустимые форматы изображений JPG или PNG";  
            }  
            if ($post_file_size != $real_file_size or $real_file_size < $allowed_img_types[$post_file_type]["min_size"] or $real_file_size > $allowed_img_types[$post_file_type]["max_size"]) {
                return "Не загружено. Недопустимый размер файла";
            }
            if (!in_array(mb_strtolower($ext), $allowed_img_types[$post_file_type]["ext"])) {
                return "Не загружено. Допустимые расширения файлов: jpg, jpe, jpeg, png";
            }
    
        }
        
    }

}

class Editor {

    //Статус доступности текстом
    static function statusText($status, $text_array) {
        return $text_array[$status];
    }

    //Обрезка текста
    static function cutText($string, $maxlen) {
        $len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen;
        $cutStr = mb_substr($string, 0, $len);
        return (mb_strlen($string) > $maxlen) ? ''.$cutStr.'...' : ''.$cutStr.'';
    }

    //Склонение цифр текстом
    static function numericText($number, array $endingArray) {
        $num = $number % 100;
        if ($num >= 11 && $num <= 19) {
            $ending = $endingArray[2];
        } else {
            $i = $num % 10;
            switch ($i) {
                case (1):
                    $ending = $endingArray[0];
                    break;
                case (2):
                case (3):
                case (4):
                    $ending = $endingArray[1];
                    break;
                default:
                    $ending = $endingArray[2];
            }
        }
        return $ending;
    }

    //Добавить параметр в URL
    static function addToURL($arg, $value, $exclude = []) {

        $get = filter_input_array(INPUT_GET);


        if (isset($get["a"])) {
            $page = urldecode($get["a"]).".html";
            unset($get["a"]);
        } else {
            $page = "";
        }
        $get[$arg] = $value;

        if (!empty($exclude)) {
            foreach ($exclude as $e) {
                if (array_key_exists($e, $get)) {
                    unset($get[$e]);
                }
            }
        }

        return "http://".filter_input(INPUT_SERVER, 'HTTP_HOST')."/".$page."?".http_build_query($get, '', '&amp;');
    }

    //Вывод изображения/заглушки
    static function showImage($image_path, $noimg_path) {
        if (file_exists(F_PATH_WWW.$image_path) and is_file(F_PATH_WWW.$image_path)) {
            return $image_path;
        } else {
            if (file_exists(F_PATH_WWW.$noimg_path) and is_file(F_PATH_WWW.$noimg_path)) {
                return $noimg_path;
            } else {
                return 'Ошибка вывода изображения';
            }
        }
    }
    
    //Текущая ссылка без параметров
    static function linkCurrent() {
        $link = "/";
        if (!empty($GLOBALS["F_URL"])) {
            $link .= implode("/", $GLOBALS["F_URL"]).".html";
        }
        return $link;
    }
    
    //Получение значения по умолчанию с проверкой на isset
    static function getVal(&$var, $default = "") {
        return $var ?? $default;
    }

}

class Select {

    private $name;
    private $values = [];
    private $options_selected = [];
    private $options_disabled = [];
    private $multiple = '';
    private $disabled = '';
    private $class = '';
    private $css = '';
    private $attr = '';

    function __construct($name, array $values = []) {
        $this->name = $name;
        $this->values = $values;
    }

    function setClass($css_class) {
        $this->class = 'class="'.$css_class.'"';
    }
    
    function setAttribute($name, $value) {
        $this->attr = $name.'="'.$value.'"';
    }
    
    function setCSS($raw_css) {
        $this->css = 'style="'.$raw_css.'"';
    }

    function setValue($index, $value) {
        $this->values[] = [$index, $value];
    }

    function setOptionSelected(array $indexes) {
        $this->options_selected = $indexes;
    }

    function setOptionDisabled(array $indexes) {
        $this->options_disabled = $indexes;
    }

    function setDisabled() {
        $this->disabled = 'disabled';
    }

    function setMultiply() {
        $this->multiple = 'multiple';
    }

    function getArrayFromDB($table_name, $field_id, $field_value, $where = "") {
        $wh = "";
        if (!empty($where)) {
            $wh = " WHERE ".$where;
        }
        
        $rs = DB::con()->query("SELECT `".$field_id."`,`".$field_value."` FROM `".F_DB_PREFIX.$table_name."`".$wh) or die(Fianta::err(__FILE__, __LINE__));
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $this->values[] = [$row[$field_id], $row[$field_value]];
        }
    }

    function sortByKey() {
        ksort($this->values);
    }

    function sortByValue() {
        asort($this->values);
    }

    function getHTML() {
        $s = '<select '.$this->attr.' '.$this->class.' '.$this->css.' '.$this->disabled.' '.$this->multiple.' name="'.$this->name.'">';

        foreach ($this->values as $val) {

            $index = $val[0];
            $text = $val[1];
            $selected = "";
            $disabled = "";

            if (!empty($this->options_selected) and in_array($index, $this->options_selected)) {
                $selected = 'selected';
            }

            if (!empty($this->options_disabled) and in_array($index, $this->options_disabled)) {
                $disabled = 'disabled';
            }

            $s .= '<option '.$selected.' '.$disabled.' value="'.$index.'">'.$text.'</option>';
        }
        $s .= '</select>';
        return '<div class="add_select">'.$s.'</div>';
    }

}

//Класс по отправке e-mail писем
class Email {

    protected $html;
    protected $txt;
    protected $subject;
    protected $send_to;

    public function __construct($send_to, $subject, $txt, $template = "email") {
        $this->send_to = $send_to;
        $this->subject = $subject;
        $this->txt = $txt;
        
        //Шаблон письма
        ob_start();
        include(F_PATH_SYS."tpl/inc/".$template.".tpl.php");
        $this->html = ob_get_clean();
    }

    function mailSend() {
        include_once(F_PATH_CORE.'lib/swiftmailer/swift_required.php');
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance(F_SMTP_HOST, F_SMTP_PORT, F_SMTP_SECURE)->setUsername(F_SMTP_USERNAME)->setPassword(F_SMTP_PASS);
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        // Create the message
        $message = Swift_Message::newInstance()
                // Give the message a subject
                ->setSubject($this->subject)
                // Set the From address with an associative array
                ->setFrom([F_SMTP_SENDER_EMAIL => F_SMTP_SENDER_NAME])
                // Set the To addresses with an associative array $login
                ->setTo($this->send_to)
                // Give it a body
                ->setBody($this->html, 'text/html')
        // And optionally an alternative body
        //->addPart('<q>Here is the message itself</q>', 'text/html')
        // Optionally add any attachments
        //->attach(Swift_Attachment::fromPath('my-document.pdf'))
        ;
        // Send the message
        $result = $mailer->send($message);

        return $result;
    }

}

class Nav {
    
    static function pagination($current_page, $list_count, $limit) {
        $nav = [];

        if ($list_count > 0) {
            $page_count = ceil($list_count / $limit);

            if ($current_page < 1) {
                $current_page = 1;
            }
            $first_page = 1;
            $last_page = $page_count; 
            if ($current_page > $last_page) {
                $current_page = $last_page;
            }
            $n = 0;
            if ($current_page - $first_page >= 3) {
                $nav[$n]["num"] = $first_page;  
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }
            if ($current_page - 3 == $first_page + 1) {
                $nav[$n]["num"] = $first_page + 1;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++; 
            } elseif ($current_page - $first_page > 4) {
                $nav[$n]["num"] = "...";
                $nav[$n]["href"] = 'href="#js" onclick="return false"';
                $nav[$n]["class"] = '';  
                $n++; 
            } 
            if ($current_page - 2 >= 1) {
                $nav[$n]["num"] = $current_page - 2;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }
            if ($current_page - 1 >= 1) {
                $nav[$n]["num"] = $current_page - 1;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }

            $nav[$n]["num"] = $current_page;
            $nav[$n]["href"] = 'href="#js" onclick="return false"';
            $nav[$n]["class"] = 'class="active"';  
            $n++;

            if ($current_page + 1 <= $last_page) {
                $nav[$n]["num"] = $current_page + 1;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }
            if ($current_page + 2 <= $last_page) {
                $nav[$n]["num"] = $current_page + 2;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }
            if ($current_page + 3 == $last_page - 1) {
                $nav[$n]["num"] = $last_page - 1;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++; 
            } elseif ($last_page - $current_page >= 4) {
                $nav[$n]["num"] = "...";
                $nav[$n]["href"] = 'href="#js" onclick="return false"';
                $nav[$n]["class"] = '';  
                $n++;
            } 
            if ($last_page - $current_page >= 3) {
                $nav[$n]["num"] = $last_page;
                $nav[$n]["href"] = 'href="'.Editor::addToURL("page",$nav[$n]["num"]).'"';
                $nav[$n]["class"] = '';  
                $n++;
            }
        }

        return $nav;
    }
    
}