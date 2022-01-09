<?php

class ModelCatalog extends Model {
    public $table;
    public $table2;
    public function __construct() {
        parent::__construct();
        $config = include CONTROLLERS_DIR . '/catalog/init.php';
        $this->table = db_pref . $config['table'];
        $this->table2 = db_pref . $config['table2'];
    }
    function SaveCategory($params, $id = 0){
        $alias = ($params['alias'] !=='') ? $params['alias'] : $this->func->TranslitURL($params['title']);
        $param = array(
            'parent_id' => (int)$params['parent_id'],
            'alias' => $alias,
            'title' => $params['title'],
            'desc1' => $params['desc1'],
            'desc2' => $params['desc2'],
            'position'  => is_int($params['position']) ? $params['position'] : 0,
            'meta_title' => $params['meta_title'],
            'meta_desc' => $params['meta_desc'],
            'meta_keywords' => $params['meta_keywords'],
            'public' => (int)$params['public'],
            'comments' => (int)$params['comments'],
            'template' => $params['template'],
            'user_id' => $this->session['admin']['id'],
            'ip' => $_SERVER['REMOTE_ADDR'], // TODO ПОДУМАТЬ КАК ХРАНИТЬ
        );

        if ($id == 0){
            // Проверяем алиас
            if ($this->func->AliasExists($this->table, 'alias', $alias)){
                $this->error = "Такой алиас уже существует";
            } else {
                $param['date_create'] = time();
                $param['date_edit'] = time();
                $result = $this->db->insert($this->table, $param, true);
                $id = $this->db->last_id();
            }
        } else {
            if (!$this->db->update($this->table, $param, "id = $id")){
                $id = 0;
            }
        }
        if ($this->db->error() != ''){
            $this->error = $this->db->error();
            $id = 0;
        }
        return $id;
    }
    public function GetCategoryOnly($id, $params = array()){
        $sql = "SELECT * FROM $this->table WHERE ";
        if (is_numeric($id)){
            $sql .= "id = $id";
        } else {
            $sql .= "alias = '$id'";
        }
        if (isset($params['public'])){
            $sql .= "AND public = 1";
        }
        $row = $this->db->select($sql, array('single' => true));
        $row['date_create'] = $this->func->DateFormat($row["date_create"]);
        $row['date_edit'] = $this->func->DateFormat($row["date_edit"]);
        return $row;
    }
    function GetCategories($params = array()){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : 'id DESC';
        $where = isset($params['where']) ? $params['where'] : "";
        $sql = "SELECT * FROM $this->table $where ORDER BY $sort";
        if ($list = $this->db->query($sql)){
            foreach ($list as $l) {
                $l['date_create'] = $this->func->DateFormat($l["date_create"]);
                $l['date_edit'] = $this->func->DateFormat($l["date_edit"]);
                $result[] = $l;
            }
        }
        return $result;
    }
    public function RemoveCategory($id){
        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->db->query($sql);
    }


//    /////////////////////////

    function GetPages($params = array()){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : '`id` DESC';
        $where = isset($params['where']) ? $params['where'] : "";
        $sql = "SELECT * FROM $this->table $where ORDER BY $sort";
        $query = $this->db->query($sql);
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $row['date_create'] = $this->func->DateFormat($row["date_create"]);
                $row['date_edit'] = $this->func->DateFormat($row["date_edit"]);
                $result[] = $row;
            }
        }
        return $result;
    }

    public function SetViews($id, $plus){
        $sql = "UPDATE $this->table SET views = views + $plus WHERE ";
        if (is_numeric($id)){
            $sql .= "id = $id";
        } else {
            $sql .= "alias = '$id'";
        }
        $result = $this->db->query($sql);
        if ($this->db->error() != ''){
            $this->error = $this->db->error();
        }
        return $result;
    }

    public function RemovePage($id){
        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->db->query($sql);
    }

    public function GetCategory($id, $params = array()){
        $sql = "SELECT * FROM $this->table WHERE ";
        if (is_numeric($id)){
            $sql .= "id = $id";
        } else {
            $sql .= "alias = '$id'";
        }
        if (isset($params['public'])){
            $sql .= "AND public = 1";
        }

        $row = $this->db->select($sql, array('single' => true));
        $row['date_create'] = $this->func->DateFormat($row["date_create"]);
        $row['date_edit'] = $this->func->DateFormat($row["date_edit"]);
        return $row;
    }

}
?>