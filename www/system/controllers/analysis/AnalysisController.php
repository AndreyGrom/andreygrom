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
        $sql = "SELECT * FROM $this->table";
        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => isset($this->get['page']) ? $this->get['page'] : 0,
            'link' => '/analysis/',
            'get_name' => 'page',
        );
        $rs = $this->func->getPagination($params);
        $rs['items'] = $this->db->fetch_all($rs['query']);
        foreach ($rs['items'] as &$i){
            $i['last_update'] = $this->DateFormat($i['last_update']);
        }

        $this->assign(array(
            'items'            => $rs['items'],
            'num_pages'        => $rs['num_pages'],
            'pagination'       => $rs['pagination'],
            'total'            => $rs['total'],
            'start'            => $rs['start'],
            'error'            => $rs['error'],
            'sql'              => $rs['sql'],
        ));
        $this->SetPath('/analysis/list/');
        $this->content = $this->SetTemplate('default.tpl');
    }
    public function ShowItem(){
        if ($item = $this->GetItem($this->query[0])){;
            $this->page_title = "Анализ страницы " . $item['url'];
            if ($item['content'] !==''){
                if (time() - $item['last_update'] > 60*60*24){
                    $upd = true;
                } else {
                    $upd = false;
                }

                $item['last_update'] = $this->DateFormat($item['last_update']);
                $rs = json_decode($item['content']);
                $this->assign(array(
                    'item' => $rs,
                    'last_update' => $item['last_update'],
                    'upd' => $upd,
                    'id' => $item['id'],
                ));
                $this->meta_description = isset($rs->meta_description[0]->content) ? $rs->meta_description[0]->content : '';
                $this->meta_keywords = isset($rs->meta_keywords[0]->content) ? $rs->meta_keywords[0]->content : '';
            }
            if ($this->meta_title == ''){
                $this->meta_title = $this->page_title . '. Анализ сайтов. '. $this->config->SiteTitle;
            }

        }
        //var_dump($rs);
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