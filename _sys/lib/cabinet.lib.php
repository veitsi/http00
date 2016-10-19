<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));
/*************************************************************************************************************
CMS FIANTA v6.1 [06/16] FEDOR YASTREBOV - COPYRIGHT © 2013-2016 WEB: http://fianta.com EMAIL: adm@fianta.com
*************************************************************************************************************/

//Получение конкретной записи
abstract class GetRecord {

    protected $id;
    private $query;

    function __construct($id) {
        $this->id = $id;
        $this->query = $this->setQuery();
    }

    function getData() {
        $data = [];
        if (F_LOGGED) {
            $rs = DB::con()->query($this->query) or die(Fianta::err(__FILE__, __LINE__));
            $data = $rs->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    abstract public function setQuery();
}

//Получение списка данных
abstract class GetList {

    public $count;
    private $page;
    protected $limit;
    protected $limit_from;
    private $query_count;
    private $query;
    protected $where;

    function __construct($page, $limit, $where = "") {
        $this->page = $page;
        $this->limit = $limit;
        $this->where = $where;
        $this->query_count = $this->setQueryCount();

        $nr = DB::con()->query($this->query_count) or die(Fianta::err(__FILE__, __LINE__));
        $this->count = $nr->fetchColumn();
    }

    function getList() {
        $list = [];
        if (F_LOGGED and $this->page <= ceil($this->count / $this->limit)) {

            if ($this->page < 1) {
                $this->page = 1;
            }
            $this->limit_from = $this->page * $this->limit - ($this->limit);
            $this->query = $this->setQuery();
            $rs = DB::con()->query($this->query) or die(Fianta::err(__FILE__, __LINE__));
            $list = $rs->fetchAll(PDO::FETCH_ASSOC);
        }
        return $list;
    }

    abstract public function setQueryCount();

    abstract public function setQuery();
}



//Пользователь
class GetUser extends GetRecord {
    function setQuery() {
        $query = "SELECT u.`id`, u.`name`, u.`regdate`, u.`birthdate`, u.`login`, u.`city`, u.`about`, u.`comment`, u.`gender`, "
                . "u.`role_id`, u.`bodytype_id`, bt.`name` as `bodytype` FROM `".F_DB_PREFIX."users` u "
            ."LEFT JOIN `".F_DB_PREFIX."users_bodytypes` bt ON u.`bodytype_id`= bt.`id` "
            ."WHERE u.`id`=".DB::quote($this->id);
        return $query;
    }
}

//Категория лука
class GetLooksCategory extends GetRecord {
    function setQuery() {
        $query = "SELECT `id`,`name`,`parent_id`,`enabled` FROM `".F_DB_PREFIX."looks_categories` WHERE `id`=".DB::quote($this->id);
        return $query;
    }
}

//Категория лука
class GetProductsCategory extends GetRecord {
    function setQuery() {
        $query = "SELECT `id`,`name`,`parent_id`,`enabled` FROM `".F_DB_PREFIX."products_categories` WHERE `id`=".DB::quote($this->id);
        return $query;
    }
}

//Подписки
class Subscriptions {
    
    //Список подписок по юзеру
    static function getList($user_id) {    
        $rs = DB::con()->query("SELECT s.`id`, s.`name`, CASE WHEN us.`subscription_id` IS NOT NULL THEN 1 ELSE 0 END AS `subscribed` FROM `".F_DB_PREFIX."subscriptions` s "
        ."LEFT JOIN `".F_DB_PREFIX."users_subscriptions` us ON us.`subscription_id`= s.`id` AND us.`user_id`=".DB::quote($user_id)) or die(Fianta::err(__FILE__, __LINE__));
        $s = $rs->fetchAll(PDO::FETCH_ASSOC);
        return $s;
    }
    
}




class Cabinet {

    //Полный список категорий луков
    static function LooksCategories() {
        $rs = DB::con()->query("SELECT `id`,`name`,`parent_id`  FROM `".F_DB_PREFIX."looks_categories`") or die(Fianta::err(__FILE__, __LINE__));
        $cat = $rs->fetchAll(PDO::FETCH_ASSOC);

        $tree = [];
        foreach ($cat as $c) {
            $tree_node[$c["id"]] = ["id" => $c["id"], "text" => $c["name"]];
            if (!empty($c["parent_id"])) {
                $tree_node[$c["parent_id"]]['children'][] = &$tree_node[$c["id"]];
            } else {
                $tree[] = &$tree_node[$c["id"]];
            }
        }
        return $tree;
    }

    //Полный список категорий товаров
    static function ProductsCategories() {
        $rs = DB::con()->query("SELECT `id`,`name`,`parent_id`  FROM `".F_DB_PREFIX."products_categories`") or die(Fianta::err(__FILE__, __LINE__));
        $cat = $rs->fetchAll(PDO::FETCH_ASSOC);

        $tree = [];
        foreach ($cat as $c) {
            $tree_node[$c["id"]] = ["id" => $c["id"], "text" => $c["name"]];
            if (!empty($c["parent_id"])) {
                $tree_node[$c["parent_id"]]['children'][] = &$tree_node[$c["id"]];
            } else {
                $tree[] = &$tree_node[$c["id"]];
            }
        }
        return $tree;
    }
    
}




