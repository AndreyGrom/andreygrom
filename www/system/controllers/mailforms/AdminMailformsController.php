<?php

class AdminMailformsController extends AdminController {
    private $forms = array();
    private $id;
    private $alias;
    private $table;
    private $table_fields;
    private $table_messages;
    private $messages;
    private $action;
    private $templates;

    public function __construct() {
        parent::__construct();
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->table_fields = db_pref . $config['table2'];
        $this->table_messages = db_pref . $config['table3'];
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
        $this->assign(array('config' => $this->config));
        $this->widget_left_top .= $this->fetch('menu.tpl');
    }

    public function SaveMailform(){
        $params = array(
            'name' => $this->post['name'],
            'desc' => $this->post['desc'],
            'answer' => $this->post['answer'],
            'emails' => $this->post['emails'],
            'template' => $this->post['template'],
            'date_edit' => time(),
            'user_id' => $this->session['admin']['id'],
        );
        if ($this->post['form_id'] > 0){
            $this->db->update($this->table, $params, "id = " . $this->post['form_id']);
        } else {
            $params['date_create'] = time();
            $this->db->insert($this->table, $params);
            $this->post['form_id'] = $this->db->last_id();
        }
        $this->Head("?c=" . $this->alias . "&id=" . $this->post['form_id']);
    }

    public function GetForms(){
        $sql = "SELECT * FROM " . $this->table;
        return $this->db->select($sql);
    }

    public function GetForm($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id = $id LIMIT 1";
        $form = $this->db->select($sql, array("single" => true));
        $sql = "SELECT * FROM " . $this->table_fields . " WHERE form_id = $id";
        $form['fields'] = $this->db->select($sql);
        return $form;
    }

    public function ShowForm(){
        $item = $this->GetForm($this->id);
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

    public function GetTemplates(){
        $rs = array();
        if ($list = scandir(__DIR__ . "/templates")){
            foreach ($list as $i) {
                if ($i == '.' || $i == '..') continue;
                $rs[] = $i;
            }
        }
        return $rs;
    }

    public function SaveMailSettings(){
        foreach ($this->post as $k => $s){
            if ($k == "save-mailform-settings") continue;
            $this->config->set($k, $s, '');
        }
        $this->Head($_SERVER['HTTP_REFERER']);
    }

    public function GetMessages($form_id = 0){
        $sql = "SELECT m.*, f.name FROM " . $this->table_messages . " m
                LEFT JOIN " . $this->table . " f ON f.id = m.form_id
        ";
        if ($form_id > 0){
            $sql .= " WHERE form_id = $form_id";
        }
        return $this->db->select($sql);
    }

    public function RemoveMessage(){
        $sql = "DELETE FROM " . $this->table_messages . " WHERE id = " . $this->id;
        $this->db->query($sql);
        $this->Head($_SERVER['HTTP_REFERER']);
    }

    public function Index(){
        if (isset($this->post['save-mailform'])){
            $this->SaveMailform();
        }
        if (isset($this->post['save-mailform-field'])){
            $this->SaveField();
        }
        if (isset($this->post['save-mailform-settings'])){
            $this->SaveMailSettings();
        }

        if ($this->action == 'remove-field'){
            $this->RemoveField();
        }
        if ($this->action == 'remove-form'){
            $this->RemoveForm();
        }
        if ($this->action == 'remove-message'){
            $this->RemoveMessage();
        }
        if ($this->id > 0) {
            $this->messages = $this->GetMessages($this->id);
        }
        elseif (isset($this->get['messages_id'])){
            $this->messages = $this->GetMessages($this->get['messages_id']);
        }
        else {
            $this->messages = $this->GetMessages();
        }
        $this->forms = $this->GetForms();
        $this->assign(array(
            'forms' => $this->forms,
            'templates' => $this->GetTemplates(),
            'messages'  => $this->messages
        ));
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