<?php

class PagesController extends Controller {
    private $alias;
    private $table;

    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
    }
    public function Index(){
        $this->LoadModel('pages');
        if ($this->query){
            $row = $this->ModelPages->GetPage(end($this->query));
        } else {
            $row = $this->ModelPages->GetPage(1);
        }
        if ($row){
            $this->page_title = $row['title'];
            $this->meta_title = $row['meta_title'];
            $this->meta_description = $row['meta_desc'];
            $this->meta_keywords = $row['meta_keywords'];
            $this->page_title = $row['title'];
            if ($this->meta_title == ''){
                $this->meta_title = $this->page_title . ' - ' . $this->config->SiteTitle;
            }
            if ($this->meta_description == ''){
                $this->meta_description = mb_substr(strip_tags($row['conent']), 0, 200, 'UTF-8');;
            }
            if ($row['id'] > 1){
                $this->breadcrumbs = array(
                    array('text' => 'Главная', 'href' => '/'),
                    array('text' => $row['title'], 'href' => ''),
                );
            }

        }
        $this->SetPath($this->alias.'/');
        $this->assign(array(
            'page_title'       => $row['title'],
            'page_content'     => $row['content'],
        ));
        $this->content = $this->SetTemplate($row['template'] . '.tpl');
   /*     $this->SetPath('pages/');
        $this->content =$this->SetTemplate('main.tpl');*/
        return $this->content ;
    }

}