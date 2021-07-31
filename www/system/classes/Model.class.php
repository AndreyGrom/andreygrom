<?php

class Model {
    public $db;
    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->db = Database::getInstance();
        $this->config = Config::getInstance();
        $this->func = Func::getInstance();
    }
}
?>