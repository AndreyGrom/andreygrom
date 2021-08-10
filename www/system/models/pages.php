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
        $result = false;
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
            //'ip' => INET_ATON(), // TODO ПОДУМАТЬ КАК ХРАНИТЬ
        );
        // Проверяем алиас
        if ($this->func->AliasExists($this->table, 'alias', $alias)){
            $this->error = "Такой алиас уже существует";
        } else {
            if ($id == 0){
                $param['date_create'] = time();
                $param['date_edit'] = time();
                if ($result !== $this->db->insert($this->table, $param, true)){
                    $this->error = $this->db->error();
                }
            } else {
                if ($result !== $this->db->update($this->table, $param, "WHERE id = $id")){
                    $this->error = $this->db->error();
                }
            }
        }

        return $result;
    }

    function GetPages($params = array()){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : '`ID` DESC';
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
            $sql .= "alias = $id";
        }
        if (isset($params['publ'])){
            $sql .= "AND publ = 1";
        }
        return $this->db->select($sql, array('single' => true));
    }

    public function GetPageClient($alias){
        return $this->db->select("SELECT * FROM $this->table WHERE alias = '$alias' AND `release` = 1 LIMIT 1", array('single' => true));
    }

}
?>