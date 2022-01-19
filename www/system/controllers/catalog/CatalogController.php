<?php
class CatalogController extends Controller{
    private $categories;
    private $structure;
    private $alias;
    private $table;
    private $table2;
    private $table3;
    private $table4;
    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->table2 = db_pref . $config['table2'];
        $this->table3 = db_pref . $config['table3'];
        $this->table4 = db_pref . $config['table4'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }

    public function ShowMainPage(){
        /*$this->page_title = $this->config->{$this->alias . 'ModuleTitle'};
        $this->meta_title = $this->config->{$this->alias . 'ModuleTitle'} . '. ' . $this->config->SiteTitle;;
        $this->meta_keywords = $this->config->{$this->alias . 'meta_keywords'};
        $this->SetPath('/catalog/');
        $this->content = $this->SetTemplate('index.tpl');*/
        $this->content = $this->Fetch404();
    }
    public function ShowItems($category){
        if ($items = $this->ModelCatalog->GetItems(array('sort' => 'id DESC', 'category_id' => $category['id']))){
            $this->assign(array(
                'items' => $items,
            ));
        }

        $this->page_title = $category['title'];
        $this->meta_title = $category['meta_title'];
        $this->meta_description = $category['meta_description'];
        $this->meta_keywords = $category['meta_keywords'];
        if ($this->meta_title == ''){
            $this->meta_title = $this->page_title . '. ' . $this->config->{$this->alias . 'ModuleTitle'} . '. '. $this->config->SiteTitle;
        }
        if (trim($this->meta_description == '')){
            $this->meta_description = mb_substr(trim(strip_tags($category['desc1'])),0,200);
        }
        if (trim($this->meta_description == '')){
            $this->meta_description = mb_substr(trim(strip_tags($category['desc2'])),0,200);
        }

        $this->assign(array(
            'category' => $category,
        ));

        $this->SetPath('/catalog/list/');
        $this->content = $this->SetTemplate($category['template'] . '.tpl');
    }

    public function ShowItem(){
        if ($item = $this->ModelCatalog->GetItem($this->query[0])){
            $this->page_title = $item['title'];
            $this->meta_title = $item['meta_title'];
            $this->meta_description = $item['meta_description'];
            $this->meta_keywords = $item['meta_keywords'];
            if ($this->meta_title == ''){
                $this->meta_title = $this->page_title . '. ' . $this->config->{$this->alias . 'ModuleTitle'} . '. '. $this->config->SiteTitle;
            }
            if (trim($this->meta_description == '')){
                $this->meta_description = mb_substr(trim(strip_tags($item['short_content'])),0,200);
            }
            if (trim($this->meta_description == '')){
                $this->meta_description = mb_substr(trim(strip_tags($item['content'])),0,200);
            }
            if ($item['img_name']){
                $this->meta_image = "/upload/images/" . $this->alias . "/" . $item['img_name'];
            }

            if ($this->config->{$this->alias . 'CommentsEnabled'} && $item['comments']){
                include_once(dirname(__FILE__).'../../comments/CommentsController.php');
                $comments = new CommentsController($this->query, $this->controller);
                $comments->material_id = $item["id"];
                $comments->controller = $this->controller;
                $comments->premoderation = $this->config->{$this->alias . 'CommentsModerationEnabled'};
                $comments->captcha = $this->config->{$this->alias . 'CommentsCaptchaEnabled'};
                $comments->tpl_view = $this->config->{$this->alias . 'CommentsTemplateView'}.'.tpl';
                $comments->tpl_form = $this->config->{$this->alias . 'CommentsTemplateForm'}.'.tpl';
                $comments ->Index();
                $this->smarty->assign(array(
                    'comments_form'                 => $comments->comments_form,
                    'comments'                      => $comments->comments,
                ));
                if (count($comments->js) > 0){
                    foreach ($comments->js as $j){
                        $this->js[]=$j;
                    }
                }
                if (count($comments->css) > 0){
                    foreach ($comments->css as $j){
                        $this->css[]=$j;
                    }
                }
            }
            $others = $this->ModelCatalog->GetOthersFromParents($item['parents'], $item['id']);
            $this->assign(array(
                'item' => $item,
                'others' => $others,
            ));

            $this->SetPath('/catalog/single/');
            $this->content = $this->SetTemplate($item['parents'][0]['template'] . '.tpl');


        } else {
            $this->content = $this->Fetch404();
        }

    }

    public function Index(){;
        $this->LoadModel($this->alias);
        $this->categories = $this->ModelCatalog->GetCategories(array('sort' => 'id ASC'));
        $this->structure = $this->func->getStructure($this->categories);
        $this->assign(array(
            'categories' => $this->categories,
        ));
        if ($category = $this->ModelCatalog->CategoryExists($this->categories, $this->query[0])){
            $this->ShowItems($category);
        }
        elseif (count($this->query) > 0){
            $this->ShowItem();
        }
        else {
            $this->ShowMainPage();
        }

        return $this->content;
    }
}
?>