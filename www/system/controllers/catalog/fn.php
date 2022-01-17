<?php
function CatalogGetCategories($params, &$smarty){
    $db = Database::getInstance();
    $source = $params['source'] ? $params['source'] : "catalog_categories";
    $sql = "SELECT * FROM `".db_pref."catalog_c` WHERE `PUBLIC` = '1'";
    if (isset($params['no_id'])){
        $sql .= " AND ID NOT IN(".$params['no_id'].")";
    }
    if (isset($params['order'])){
        $sql .= " ORDER BY ".$params['order'];
    }
    $items = $db->select($sql);
    $items =  Func::getInstance()->getStructure($items);
    $smarty->assign($source, $items);
}
Smart::getInstance()->register_function("catalog_categories", "CatalogGetCategories");

?>