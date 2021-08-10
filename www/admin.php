<?php
session_start();
date_default_timezone_set( 'Europe/Moscow' );
error_reporting(-1);
ini_set("display_errors", 0);

require_once('config.php');
require_once('system/smarty/SmartyBC.class.php');
spl_autoload_register(function($class) {
    $fn = 'system/classes/' . $class . '.class.php';
    if (file_exists($fn)) require $fn;
});

// ToDo переработать модуль, доработь, вывести информацию об авторстве, версии, и.т.д.
//include_once("system/classes/ModuleInit.class.php");
$mng= new AdminManager();
$mng->getContent();
?>