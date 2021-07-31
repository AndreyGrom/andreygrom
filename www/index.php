<?php
session_start();
error_reporting(-1);
ini_set("display_errors", 1);
require_once('system/config/config.php');
include_once("system/classes/Manager.class.php");
require_once('system/classes/Controller.class.php');

$mng = Manager::getInstance();
$mng->exec();
?>