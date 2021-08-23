<?php
return array(
    'alias'  => 'pages',
    'table'  => 'pages',
    'name'  => 'Страницы сайта',
    'title'  => 'Страницы сайта',
    'version'  => 4.0,
    'author'  => 'Андрей Гром',
    'email'  => 'grominfo@gmail.com',
    'visible'  => true,

);
/*
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
            'name'  => $this->name,
            'version'  => $this->version,
            'author'  => $this->author,
            'visible'  => $this->visible,
        );
        return $config;
    }
}*/
?>