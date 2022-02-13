<?php
error_reporting(-1);
ini_set("display_errors", 1);
include_once "./AGSpam.class.php";
$com = new AGSpam();
$com->url = 'https://socialnye-apteki.ru/filial/';
$com->url = 'https://socialnye-apteki.ru/system/controllers/mailforms/action.php';
$com->email = 'hkryaker@yandex.ru';
$com->count = 1;
$com->RunMail();
$data_list = $com->data_list;
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
        <td>Линки</td>
        <td>Следующий через</td>
    </tr>
    <tr>
        <td><?php echo $date; ?>(мск)</td>
        <td><a target="_blank" href="./log2.php">Log.txt</a></td>
        <td><span id="second"></span> секунд</td>
    </tr>
</table>
<hr>
<?php foreach ($data_list as $item) {  ?>
    <?php echo $item; ?><br>
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
