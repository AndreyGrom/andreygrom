<?php
class AdminCatalogController extends AdminController{
    public function __construct() {
        parent::__construct();
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table_c = db_pref . $config['table'];
        $this->table_i = db_pref . $config['table2'];
        $this->name = $config['name'];
        $this->version = $config['version'];
        $this->page_title = $config['title'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }
    public function SetPlugins(){
        $this->SetJS(HTML_PLUGINS_DIR.'tinymce/tinymce.min.js');
        $this->SetJS(HTML_PLUGINS_DIR.'init_mce.js');
    }
    public function ShowMenu(){
        $this->widget_left_top .= $this->fetch('menu.tpl');
    }
    public function GetCategories(){

    }
    public function ShowCategory(){
        $this->SetPlugins();
        $this->content = $this->SetTemplate('category.tpl');
    }
    public function SaveCategory(){
        $this->LoadModel($this->alias);
        $id = $this->ModelCatalog->SaveCategory($this->post, $this->id);
        if ($id > 0) {
            $_SESSION['alert'] = 'Страница сохранена';
            $this->Head('?c=' . $this->alias . '&id=' . $id);
        }  else {
            $this->alert = "Ошибка: " . $this->ModelCatalog->error;
        }
    }
    public function Index(){

        if (isset($this->post['save-category'])){
            $this->SaveCategory();
        }

        $this->ShowMenu();

        if (isset($this->get['category_id'])){
            $this->ShowCategory();
        } else {
            $this->content = $this->SetTemplate('index.tpl');
        }

        return $this->content;
    }
}
?>