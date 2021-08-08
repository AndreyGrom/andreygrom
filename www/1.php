<?php

$ip = $_SERVER['REMOTE_ADDR'];
$ip2 = trim(file_get_contents("http://ipinfo.io/ip/"));
$details = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
$details2 = json_decode(file_get_contents("http://ipinfo.io/$ip2/json"));
?>
<div class="row">
    <div class="col-md-6">
        <table class="table table-hover table-bordered">
            <caption>Информация о сервере</caption>
            <tr>
                <td>IP:</td>
                <td><?php echo $details->ip; ?></td>
            </tr>
            <tr>
                <td>Имя хоста:</td>
                <td><?php echo $details->hostname; ?></td>
            </tr>
            <tr>
                <td>Город:</td>
                <td><?php echo $details->city; ?></td>
            </tr>
            <tr>
                <td>Регион:</td>
                <td><?php echo $details->region; ?></td>
            </tr>
            <tr>
                <td>Страна:</td>
                <td><?php echo $details->country; ?></td>
            </tr>
            <tr>
                <td>Организация:</td>
                <td><?php echo $details->org; ?></td>
            </tr>
            <tr>
                <td>Часовой пояс:</td>
                <td><?php echo $details->timezone; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-hover table-bordered">
            <caption>Информация о вас</caption>
            <tr>
                <td>IP:</td>
                <td><?php echo $details->ip; ?></td>
            </tr>
            <tr>
                <td>Имя хоста:</td>
                <td><?php echo $details->hostname; ?></td>
            </tr>
            <tr>
                <td>Город:</td>
                <td><?php echo $details->city; ?></td>
            </tr>
            <tr>
                <td>Регион:</td>
                <td><?php echo $details->region; ?></td>
            </tr>
            <tr>
                <td>Страна:</td>
                <td><?php echo $details->country; ?></td>
            </tr>
            <tr>
                <td>Организация:</td>
                <td><?php echo $details->org; ?></td>
            </tr>
            <tr>
                <td>Часовой пояс:</td>
                <td><?php echo $details->timezone; ?></td>
            </tr>
        </table>
    </div>
</div>
