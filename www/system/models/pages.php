<?php

class ModelPages extends Model {
    public function __construct() {
        parent::__construct();
        $this->table_name = db_pref.'pages';
        $this->table_name_content = 'pages_content';

    }
    function SavePage($params, $id = 0){
        $result = false;
        $title = $params['title'];
        $parent = $params['parent'];
        $alias = ($params['alias']!=='')?$this->post['alias']:$this->func->TranslitURL($title);
        $content = $params['content'];
        $template = $params['template'];
        $comments = $params['comments'];
        $publ = $params['publ'];
        $meta_title = $params['meta_title'];
        $meta_desc = $params['meta_description'];
        $meta_keywords = $params['meta_keywords'];
        $date = time();
        $param = array(
            'PARENT' => $parent,
            'TITLE' => $title,
            'ALIAS' => $alias,
            'CONTENT' => $content,
            'META_TITLE' => $meta_title,
            'META_DESC' => $meta_desc,
            'META_KEYWORDS' => $meta_keywords,
            'COMMENTS' => $comments,
            'PUBLIC' => $publ,
            'TEMPLATE' => $template,
            'DATE_EDIT' => $date
        );

        if ($id == 0){
            if ($this->db->insert($this->table_name, $param, true)){
                $result = $this->db->last_id();
            }
        }else{
            if ($this->db->update($this->table_name, $param, "ID = $id")){
                $result =  $id;
            }

        }
        return $result;
    }

    function GetPages($params){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : '`ID` DESC';
        $sql = "SELECT * FROM $this->table_name ORDER BY $sort";
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
        return $this->db->select("SELECT * FROM $this->table_name WHERE ID = $id LIMIT 1", array('single_array' => true, 'table' => 'pages'));
    }

    public function GetPageClient($alias){
        return $this->db->select("SELECT * FROM $this->table_name WHERE alias = '$alias' LIMIT 1", array('single_array' => true, 'table' => 'pages'));
    }

}
?>