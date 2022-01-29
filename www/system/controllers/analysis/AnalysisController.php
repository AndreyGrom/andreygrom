<?php
class AnalysisController extends Controller{
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
        if ($item = $this->GetItem($this->query[0])){
            $analysis = new Analysis();
            $analysis->url = $item['url'];
            $analysis->data = $item['content'];
            $analysis->headers = $item['headers'];
            $analysis->headers = explode(PHP_EOL, $analysis->headers);
            $rs = $analysis->Run();
            //var_dump($rs);
            $this->assign(array(
                'item' => $rs,
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