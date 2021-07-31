<?php

if (isset($_COOKIE['hash']) && isset($_COOKIE['user_id']) && $_COOKIE['hash']!=='' && $_COOKIE['user_id']!==''){
    $user_id = $_COOKIE['user_id'];
    $user_hash = $_COOKIE['hash'];
    $db = Database::getInstance();
    $sql = "SELECT * FROM `".db_pref."users` WHERE `ID` = '$user_id' AND `HASH` = '$user_hash' LIMIT 1";
    $query = $db->query($sql);
    if ($db->num_rows($query) > 0){
        $_SESSION['user'] = $db->fetch_array($query);
        $id = $_SESSION['user']['ID'];
        $date = time();
        $sql = "UPDATE `".db_pref."users` SET `DATE_ACTIVE` = '$date' WHERE `ID`='$id'";
        $query = $db->query($sql);
    } else {
        setcookie('hash','',time()+3600*24*30*6,'/');
        setcookie('user_id','',time()+3600*24*30*6,'/');
    }
}
?>