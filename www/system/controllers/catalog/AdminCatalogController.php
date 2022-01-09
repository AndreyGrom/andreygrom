<?php
class AdminCatalogController extends AdminController{
    private $material_id;
    private $category_id;
    private $alias;
    private $table_c;
    private $action;
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
        $this->material_id  = isset($this->get['material_id']) ? $this->get['material_id'] : -1;
        $this->category_id  = isset($this->get['category_id']) ? $this->get['category_id'] : -1;
        $this->action       = isset($this->get['action']) ? $this->get['action'] : '';
    }
    public function SetPlugins(){
        $this->SetJS(HTML_PLUGINS_DIR.'tinymce/tinymce.min.js');
        $this->SetJS(HTML_PLUGINS_DIR.'init_mce.js');
    }
    public function ShowMenu(){
        $this->assign(array(
            'categories' => $this->structure,
        ));
        $menu = $this->fetch('menu2.tpl');
        $this->assign(array(
            'menu' => $menu,
        ));
        $this->widget_left_top .= $this->fetch('menu.tpl');
    }
    public function ShowCategory(){
        if ($this->get['category_id'] > 0){
            $item = $this->ModelCatalog->GetCategoryOnly($this->category_id);
            $this->assign(array(
                'item'            => $item,
            ));
        }
        $this->assign(array(
            'categories'           => $this->categories,
            'templates'       => $this->func->getTemplates($this->templates_dir.$this->alias.'/list/'),
        ));
        $this->SetPlugins();
        $this->content = $this->SetTemplate('category.tpl');
    }
    public function SaveCategory(){
        $id = $this->ModelCatalog->SaveCategory($this->post, $this->category_id);
        if ($id > 0) {
            $_SESSION['alert'] = 'Категория сохранена';
            $this->Head('?c=' . $this->alias . '&category_id=' . $id);
        }  else {
            $this->alert = "Ошибка: " . $this->ModelCatalog->error;
        }
    }
    public function RemoveCategory(){
        if ($this->ModelCatalog->RemoveCategory($this->category_id)){
            // TODO Здесь удалять связи со всеми материалами
            $_SESSION['alert'] = "Категория удалена";
            $this->Head("?c=" . $this->alias);
        }
    }
    public function SaveItem(){

    }

    public function ShowItem(){

        $this->SetPlugins();
        $this->content = $this->SetTemplate('item.tpl');
    }

    function AjaxCheckAliasCategory(){
        $alias = $this->post['alias'];
        if (trim($alias) == ''){
            echo '<span style="color: red">Алиас пустой</span>';
            exit;
        }

        $sql = "SELECT * FROM $this->table_c WHERE alias = '$alias'";
        if (isset($this->post['id'])){
            $sql .= " AND id <> " . $this->post['id'];
        }
        if ($this->db->select($sql)){
            echo '<span style="color: red">Алиас существует</span>';
        } else {
            echo '<span style="color: green">Можно использовать</span>';
        }
        exit;
    }

    public function Index(){
        $this->LoadModel($this->alias);
        if (isset($this->post['save-category'])){
            $this->SaveCategory();
        }
        if (isset($this->post['check-alias-category'])){
            $this->AjaxCheckAliasCategory();
        }
        $this->categories = $this->ModelCatalog->GetPages(array('sort' => 'id ASC'));
        $this->structure = $this->func->getStructure($this->categories);
        $this->ShowMenu();

        if ($this->action =='remove-category'){
            $this->RemoveCategory();
        } elseif ($this->category_id  > -1 && $this->material_id == -1){
            $this->ShowCategory();
        } elseif ($this->material_id > -1){
            $this->ShowItem();
        }
        else {
            $this->content = $this->SetTemplate('index.tpl');
        }

        return $this->content;
    }
}
?>