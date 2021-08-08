<?php

class ModelPages extends Model {
    public $table;
    public function __construct() {
        parent::__construct();
        $this->table = db_pref.'pages';

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
            'old' => 0,
            'release' => 1,
            //'ip' => INET_ATON(), // TODO ПОДУМАТЬ КАК ХРАНИТЬ
        );

        if ($id == 0){
            // Проверяем алиас
            if ($this->func->AliasExists($this->table, 'alias', $alias)){
                $this->error = "Такой алиас уже существует";
            } else {
                $param['date_create'] = time();
                $param['date_edit'] = time();
                if ($this->db->insert($this->table, $param, true)){
                    $result = $this->db->last_id();
                    // ассоциацию с прежними версиями ставим в текущий id, так как прежних версий нет
                    $this->db->query("UPDATE $this->table SET old = $result WHERE id = $result");
                } else{
                    $this->error = $this->db->error();
                }
            }
        } else {
            if ($this->func->AliasExists($this->table, 'alias', $alias)){
                $this->error = "Такой алиас уже существует";
            } else {
                $old_page = $this->GetPage($id, array('single' => true));
                $old = $old_page['old'];
                $param['date_create'] = $old_page['date_create'];
                $param['date_edit'] = time();
                if ($this->db->insert($this->table, $param, true)){
                    $result = $this->db->last_id();
                    // ассоциацию с прежними версиями ставим как в предыдущей
                    $this->db->query("UPDATE $this->table SET old = $old WHERE id = $result");
                    // предыдущую версию снимаем с публикации
                    $this->db->query("UPDATE $this->table SET `release` = 0 WHERE id = $id");
                } else{
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

    public function GetPage($id){
        return $this->db->select("SELECT * FROM $this->table WHERE id = $id AND `release` = 1 LIMIT 1", array('single' => true));
    }

    public function GetPageClient($alias){
        return $this->db->select("SELECT * FROM $this->table WHERE alias = '$alias' AND `release` = 1 LIMIT 1", array('single' => true));
    }

}
?>