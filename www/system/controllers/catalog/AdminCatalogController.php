<?php
class AdminCatalogController extends AdminController{
    private $material_id;
    private $category_id;
    private $categories;
    private $structure;
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
    public function CheckAliasCateory(){
        $id = isset($this->post['id']) ? $this->post['id'] : 0;
        $alias = $this->post['alias'];
        $rs = $this->ModelCatalog->CheckAliasCategory($alias, $id);
        echo $rs;
        exit;
    }
    public function CheckAliasItem(){
        $id = isset($this->post['id']) ? $this->post['id'] : 0;
        $alias = $this->post['alias'];
        $rs = $this->ModelCatalog->CheckAliasItem($alias, $id);
        echo $rs;
        exit;
    }
    public function ShowCategoryEdit(){
        if ($this->get['category_id'] > 0){
            $item = $this->ModelCatalog->GetCategoryOnly($this->category_id);
            $this->assign(array(
                'item'            => $item,
            ));
        }
        $this->assign(array(
            'categories'      => $this->categories,
            'templates'       => $this->func->getTemplates($this->templates_dir.$this->alias.'/list/'),
        ));
        $this->SetPlugins();
        $this->content = $this->SetTemplate('category.tpl');
    }
    public function ShowCategory(){
        $rs = $this->ModelCatalog->GetCategoryMaterials($this->category_id);
        $rs['items'] = $this->db->fetch_all($rs['query']);
        if ($this->get['category_id'] > 0) {
            $category = $this->ModelCatalog->GetCategoryOnly($this->category_id);
        }
        $this->assign(array(
            'items'            => $rs['items'],
            'num_pages'        => $rs['num_pages'],
            'pagination'       => $rs['pagination'],
            'total'            => $rs['total'],
            'start'            => $rs['start'],
            'error'            => $rs['error'],
            'sql'              => $rs['sql'],
            'category'         => $category,
        ));
        $this->SetPlugins();
        $this->content = $this->SetTemplate('items.tpl');
    }
    public function SaveCategory(){
        $rs = $this->ModelCatalog->SaveCategory($this->post, $this->category_id);
        echo json_encode($rs);
        exit;
    }
    public function RemoveCategory(){
        if ($this->ModelCatalog->RemoveCategory($this->category_id)){
            // TODO Здесь удалять связи со всеми материалами
            $_SESSION['alert'] = "Категория удалена";
            $this->Head("?c=" . $this->alias);
        }
    }
    public function SaveItem(){
        $rs = $this->ModelCatalog->SaveItem($this->post, $this->material_id);
        echo json_encode($rs);
        exit;
    }

    public function ShowItem(){
        $this->assign(array(
            'categories'         => $this->categories,
            'templates'       => $this->func->getTemplates($this->templates_dir.$this->alias.'/list/'),
        ));
        if ($this->material_id >-1){
            if ($item = $this->ModelCatalog->GetItem($this->material_id)){
                $this->assign(array(
                    'item'         => $item,
                ));
            }
        }
        $this->SetPlugins();
        $this->content = $this->SetTemplate('item.tpl');
    }

    public function Removeitem(){
        if ($this->ModelCatalog->RemoveItem($this->material_id)){
            $_SESSION['alert'] = "Материал удален";
            $this->Head("?c=" . $this->alias . "&action=show-all");
        }
    }

    public function ImagesUpload(){
        $data = $this->ModelCatalog->UploadImages($this->material_id);
        $smart = Smart::getInstance();
        $html = '';
        foreach ($data['files'] as $f){
            $smart->assign(array(
                'img' => $f['img'],
                'img_id' => $f['id'],
            ));
            $html .= $smart->fetch('image.tpl');
        }
        $data['html'] = $html;
        die( json_encode( $data ) );
    }

    public function RemoveImageItem(){
        $data = $this->ModelCatalog->RemoveImageItem($this->post['id']);
        die($data);
    }

    public function SetSkinItem(){
        $data = $this->ModelCatalog->SetSkinItem($this->material_id, $this->post['id']);
        die($data);
    }

    public function ShowSettings(){
        $this->assign(array(
            'templates_comment_form'      => $this->func->getTemplates($this->templates_dir.'comments/form/'),
            'templates_comment_view'      => $this->func->getTemplates($this->templates_dir.'comments/view/'),
        ));
        $this->content = $this->SetTemplate('settings.tpl');
    }
    public function SaveSettings(){
        foreach ($this->post as $k=>$p){
            $this->config->set($k,$p);
        }
        die(1);
    }
    public function Index(){
        $this->LoadModel($this->alias);
        if (isset($this->post['action']) && $this->post['action'] == 'save-category'){
            $this->SaveCategory();
        }
        if (isset($this->post['action']) && $this->post['action'] == "check-alias-category"){
            $this->CheckAliasCateory();
        }
        if (isset($this->post['action']) && $this->post['action'] == 'save-item'){
            $this->SaveItem();
        }
        if (isset($this->post['action']) && $this->post['action'] == "check-alias-item"){
            $this->CheckAliasItem();
        }
        if (isset($this->post['action']) && $this->post['action'] == "images-upload-item"){
            $this->ImagesUpload();
        }
        if (isset($this->post['action']) && $this->post['action'] == "remove-image-item"){
            $this->RemoveImageItem();
        }
        if (isset($this->post['action']) && $this->post['action'] == "set-skin-item"){
            $this->SetSkinItem();
        }
        if (isset($this->post['action']) && $this->post['action'] == "save-settings"){
            $this->SaveSettings();
        }
        $this->categories = $this->ModelCatalog->GetCategories(array('sort' => 'id ASC'));
        $this->structure = $this->func->getStructure($this->categories);
        $this->ShowMenu();

        if ($this->action =='settings'){
            $this->ShowSettings();
        }
        elseif ($this->action =='remove-category'){
            $this->RemoveCategory();
        }
        elseif ($this->action =='remove-item'){
            $this->RemoveItem();
        }
        elseif ($this->action =='show-all'){
            $this->ShowCategory();
        }
        elseif ($this->action =='category-edit'){
            $this->ShowCategoryEdit();
        }
        elseif ($this->category_id  > -1 && $this->material_id == -1){
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