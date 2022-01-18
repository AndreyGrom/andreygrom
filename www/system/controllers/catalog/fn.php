<?php
function CatalogGetCategories($params, &$smarty){
    $db = Database::getInstance();
    $source = $params['source'] ? $params['source'] : "catalog_categories";
    $sql = "SELECT * FROM `".db_pref."catalog_c` WHERE public = 1";
    if (isset($params['no_id'])){
        $sql .= " AND ID NOT IN(".$params['no_id'].")";
    }
    if (isset($params['order'])){
        $sql .= " ORDER BY ".$params['order'];
    }
    $limit = $params['limit'] ? $params['limit'] : 20;
    $items = $db->select($sql);
    $items =  Func::getInstance()->getStructure($items);
    $smarty->assign($source, $items);
}
function CatalogGetLastPublic($params, &$smarty){
    $db = Database::getInstance();
    $source = $params['source'] ? $params['source'] : "catalog_last";
    $limit = $params['limit'] ? $params['limit'] : 5;
    $sort = $params['sort'] ? $params['sort'] : "date_publ DESC";
    $sql = "SELECT * FROM ".db_pref."catalog_i WHERE public = 1";
    if (isset($params['no_id'])){
        $sql .= " AND ID NOT IN(".$params['no_id'].")";
    }
    $sql .= " ORDER BY ".$sort . " LIMIT " . $limit;
    $items = $db->select($sql);
    $smarty->assign($source, $items);
}
Smart::getInstance()->register_function("catalog_categories", "CatalogGetCategories");
Smart::getInstance()->register_function("catalog_last", "CatalogGetLastPublic");

?>