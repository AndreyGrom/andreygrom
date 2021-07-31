<?php
session_start();
date_default_timezone_set( 'Europe/Moscow' );
error_reporting(-1);
ini_set("display_errors", 1);

require_once('system/config/config.php');
require_once('system/smarty/SmartyBC.class.php');
require_once('system/classes/DB.class.php');
require_once('system/classes/Config.class.php');
require_once('system/classes/Func.class.php');
require_once('system/classes/AdminController.php');
require_once('system/classes/Smart.class.php');
include_once("system/classes/AdminManager.class.php");
include_once("system/classes/Model.class.php");
// ToDo переработать модуль, доработь, вывести информацию об авторстве, версии, и.т.д.
include_once("system/classes/ModuleInit.class.php");
$mng= new AdminManager();

$mng->getContent();
?>