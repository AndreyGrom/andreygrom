<?php
error_reporting(-1);
ini_set("display_errors", 1);
include_once "./AGSpam.class.php";
$com = new AGSpam();
$com->email = 'hkryaker@yandex.ru';
$com->url = 'https://socialnye-apteki.ru/filial/';
$com->count = 10;
$com->RunComment();
$url_list = $com->url_list;
$current_number = $com->current_number;
$date = date("d.m.Y G:i:s", time());
$date = date("G:i:s", time());
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table td{
            border: 1px solid grey;
            padding: 3px;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td>Дата и время</td>
        <td>Всего постов</td>
        <td>Линки</td>
        <td>Следующий через</td>
    </tr>
    <tr>
        <td><?php echo $date; ?>(мск)</td>
        <td><?php echo $current_number; ?></td>
        <td><a target="_blank" href="./log.php">Log.txt</a></td>
        <td><span id="second"></span> секунд</td>
    </tr>
</table>
<hr>
<?php foreach ($url_list as $item) {  ?>
    <a target="_blank" href="<?php echo $item; ?>"><?php echo $item; ?></a><br>
<?php } ?>
<!--<script>
    setTimeout(function(){
        location.reload();
    }, 120000);
</script>-->

<script>
    (function() {
        var delay = 30, current = 0, timerId;
        function DisplayTimer() {
            current ++;
            if (current >= delay){
                clearInterval(timerId);
                location.reload();
            }
            document.getElementById("second").innerHTML = delay - current;
        }
        timerId = setInterval(function(){
            DisplayTimer();
        }, 1000);
    })();

</script>
</body>
</html>
