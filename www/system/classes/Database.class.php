<?php

class Database {
    public $host;
    public $user;
    public $password;
    public $name;
    public $mysqli;
    public $query_count;
    public $query_list;

    protected static $instance;
    public static function getInstance() {
        return (self::$instance === null) ?
            self::$instance = new self() :
            self::$instance;
    }
    public function __construct() {
        $this->host = db_host;
        $this->user = db_user;
        $this->password = db_password;
        $this->name = db_name;
        $this->mysqli = null;
        $this->query_count = 0;
        $this->query_list = array();
        $this->connect();
    }
    public function connect(){
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->name);
        if ($this->mysqli->connect_error) {
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset("utf8");
	}
    public function query($sql){
        $result = $this->mysqli->query($sql);
        $this->query_count ++;
        $this->query_list[] = $sql;
        return $result;
	}
    public function num_rows($result){
        $return = 0;
        if ($result){
            $return = $result->num_rows;;
        }
        return $return;
	}
    public function fetch_array($result){
        if ($result){
            return $result->fetch_array(MYSQLI_ASSOC);
        } else {
            return false;
        }

	}
    public function fetch_all($result){
        $return = array();
        if ($result){
            for ($i=0;$i<$this->num_rows($result);$i++){
                $return[] = $this->fetch_array($result);
            }
            //$return = $result->fetch_all(MYSQLI_ASSOC);
        }
        return $return;
    }
    public function input($text){
        $text = stripcslashes($text);
        if (!get_magic_quotes_gpc()){
            return $this->mysqli->real_escape_string(trim($text));
        } else {
            return trim($text);
        }
	}
    public function last_id(){
        return $this->mysqli->insert_id;
    }
    public function error(){
        return $this->mysqli->error;
    }
    public function GetQueryList(){
        $result = '';
        if (count($this->query_list)>0){
            foreach($this->query_list as $v){
                $result.=$v."\r\n";
            }
        }
        return $result;
    }

    public function select($sql, $params = array()){
        $array = array();
        $rs = $this->query($sql);
        while($row = $this->fetch_array($rs)){
            $array[] = $row;
        }
        return $array;
    }

    public function insert($table, $params, $duplicate = false){
        $fields = array();
        $values = array();
        foreach ($params as $k=>$a){
            $fields[] = '`'.$k.'`';
            $values[] = "'".$this->input($a)."'";
        }
        $sql = "INSERT INTO $table (".implode(',',$fields).") VALUES (".implode(',',$values).")";
        if ($duplicate){
            $fields = array();
            foreach ($params as $k=>$a){
                $fields[] = "`".$k."`" . "='".$a."'";
            }
            $sql .= " ON DUPLICATE KEY UPDATE " .implode(',',$fields);
        }

        return $this->query($sql);
    }

    public function update($table, $params, $where){
        $fields = array();
        foreach ($params as $k=>$a){
            $fields[] = "`".$k."`" . "='".$this->input($a)."'";
        }
        $sql = "UPDATE $table SET ".implode(',',$fields)." WHERE $where";
        return $this->query($sql);
    }

    public function delete($table, $where){
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql);
    }

    public function count_row($table, $where=''){
        $sql = "SELECT COUNT(*) AS cnt FROM $table";
        if ($where !== ''){
            $sql .= " WHERE $where";
        }
        $query = $this->query($sql);
        $row = $this->fetch_array($query);
        return $row['cnt'];
    }
}
?>