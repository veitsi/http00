<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

//Ошибка при многомерной ссылке
if (isset($F_URL) and count($F_URL) > 3) die(include_once(F_PATH_SYS.'pages/404.php'));

//Библиотеки
include_once(F_PATH_SYS.'lib/header.lib.php');
include_once(F_PATH_SYS.'lib/footer.lib.php');

include_once(F_PATH_SYS.'lib/cabinet.lib.php');

//Заполняем переменные шаблона
$F_PAGE_GEN['title'] = "Кабинет";
$F_PAGE_GEN['robots'] = 'none';

if (F_LOGGED) {
    switch(User::info("role_id")) {
        case 1:
            //Администратор
            $role_template = "admin";

            if (isset($F_URL[2]) and isset($F_URL[1])) {
                switch($F_URL[1]) {
                    case "users":
                        $id = filter_var($F_URL[2], FILTER_VALIDATE_INT,  ["options" => ["min_range" => 1]]);
                        if (!empty($id)) {
                            $user = new GetUser($id);
                            $data = $user->getData();

                            if (!empty($data)) {
                                $select_roles = new Select("role_id");
                                $select_roles->setClass("b-select b-select_ad");
                                $select_roles->setAttribute("id", "select_role");
                                $select_roles->getArrayFromDB("users_roles","id","name");
                                $select_roles->setOptionSelected([$data["role_id"]]);
                                $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/user_edit.tpl.php";
                            } else {
                                die(include_once(F_PATH_SYS.'pages/404.php'));
                            }
                        } else {
                            die(include_once(F_PATH_SYS.'pages/404.php'));
                        }
                        break;
                    case "look_cat":
                        $id = filter_var($F_URL[2], FILTER_VALIDATE_INT,  ["options" => ["min_range" => 1]]);
                        if (!empty($id)) {
                            $category = new GetLooksCategory($id);
                            $data = $category->getData();
                            if (!empty($data)) {
                                if (isset($_SESSION["o_result"])) {
                                    $o_result = $_SESSION["o_result"];
                                    unset($_SESSION["o_result"]);
                                }
                                $select_parent_category = new Select("parent_id");
                                $select_parent_category->setValue("0", "Нет родительской категории");
                                $select_parent_category->getArrayFromDB("looks_categories","id","name","`parent_id`='0'");
                                $select_parent_category->setOptionSelected([$data["parent_id"]]);
                                $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/looks_category_edit.tpl.php";
                            } else {
                                die(include_once(F_PATH_SYS.'pages/404.php'));
                            }
                        } else {
                            die(include_once(F_PATH_SYS.'pages/404.php'));
                        }
                        break;
                    case "prod_cat":
                        $id = filter_var($F_URL[2], FILTER_VALIDATE_INT,  ["options" => ["min_range" => 1]]);
                        if (!empty($id)) {
                            $category = new GetProductsCategory($id);
                            $data = $category->getData();
                            if (!empty($data)) {
                                if (isset($_SESSION["o_result"])) {
                                    $o_result = $_SESSION["o_result"];
                                    unset($_SESSION["o_result"]);
                                }
                                $select_parent_category = new Select("parent_id");
                                $select_parent_category->setValue("0", "Нет родительской категории");
                                $select_parent_category->getArrayFromDB("products_categories","id","name","`parent_id`='0'");
                                $select_parent_category->setOptionSelected([$data["parent_id"]]);
                                $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/products_category_edit.tpl.php";
                            } else {
                                die(include_once(F_PATH_SYS.'pages/404.php'));
                            }
                        } else {
                            die(include_once(F_PATH_SYS.'pages/404.php'));
                        }
                        break;
                    default:
                        die(include_once(F_PATH_SYS.'pages/404.php'));
                }
            } elseif(isset($F_URL[1])) {
                switch($F_URL[1]) {
                    case "users":
                        $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/users_list.tpl.php";
                        break;
                    case "look_cat":
                        $do = filter_input(INPUT_GET, 'do');
                        if (!empty($do)) {
                            switch ($do) {
                                case "new":
                                    $select_parent_category = new Select("parent_id");
                                    $select_parent_category->setValue("0", "Нет родительской категории");
                                    $select_parent_category->getArrayFromDB("looks_categories","id","name","`parent_id`='0'");
                                    $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/looks_category_edit.tpl.php";
                                    break;
                                default:
                                    die(include_once(F_PATH_SYS.'pages/404.php'));
                            }
                        } else {
                            $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/looks_categories_list.tpl.php";
                        }
                        break;
                    case "prod_cat":
                        $do = filter_input(INPUT_GET, 'do');
                        if (!empty($do)) {
                            switch ($do) {
                                case "new":
                                    $select_parent_category = new Select("parent_id");
                                    $select_parent_category->setValue("0", "Нет родительской категории");
                                    $select_parent_category->getArrayFromDB("products_categories","id","name","`parent_id`='0'");
                                    $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/products_category_edit.tpl.php";
                                    //TEST
                                    break;
                                default:
                                    die(include_once(F_PATH_SYS.'pages/404.php'));
                            }
                        } else {
                            $template_path = F_PATH_SYS."tpl/cabinet/".$role_template."/products_categories_list.tpl.php";
                        }
                        break;
                    default:
                        die(include_once(F_PATH_SYS.'pages/404.php'));
                }
            } else {
                include_once(F_PATH_SYS."pages/inc/profile.php");
            }
            
        case 3:
            //Пользователь
            $role_template = "user";
            
            if(isset($F_URL[1])) {
                
            } else {          
                include_once(F_PATH_SYS."pages/inc/profile.php");
            }
            
            break;
        default:
            die(include_once(F_PATH_SYS.'pages/404.php'));
    }
    //Подключаем шаблон
    include_once(F_PATH_SYS."tpl/cabinet.tpl.php");
} else {
    //Подключаем шаблон
    include_once(F_PATH_SYS."tpl/auth/no_access.tpl.php");
}