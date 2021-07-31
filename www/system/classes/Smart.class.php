<?php
class Smart extends SmartyBC{
    protected static $instance;
    public static function getInstance() {
        return (self::$instance === null) ?
            self::$instance = new self() :
            self::$instance;
    }
    public function __construct() {
        parent::__construct();
        $this->compile_dir = CACHE_DIR.'compile/';
        $this->config_dir = SYSTEM_DIR.'config/';
        $this->cache_dir = CACHE_DIR;
    }
}