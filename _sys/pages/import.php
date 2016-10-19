<?php defined('FIANTA_ACC') or die(include_once(F_PATH_SYS.'pages/404.php'));

if (file_exists(F_PATH_WWW."xml/lamoda.xml")) {

    $data = simplexml_load_file("xml/lamoda.xml");

    //$products = $data->shop->offers->offer;

    $cat = $data->shop->categories->category;

    foreach ($cat as $c) {
        $id = (int)$c->attributes()->id;
        $val = (string)$c;
        $parent = (int)$c->attributes()->parentId ?? 0;
        $tree_node[$id] = ["id" => $id, "name" => $val];
        //$tree_node[$id] = $val;

        if ($parent) {
            $tree_node[$parent]['childs'][] = &$tree_node[$id];
        } else {
            $tree[] = &$tree_node[$id];
        }
    }

    function xTree($tr) {
        $result = '<ul>';
        foreach ($tr as $t) {
            $result .= '<li>'.$t["name"]." [ID:".$t["id"]."]</li>";
            if (isset($t["childs"])) {
                $result .= xTree($t["childs"]);
            }
        }
        $result .= '</ul>';
        return $result;
    }
    $result = xTree($tree);

    echo $result;

} else {

    echo "XML NOT FOUND!";

}
