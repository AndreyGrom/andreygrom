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

if (is_dir(CONTROLLERS_DIR)){
    $list = scandir(CONTROLLERS_DIR);
    foreach ($list as $l){
        $file_func = CONTROLLERS_DIR.$l.'/fn.php';
        if (file_exists($file_func)){
            include_once($file_func);
        }
    }
}


$mng = Manager::getInstance();
$mng->exec();
?>