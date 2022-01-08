<?php

class AdminConfigController extends AdminController {
    public function __construct() {
        parent::__construct();
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->name = $config['name'];
        $this->version = $config['version'];
        $this->page_title = $config['title'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }

    public function ShowMenu(){

        $this->widget_left_top .= $this->fetch('menu.tpl');
    }

    public function Index(){
        if (isset($this->post['action']) && $this->post['action'] == 'set'){
            $this->config->set($this->post['param'], $this->post['value'], $this->post['desc']);
            echo 1;
            exit;
        }
        if (isset($this->get['action']) && $this->get['action'] == 'del'){
            $this->config->del($this->get['param']);
            $_SESSION['alert'] = "Параметр удален!";
            $this->Head($_SERVER['HTTP_REFERER']);
        }
        $this->ShowMenu();
        $items = $this->db->select("SELECT * FROM $this->table ORDER BY param ASC");
        $this->assign(array(
            'items' => $items,
        ));
        $this->content = $this->SetTemplate('index.tpl');
        return $this->content;
    }
}
?>