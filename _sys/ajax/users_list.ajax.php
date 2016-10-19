<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php')); 

if (F_LOGGED and User::info("role_id") == 1) {

    $extraWhere = '';
    $type = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT, ["options" => ["default" => 0]]);
    if (!empty($type)) {
        $extraWhere = "u.`role_id` = '".$type."'";
    }

    $table = F_DB_PREFIX."users";
    $joinQuery = "FROM `".F_DB_PREFIX."users` u JOIN `".F_DB_PREFIX."users_roles` ur ON u.`role_id` = ur.`id`";

    $primaryKey = 'u.`id`';
    $columns = [
        ['db' => 'u.`id`', 'dt' => 0, 'field' => 'id'],
        ['db' => 'u.`name`', 'dt' => 1, 'field' => 'name'],
        ['db' => 'ur.`name`', 'dt' => 2, 'field' => 'role_name', 'as' => 'role_name'],
        ['db' => 'u.`login`', 'dt' => 3, 'field' => 'login'],
        ['db' => 'u.`regdate`', 'dt' => 4, 'field' => 'regdate', 'formatter' => function($d) {return DB::fromUnixDate($d);}],
    ];
    require(F_PATH_CORE.'lib/datatable/dt2.lib.php');
    echo json_encode(SSP::simple($_POST, $table, $primaryKey, $columns, $joinQuery, $extraWhere), JSON_UNESCAPED_UNICODE);

}