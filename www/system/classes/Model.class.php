<?php

class Model {
    public $db;
    public $error;
    public $get;
    public $post;
    public $session;
    public $config;
    public $func;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->session = $_SESSION;
        $this->db = Database::getInstance();
        $this->config = Config::getInstance();
        $this->func = Func::getInstance();
    }
}
?>