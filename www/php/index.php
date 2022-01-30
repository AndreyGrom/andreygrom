<?php
error_reporting(-1);
ini_set("display_errors", 1);
function RndName(){
    $txt = file(__DIR__ . '/male_names_rus.txt');
    $str = $txt[ array_rand($txt) ];
    unset($txt);
    return trim($str);
}
function Post($url, $data){
    $proxy_ip = '';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    //Указываем к какому прокси подключаемся и передаем логин-пароль
    //curl_setopt($ch, CURLOPT_PROXY, $proxy_ip );
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);

    //доступные значения для типа используемого прокси-сервера:  CURLPROXY_HTTP (по умолчанию), CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME.
    //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    $result=curl_exec ($ch);
    //var_dump($result);
    curl_close ($ch);
    return $result;
}
$url = "http://provoda/blog/vtoroe-i-trete-znakomstvo-s-living-athmos";
var_dump(RndName());
$name =  RndName();
$email = '';
$comment = '';

$data = "name=$name&email=$email&comment=$comment&comment-parent=0";
/*Post($url, $data);*/

?>