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
        //$this->config = new stdClass();
        $this->get();
    }
    public function get(){
        $query = 'SELECT * FROM '.db_pref.'config';
        $result = $this->db->select($query);
        foreach ($result as $row){
            if (isset($row['PARAM'])){
                $param = $row['PARAM'];
                $this->$param = $row['VALUE'];
            }

        }
        return $this;
    }

    function set($param, $value){
        if (property_exists($this, $param)){
            $this->db->query("UPDATE `".db_pref."config` SET `VALUE`='$value' WHERE `PARAM`='$param'");
        } else{
            $this->db->query("INSERT INTO `".db_pref."config`(`PARAM`,`VALUE`) VALUE ('$param','$value')");
        }
    }

    function del($param){
        $this->db->query("DELETE FROM `".db_pref."config` WHERE `PARAM`=$param");
    }
} 