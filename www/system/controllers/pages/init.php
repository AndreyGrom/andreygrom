<?php
class InitPages extends ModuleInit {
    function __construct() {
        parent::__construct();
        $this->name = 'Страницы сайта';
        $this->version = 1.0;
        $this->author = 'Андрей Гром';
        $this->visible = true;
    }
}
?>