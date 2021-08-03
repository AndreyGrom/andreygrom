<?php

class AdminIndexController extends AdminController {
    public function __construct() {
        parent::__construct();

    }


    public function Index(){
        $this->page_title = 'AG CMS';

        $this->content = $this->SetTemplate('index.tpl');
        return $this->content;
    }
}
?>