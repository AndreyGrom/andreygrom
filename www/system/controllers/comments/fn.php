<?php
function CommentsGetLastPublic($params, $smarty){
    $db = Database::getInstance();
    $source = isset($params['source']) ? $params['source'] : "comments_last";
    $limit = isset($params['limit']) ? $params['limit'] : 5;
    $sort = isset($params['sort']) ? $params['sort'] : "date_publ DESC";
    $sql = "SELECT * FROM ".db_pref."comments WHERE status = 1";
    if (isset($params['no_id'])){
        $sql .= " AND ID NOT IN(".$params['no_id'].")";
    }
    $sql .= " ORDER BY ".$sort . " LIMIT " . $limit;
    $items = $db->select($sql);
    $smarty->assign($source, $items);
}
Smart::getInstance()->register_function("comments_last", "CommentsGetLastPublic");


?>