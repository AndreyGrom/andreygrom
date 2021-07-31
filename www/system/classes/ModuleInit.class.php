<?php

class ModuleInit {
    public  $db;
    public  $name;
    public  $version;
    public  $author;
    public  $visible;
    public  $type;
    public  $icon;
    public  $description;
    public  $url;

    function __construct() {
        $this->db = Database::getInstance();
    }

    public function version(){
        return isset($this->version) ? $this->version : '';
    }

    public function index(){

    }
}
?>