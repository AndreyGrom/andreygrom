<?php
error_reporting(-1);
ini_set("display_errors", 0);
include_once('system/classes/Analysis.class.php');
$info = new Analysis();
$info->url = 'http://megacity.mobi/';
//$info->url = 'http://andreygrom.ru/';
$rs = $info->Run();
var_dump($rs);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div style="white-space: pre">
    <?php echo $rs->headers; ?>
</div>
</body>
</html>
