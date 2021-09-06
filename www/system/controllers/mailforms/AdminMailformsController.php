<?php

class AdminMailformsController extends AdminController {
    private $forms = array();
    private $id;
    private $alias;
    private $table;
    private $action;

    public function __construct() {
        parent::__construct();
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->table_fields = db_pref . $config['table2'];
        $this->name = $config['name'];
        $this->version = $config['version'];
        $this->page_title = $config['title'];
        $this->assign(array(
            'module_config' => $config,
        ));
        $this->id            = isset($this->get['id']) ? $this->get['id'] : 0;
        $this->action        = isset($this->get['action']) ? $this->get['action'] : '';
    }

    public function ShowMenu(){
        $this->assign(array(
            'forms' => $this->forms,
        ));
        $this->widget_left_top .= $this->fetch('menu.tpl');
    }

    public function SaveMailform(){
        $params = array(
            'name' => $this->post['name'],
            'desc' => $this->post['desc'],
            'answer' => $this->post['answer'],
            'date_edit' => time(),
            'user_id' => $this->session['admin']['id'],
        );
        if ($this->id > 0){
            $this->db->update($this->table, $params, "id = " . $this->id);
        } else {
            $params['date_create'] = time();
            $this->db->insert($this->table, $params);
            $this->id = $this->db->last_id();
        }
        $this->Head("?c=" . $this->alias . "&id=" . $this->id);
    }

    public function GetForms(){
        $sql = "SELECT * FROM " . $this->table;
        return $this->db->select($sql);
    }

    public function GetForm($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id = $id LIMIT 1";
        $form = $this->db->select($sql, array("single" => true));
        return $form;
    }

    public function GetFields($form_id){
        $sql = "SELECT * FROM " . $this->table_fields . " WHERE form_id = $form_id";
        return $this->db->select($sql);
    }

    public function ShowForm(){
        $item = $this->GetForm($this->id);
        $item['fields'] = $this->GetFields($item['id']);
        $this->assign(array(
            'item' => $item
        ));
        $this->content = $this->SetTemplate('item.tpl');
    }

    public function SaveField(){
        $params = array(
            'form_id' => $this->id,
            'name' => $this->post['name'],
            'type' => $this->post['type'],
            'values' => $this->post['values'],
            'placeholder' => $this->post['placeholder'],
            'required' => $this->post['required'],
        );
        if ($this->post['id'] > 0){
            $this->db->update($this->table_fields, $params, "id = " . $this->post['id']);
        } else {
            $this->db->insert($this->table_fields, $params);
        }
        $this->Head("?c=" . $this->alias . "&id=" . $this->id);
    }

    public function RemoveField(){
        $sql = "DELETE FROM " . $this->table_fields . " WHERE id = " . $this->get['subid'];
        $this->db->query($sql);
        $this->Head("?c=" . $this->alias . "&id=" . $this->id);
    }

    public function RemoveForm(){
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $this->id;
        $this->db->query($sql);
        $sql = "DELETE FROM " . $this->table_fields . " WHERE form_id = " . $this->id;
        $this->db->query($sql);
        $this->Head("?c=" . $this->alias);
    }

    public function Index(){
        if (isset($this->post['save-mailform'])){
            $this->SaveMailform();
        }
        if (isset($this->post['save-mailform-field'])){
            $this->SaveField();
        }

        if ($this->action == 'remove-field'){
            $this->RemoveField();
        }
        if ($this->action == 'remove-form'){
            $this->RemoveForm();
        }

        $this->forms = $this->GetForms();
        $this->ShowMenu();

        if ($this->id > 0){
            $this->ShowForm();
        } else {
            $this->content = $this->SetTemplate('index.tpl');
        }

        return $this->content;
    }


}
?>