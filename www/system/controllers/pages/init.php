<?php
class InitModule extends ModuleInit {
    protected static $instance;
    public static function getInstance() {
        return (self::$instance === null) ?
            self::$instance = new self() :
            self::$instance;
    }

    function __construct() {
        parent::__construct();
        $this->name = 'Страницы сайта';
        $this->version = 1.0;
        $this->author = 'Андрей Гром';
        $this->visible = true;
    }

    public function GetConfig(){
        $config = array(
            'alias'  => 'pages',
            'table'  => 'pages',
        );
        return $config;
    }
}
?>