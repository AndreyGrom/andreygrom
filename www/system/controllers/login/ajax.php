<?php
session_start();
require_once(CLASSES_DIR.'classes/DB.class.php');
if (isset($_POST['email'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $db = Database::getInstance();
    $sql = "SELECT * FROM `".db_pref."users` WHERE `EMAIL`='$email' AND `PASSWORD`='$password' LIMIT 1";
    $query = $db->query($sql);
    $result = '';
    if ($db->num_rows($query) > 0){
        $row = $db->fetch_array($query);
        setcookie('hash',$row['HASH'],time()+3600*24*30*6,'/');
        setcookie('user_id',$row['ID'],time()+3600*24*30*6,'/');
        $result = '1';
    } else{
        $result = '0';
    }
    echo $result;
}

?>