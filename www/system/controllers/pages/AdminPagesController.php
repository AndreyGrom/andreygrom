<?php

class AdminPagesController extends AdminController {
    private $pages = array();
    private $categories = array();
    private $structure = array();
    private $id = 0;
    private $cid = 0;
    public $module_alias = 'pages';

    public function __construct() {
        parent::__construct();
        $this->table_name = db_pref.'pages';
        $this->module_alias = 'pages';
        $this->admin_page_title = 'Управление страницами сайта';
        $this->id            = isset($this->get['id']) ? $this->get['id'] : 0;
        $this->cid           = isset($this->get['cid']) ? $this->get['cid'] : 0;
        $this->act           = isset($this->get['act']) ? $this->get['act'] : '';
    }

    public function SetPlugins(){
  /*      $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.min.js';
        $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.rfm.js';
        $this->css[]  = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.css';*/
        $this->js[]   = HTML_PLUGINS_DIR.'tinymce/tinymce.min.js';
    }

    public function ShowMenu(){
        $this->assign(array(
            'pages' => $this->structure,
        ));
        $menu = $this->fetch('menu2.tpl');
        $this->assign(array(
            'menu' => $menu,
        ));
        $this->widget_left_top .=$this->fetch('menu.tpl');
    }

    public function SavePage(){
        $this->LoadModel('pages');
        if ($id = $this->ModelPages->SavePage($this->post, $this->id)){
            $this->Head('?c=pages&id=' . $id);
        }
    }

    public function ShowPageNew(){
        $this->assign(array(
            'page_title'            => $this->post['title'],
            'page_alias'            => $this->post['alias'],
            'page_template'         => $this->post['template'],
            'page_parent'           => $this->post['parent'],
            'page_publ'             => isset($this->post['publ'])?$this->post['publ']:1,
            'page_content'          => $this->post['content'],
            'page_meta_title'       => $this->post['meta_title'],
            'page_meta_desc'        => $this->post['meta_description'],
            'page_meta_keywords'    => $this->post['meta_keywords'],
            'pages'                 => $this->pages,
            'templates'             => $this->func->getTemplates($this->templates_dir.'pages/'),
            'new'                   => true,
        ));
        $this->content = $this->SetTemplate('new.tpl');
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
        if ($this->id > 0){
            $this->LoadModel('pages');
            $this->assign(array(
                'page'            => $this->ModelPages->getPage($this->id),
            ));
        }

        $this->assign(array(
            'pages'           => $this->pages,
            'templates'       => $this->func->getTemplates($this->templates_dir.$this->module_alias.'/'),
        ));
        $this->content = $this->SetTemplate('new.tpl');
    }

    public function SaveSettings(){
        foreach ($this->post as $k=>$p){
            if ($k == 'save-settings') continue;
            $this->config->set($k,$p);
        }
        $this->Head("?c=pages&act=settings");
    }

    public function ShowSettings(){
        $this->assign(array(
            'templates_comment_form'      => $this->func->getTemplates($this->templates_dir.'comments/form/'),
            'templates_comment_view'      => $this->func->getTemplates($this->templates_dir.'comments/view/'),
        ));
        $this->content = $this->SetTemplate('settings.tpl');
    }

    public function getSiteMap(){
        $return = array();
        $sql = "SELECT ALIAS FROM `".db_pref."pages`  WHERE `PUBLIC`=1 ORDER BY `DATE_PUBL` DESC";
        $result = $this->db->query($sql);
        if ($this->db->num_rows($result)){
            for ($i = 0; $i < $this->db->num_rows($result); $i++){
                $row = $this->db->fetch_array($result);
                $return[]  = array(
                    'loc'           => $this->site_url . $row['ALIAS'] .'/',
                    'changefreq'    => 'weekly',
                    'priority'      => '1',
                );
            }
        }

        return $return;
    }

    public function Index(){
        $this->SetPlugins();
        $this->page_title = $this->admin_page_title;

        $this->assign(array(
            'module_alias' => $this->module_alias
        ));

        if (isset($this->post['title']) && trim($this->post['title'])!==''){
            $this->SavePage();
        }
        if (isset($this->get['del']) && isset($this->get['template']) && $this->get['template']!==''){
            $this->DeleteTempate();
        }
        if (isset($this->post['save-settings'])){
            $this->SaveSettings();
        }
        $this->LoadModel('pages');
        $this->pages = $this->ModelPages->GetPages();
        $this->structure = $this->func->getStructure($this->pages);
        $this->ShowMenu();

        if ($this->act == 'new'){
            $this->ShowPageNew();
        }
        elseif ($this->act=='del'){
            $this->DeletePage($this->id);
        }
        elseif (isset($this->id) && $this->id!==''){
            $this->ShowPage();
        }
        elseif ($this->act=='templates'){
            $this->ShowTemplateEdit();
        }
        elseif ($this->act == 'settings'){
            $this->ShowSettings();
        }
        if(!isset($this->act) && !isset($this->id)){
            $this->head("?c=$this->module_alias&id=".$this->pages[0]['ID']);
        }

        return $this->content;
    }


}
?>