<?php
if (isset($_GET['action']) && $_GET['action'] == 'clear'){
    unlink('./log.txt');
    Header("Location: ./log.php");
}
$file = file('log.txt');
$items = array();
foreach ($file as $item) {
    if ($item == '..' || $item == '.') continue;
    $items[] = $item;
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Лог-файл</title>
</head>
<body>
<p><strong>Всего записей: <?php echo count($items); ?> <a href="?action=clear">Очистить</a></strong></p>
<?php foreach ($items as $i) { ?>
    <?php echo $i; ?><br>
<?php } ?>
</body>
</html>
