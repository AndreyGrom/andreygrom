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
        include_once(dirname( __FILE__  ).'/../config/db.php');
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
    public function ImportSQLFile($file){;
        $open_file = fopen ($file, 'r');
        $buf = fread($open_file, filesize($file));
        fclose ($open_file);
        $a = 0;
        $i=0;
        while ($b = strpos($buf,';',$a+1)){
            $i++;
            $a = substr($buf,$a+1,$b-$a);
            $this->query($a);
            $a = $b;
        }
        return $i;
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

    public function CreateTable($params){
        $sql = "CREATE TABLE IF NOT EXISTS ".$params['name']. '('."\r\n";
        foreach ($params['fields'] as $f){
            $sql .= $f . ','."\r\n";
        }
        if (isset($params['primary_key'])){
            $sql .= "PRIMARY KEY  (".$params['primary_key'].")"."\r\n";
        }
        $sql .= ")";
        $this->query($sql);
    }

    public function CreateTables($list){
        foreach ($list as $l){
            $this->CreateTable($l);
        }
    }
    function GetCache($sql, $params = array()){
        $result = false;
        $total_rows = 0;

        if (strpos($sql, 'SELECT') !== false && strpos($sql, 'FROM') !== false){
            $file_path = dirname(__FILE__) . '../../../cache/mysql/';
            $file_name = md5($sql);
            if (isset($params['table'])){
                $file_path .= $params['table'] . '/';
            }
            mkdir($file_path, 0777, true);
            $file_name = $file_path . $file_name;
            if (file_exists($file_name)){
                $result = (array)json_decode(file_get_contents($file_name));
                if (is_array($result)){
                    foreach ($result as &$a){
                        $a = (array)$a;
                    }
                    if (isset($result['items'])){
                        foreach ($result['items'] as &$a){
                            $a = (array)$a;
                        }
                    }
                    if (isset($result['total_rows'])){
                        $result['total_rows'] = $result['total_rows'][0];
                    }
                }

            } else {
                if ($rs = $this->mysqli->query($sql)){

                    $array = array();
                    while($row = $this->fetch_array($rs)){
                        $array[] = $row;
                    }

                    if (isset($params['total_rows']) && $params['total_rows']){
                        $query2 = $this->query("SELECT FOUND_ROWS()");
                        $row = $this->fetch_array($query2);
                        $total_rows = $row["FOUND_ROWS()"];

                    }


                    if (isset($params['total_rows']) && $params['total_rows']){
                        $result = array();
                        $result['items'] = $array;
                        $result['total_rows'] = $total_rows;


                    } else {
                        $result = $array;
                    }
                    //var_dump($result);
                    file_put_contents($file_name, json_encode($result, JSON_UNESCAPED_UNICODE));
                }
            }

        } else {

        }
        if (isset($params['single_array']) && $params['single_array'] && count($result) == 1){
            $result = $result[0];

        }

        return $result;
    }

    public function select($sql, $params = array()){
        //$result = $this->GetCache($sql, $params);
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

    public function multi_insert($table, $params, $ignore = true){
        $ignore = $ignore ? ' IGNORE ' : '';
        $fields = array();
        $values = array();
        $result = false;
        foreach ($params[0] as $key => $value){
            $fields[] = '`'.$key.'`';
        }
        foreach ($params as $param){
            $value = array();
            foreach ($param as $k=>$a){
                $value[] = "'".$this->input($a)."'";
            }
            $values[] = '('.implode(',',$value).')';
        }
        $sql = "INSERT $ignore INTO $table (".implode(',',$fields).") VALUES " . implode(',',$values);
        if( $this->query($sql)){
            $result = $this->mysqli->affected_rows;
        }
        return $result;
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