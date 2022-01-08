<?php

class AdminPagesController extends AdminController {
    private $pages = array();
    private $categories = array();
    private $structure = array();
    private $id = 0;
    private $cid = 0;
    private $alias;
    private $table;
    private $action;

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

        $this->id            = isset($this->get['id']) ? $this->get['id'] : 0;
        $this->cid           = isset($this->get['cid']) ? $this->get['cid'] : 0;
        $this->action        = isset($this->get['action']) ? $this->get['action'] : '';
    }

    public function SetPlugins(){
        $this->SetJS(HTML_PLUGINS_DIR.'tinymce/tinymce.min.js');
        $this->SetJS(HTML_PLUGINS_DIR.'init_mce.js');
    }

    public function ShowMenu(){
        $this->assign(array(
            'pages' => $this->structure,
        ));
        $menu = $this->fetch('menu2.tpl');
        $this->assign(array(
            'menu' => $menu,
        ));
        $this->widget_left_top .= $this->fetch('menu.tpl');
    }

    public function SavePage(){
        $this->LoadModel($this->alias);
        $id = $this->ModelPages->SavePage($this->post, $this->id);
        if ($id > 0) {
            $_SESSION['alert'] = 'Страница сохранена';
            $this->Head('?c=' . $this->alias . '&id=' . $id);
        }  else {
            $this->alert = "Ошибка: " . $this->ModelPages->error;
        }
    }

    public function DeletePage($id){
        $sql = "SELECT * FROM $this->table_name WHERE `PARENT`=$id";
        $query = $this->db->query($sql);
        if ($this->db->num_rows($query) == 0){
            $sql = "DELETE FROM $this->table_name WHERE `ID`=$id";
            $query = $this->db->query($sql);
            $this->Head("?c=$this->module_alias&id=1");
        } else {
            $_SESSION['alert'] = 'Сначала удалите вложенные страницы!';
            $this->Head("?c=$this->module_alias&id=$this->id");
        }
    }

    public function ShowPage(){
        if ($this->get['id'] > 0){
            $page = $this->ModelPages->GetPage($this->id);
            $this->assign(array(
                'page'            => $page,
            ));
        }
        $this->assign(array(
            'pages'           => $this->pages,
            'templates'       => $this->func->getTemplates($this->templates_dir.$this->alias.'/'),
        ));
        $this->content = $this->SetTemplate('page.tpl');
    }

    public function RemovePage(){
        if ($this->id > 1){
            $this->ModelPages->RemovePage($this->id);
        }
        $this->Head("?c=" . $this->alias);
    }

    public function Index(){
        $this->LoadModel($this->alias);
        if (isset($this->post['action']) && $this->post['action'] == "CheckAlias"){
            $params = array('table' => $this->table, 'field' => 'alias');
            if (isset($this->post['id'])){
                $params['id'] = $this->post['id'];
            }
            echo $this->func->CheckAlias($this->post['alias'], $params);
            exit;
        }

        $this->SetPlugins();
        if (isset($this->post['save-page'])){
            $this->SavePage();
        }

        if ($this->action == 'remove-page'){
            $this->RemovePage();
        }

        $this->pages = $this->ModelPages->GetPages(array('sort' => 'id ASC'));
        $this->structure = $this->func->getStructure($this->pages);
        $this->ShowMenu();

        if (isset($this->get['id'])){
            $this->ShowPage();
        } else {
            $this->content = $this->SetTemplate('index.tpl');
        }

        return $this->content;
    }


}
?>