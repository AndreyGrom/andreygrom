<?php
define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
define('SYSTEM_DIR', ROOT_PATH.'system/');
define('PLUGINS_DIR', SYSTEM_DIR.'plugins/');
define('CLASSES_DIR', SYSTEM_DIR.'classes/');
define('MODELS_DIR', SYSTEM_DIR.'models/');
define('TEMPLATES_DIR', ROOT_PATH.'themes/');
define('CONTROLLERS_DIR', SYSTEM_DIR.'controllers/');
define('UPLOAD_DIR', ROOT_PATH.'upload/');
define('UPLOAD_IMAGES_DIR', UPLOAD_DIR.'images/');
define('UPLOAD_FILES_DIR', UPLOAD_DIR.'files/');
define('CACHE_DIR', ROOT_PATH.'cache/');
define('CACHE_IMAGES', CACHE_DIR.'images/');

define('HTML_CONTROLLERS_DIR', '/system/controllers/');
define('HTML_PLUGINS_DIR', '/system/plugins/');
define('HTML_CLASSES_DIR', '/system/classes/');
define('HTML_THEMES_DIR', '/themes/');
define('HTML_UPLOAD_DIR', '/upload/');
define('HTML_UPLOAD_IMAGES_DIR', HTML_UPLOAD_DIR.'images/');
define('HTML_CACHE_DIR', '/cache/');
define('HTML_CACHE_IMAGES', HTML_CACHE_DIR.'images/');
?>