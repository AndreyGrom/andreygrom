<?php

class AdminIndexController extends AdminController {
    public function __construct() {
        parent::__construct();

    }


    public function Index(){
        $this->page_title = 'AG CMS';

        $ip = $_SERVER['REMOTE_ADDR'];
        $ip2 = trim(file_get_contents("http://ipinfo.io/ip/"));
        $details = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
        $details2 = json_decode(file_get_contents("http://ipinfo.io/$ip2/json"));

        $this->assign(array(
            'details' => $details,
            'details2' => $details2,
        ));
        $this->content = $this->SetTemplate('index.tpl');
        return $this->content;
    }
}
?>