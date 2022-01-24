<?php
error_reporting(-1);
ini_set("display_errors", 0);
include_once('system/classes/Analysis.class.php');
$info = new Analysis();
$info->url = 'http://andreygrom3/';
$rs = $info->Run();
var_dump($rs);
?>