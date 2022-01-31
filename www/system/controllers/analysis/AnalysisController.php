<?php
class AnalysisController extends Controller{
    private $alias;
    private $table;
    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }
    public function GetItem($id){
        $sql = "SELECT * FROM $this->table WHERE id = $id LIMIT 1";
        return $this->db->select($sql, array('single' => true));
    }
    public function ShowItems(){
        $this->SetPath('/analysis/list/');
        $this->content = $this->SetTemplate('default.tpl');
    }
    public function ShowItem(){
        if ($item = $this->GetItem($this->query[0])){;
            $analysis = new Analysis();
            $analysis->url = $item['url'];
            $analysis->data = $item['content'];
            $analysis->headers = explode(PHP_EOL, $item['headers']);
            if (count($analysis->headers) > 0){
                foreach ($analysis->headers as &$h){
                    $a = explode(':', $h);
                    $h = array($a[0], isset($a[1]) ? trim($a[1]) : '');
                }
            }
            $rs = $analysis->Run();
            //var_dump($rs);
            $return = $item['content'] !== '';

            $this->page_title = "Анализ страницы " . $item['url'];
            $this->meta_description = isset($rs->meta_description[0]['content']) ? $rs->meta_description[0]['content'] : '';
            $this->meta_keywords = isset($rs->meta_keywords[0]['content']) ? $rs->meta_keywords[0]['content'] : '';
            if ($this->meta_title == ''){
                $this->meta_title = $this->page_title . '. Анализ сайтов. '. $this->config->SiteTitle;
            }

            $this->assign(array(
                'item' => $rs,
                'return' => $return,
            ));
        }
        $this->SetPath('/analysis/single/');
        $this->content = $this->SetTemplate('default.tpl');
    }
    public function Index(){
        if (count($this->query) > 0){
            $this->ShowItem();
        }
        else {
            $this->ShowItems();
        }

        return $this->content;
    }
}
?>