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

    public function CheckAlias(){
        $id = isset($this->post['id']) ? $this->post['id'] : 0;
        $alias = $this->post['alias'];
        $rs = $this->ModelPages->CheckAlias($alias, $id);
        if ($rs === 0){
            echo 'Годен';
        } else {
            echo $rs;
        }
        exit;
    }

    public function SavePage(){
        $this->LoadModel($this->alias);
        $rs = $this->ModelPages->SavePage($this->post, $this->id);
        echo json_encode($rs);
        exit;
    }


    public function ShowPage(){
        if (isset($this->get['success-save-page'])){
            $this->alert = 'Страница сохранена';
        }
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
        // TODO вложенные страницы перенаправлять  на верхний уровень
        if ($this->id > 1){
            $this->ModelPages->RemovePage($this->id);
            $this->alert('Страница удалена');
        }
        $this->Head("?c=" . $this->alias);
    }

    public function Index(){
        $this->LoadModel($this->alias);
        if (isset($this->post['action']) && $this->post['action'] == "check-alias"){
            $this->CheckAlias();
        }

        $this->SetPlugins();
        if (isset($this->post['action']) && $this->post['action'] == 'save-page'){
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