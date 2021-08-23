<?php

class ModelPages extends Model {
    public $table;
    public function __construct() {
        parent::__construct();
        $config = include CONTROLLERS_DIR . '/pages/init.php';
        $this->table = db_pref . $config['table'];
    }
    function SavePage($params, $id = 0){
        $alias = ($params['alias'] !=='') ? $params['alias'] : $this->func->TranslitURL($params['title']);
        $param = array(
            'parent_id' => (int)$params['parent_id'],
            'alias' => $alias,
            'title' => $params['title'],
            'short_content' => $params['short_content'],
            'content' => $params['content'],
            'meta_title' => $params['meta_title'],
            'meta_desc' => $params['meta_desc'],
            'meta_keywords' => $params['meta_keywords'],
            'publ' => (int)$params['publ'],
            'comments' => (int)$params['comments'],
            'template' => $params['template'],
            'position' => (int)$params['position'],
            'user_id' => $this->session['admin']['id'],
            'views' => (int)$params['views'],
            //'ip' => INET_ATON(), // TODO ПОДУМАТЬ КАК ХРАНИТЬ
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

    public function GetPage($id, $params = array()){
        $sql = "SELECT * FROM $this->table WHERE ";
        if (is_numeric($id)){
            $sql .= "id = $id";
        } else {
            $sql .= "alias = '$id'";
        }
        if (isset($params['publ'])){
            $sql .= "AND publ = 1";
        }

        $row = $this->db->select($sql, array('single' => true));
        $row['date_create'] = $this->func->DateFormat($row["date_create"]);
        $row['date_edit'] = $this->func->DateFormat($row["date_edit"]);
        return $row;
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

}
?>