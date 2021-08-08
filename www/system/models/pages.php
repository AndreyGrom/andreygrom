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
            'rel' => 1,
            'user_id' => $this->session['admin']['id'],
            //'ip' => INET_ATON(), // TODO ПОДУМАТЬ КАК ХРАНИТЬ
        );

        if ($id == 0){
            if ($this->func->AliasExists($this->table, 'alias', $alias)){
                $this->error = "Такой алиас уже существует";
            } else {
                $param['date_create'] = time();
                $param['date_edit'] = time();
                if ($this->db->insert($this->table, $param, true)){
                    $result = $this->db->last_id();
                } else{
                    $this->error = $this->db->error();
                }
            }
        } else {
            $param['date_edit'] = time();
            if ($this->db->update($this->table, $param, "ID = $id")){
                $result =  $id;
            }else{
                $this->error = $this->db->error();
            }
        }

        return $result;
    }

    function GetPages($params = array()){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : '`ID` DESC';
        $sql = "SELECT * FROM $this->table ORDER BY $sort";
        $query = $this->db->query($sql);
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $row['DATE_PUBL'] = $this->func->DateFormat($row["DATE_PUBL"]);
                $row['DATE_EDIT'] = $this->func->DateFormat($row["DATE_EDIT"]);
                $result[] = $row;
            }
        }
        return $result;
    }

    public function GetPage($id){
        return $this->db->select("SELECT * FROM $this->table WHERE ID = $id LIMIT 1", array('single' => true));
    }

    public function GetPageClient($alias){
        return $this->db->select("SELECT * FROM $this->table WHERE alias = '$alias' LIMIT 1", array('single' => true));
    }

}
?>