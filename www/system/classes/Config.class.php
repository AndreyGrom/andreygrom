<?php

class Config {
    protected static $instance;
    public static function getInstance() {
        return (self::$instance === null) ?
            self::$instance = new self() :
            self::$instance;
    }
    public function __construct() {
        $this->db = Database::getInstance();
        $this->get();
    }
    public function get(){
        $query = 'SELECT * FROM '.db_pref.'config';
        $result = $this->db->select($query);
        foreach ($result as $row){
            if (isset($row['param'])){
                $param = $row['param'];
                $this->$param = $row['value'];
            }

        }
        return $this;
    }
    function set($param, $value, $desc = ""){
        if (property_exists($this, $param)){
            $this->db->query("UPDATE `".db_pref."config` SET `value`='$value', `desc` = '$desc' WHERE `param`='$param'");
        } else{
            $this->db->query("INSERT INTO `".db_pref."config`(`param`,`value`, `desc`) VALUE ('$param','$value', '$desc')");
        }
    }
    function del($param){
        $this->db->query("DELETE FROM `".db_pref."config` WHERE `param` = '$param'");
    }
} 