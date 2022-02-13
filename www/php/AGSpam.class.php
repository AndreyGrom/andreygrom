<?php

class AGSpam{
    public $count; // Количество постов за раз
    //public $message; // Сообщение
    public $email; // Email
    public $url; // URL страницуе без последнего номера
    public $url_list;
    public $current_number;
    public $proxy = false;
    public function __construct() {

    }
    // Случайное имя из файла
    function RndName(){
        $txt = file( './male_names_rus.txt');
        $str = $txt[ array_rand($txt) ];
        unset($txt);
        return trim($str);
    }
    function RndMessage(){
        $txt = file( './messages.txt');
        $str = $txt[ array_rand($txt) ];
        unset($txt);
        return trim($str);
    }
    // Последний URL после редиректа
    function GetLastUrl($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->proxy !== false){
            //Указываем к какому прокси подключаемся и передаем логин-пароль
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy );
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
            //доступные значения для типа используемого прокси-сервера:  CURLPROXY_HTTP (по умолчанию), CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME.
            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            var_dump($this->proxy);
        }
        curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $redirectURL = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        curl_close($ch);
        var_dump($redirectURL);
        return $redirectURL;
    }
    function Post($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        if ($this->proxy !== false){
            //Указываем к какому прокси подключаемся и передаем логин-пароль
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy );
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
            //доступные значения для типа используемого прокси-сервера:  CURLPROXY_HTTP (по умолчанию), CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME.
            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }
    function GetNumber(){
        $filenumber = './number.txt';
        $number = file_get_contents($filenumber);
        file_put_contents($filenumber, ++$number);
        return $number;
    }
    function LogUrl($url){
        file_put_contents('./log.txt', $url . "\n", FILE_APPEND);
    }
    function Comment(){
        $this->current_number = $this->GetNumber();
        $url = $this->url . $this->current_number;
        $url = $this->GetLastUrl($url);
        $name =  $this->RndName();
        $email = $this->email;
        $comment = $this->RndMessage();
        $data = "name=$name&email=$email&comment=$comment&comment-parent=0&username=&useremail=";
        $rs = $this->Post($url, $data);
        $this->LogUrl($url);
        return $url;
    }
    public function RunComment(){
        for ($i = 0; $i < $this->count; $i++){
            $url =  $this->Comment();
            $this->url_list[] = $url;
        }
    }
    function Mail(){
        $url = $this->url;
        $name =  $this->RndName();
        $email = $this->email;
        $message = "Достал спам? Я могу помочь!";
        $data = array(
            'form_id=7',
            'f1=' . $name,
            'f4=' . $email,
            'f6=' . $message,
            'f7=Скорая помощь вашему проекту! Почти даром!!!',
        );
        $data = implode('&', $data);
        $rs = $this->Post($url, $data);
    }
    public function RunMail($data){
        for ($i = 0; $i < $this->count; $i++){
            $this->Mail();
        }
    }
}




?>