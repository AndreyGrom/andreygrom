<?php
session_start();
date_default_timezone_set( 'Europe/Moscow' );
error_reporting(-1);
ini_set("display_errors", 1);

require_once('config.php');
require_once('system/smarty/SmartyBC.class.php');
spl_autoload_register(function($class) {
    $fn = 'system/classes/' . $class . '.class.php';
    if (file_exists($fn)) require $fn;
});
$mng= new AdminManager();
$mng->getContent();
?>