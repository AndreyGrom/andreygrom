<?php

class AdminAnalysisController extends AdminController{
    private $table;
    public function __construct(){
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
    }
    public function ShowMenu(){

        $this->widget_left_top .= $this->fetch('menu.tpl');
    }
    public function ShowIndex(){
        $sql = "SELECT * FROM $this->table";
        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => isset($this->get['page']) ? $this->get['page'] : 0,
            'link' => '?c=analysis',
            'get_name' => 'page',
        );
        $rs = $this->func->getPagination($params);
        $rs['items'] = $this->db->fetch_all($rs['query']);
        foreach ($rs['items'] as &$r){
            $r['last_update'] = $this->DateFormat($r['last_update']);
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
        $this->content = $this->SetTemplate('index.tpl');
    }
    public function SiteExists($url){
        $sql = "SELECT * FROM $this->table WHERE url = '$url' LIMIT 1";
        return (count($this->db->select($sql)) > 0) ? true : false;
    }
    public function AddSites(){
        $rs = 0;
        $errors = array();
        if ($sites = explode("\n", $this->post['sites'])){
            foreach ($sites as $s){
                if (trim($s == '')) continue;
                if (!$this->SiteExists($s)){
                    $param = array(
                        'url' => $s,
                        'last_update' => time(),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'content' => '',
                        'headers' => '',
                    );
                    if ($this->db->insert($this->table, $param) !== false){
                        $rs ++;
                    }
                    if ($this->db->error() !== ''){
                        $errors[] = $this->db->error();
                    }
                }
            }
        }
        die(json_encode(array('errors'=>implode("\r\n <br>", $errors), 'count' => $rs)));
    }
    public function RemoveItem(){
        $sql = "DELETE FROM $this->table WHERE id = " . $this->get['id'];
        $rs = $this->db->query($sql);
        return $rs;
    }
    public function GetItem($id){
        $sql = "SELECT * FROM $this->table WHERE id = $id LIMIT 1";
        return $this->db->select($sql, array('single' => true));
    }
    public function DownloadSite(){
        include_once "../../classes/Analysis.class.php";
        $item = $this->GetItem($this->get['id']);
        $a = new Analysis();
        if ($a->GetPage($item['url'])){
            $param = array(
                'content' => $a->data,
                'headers' => $a->headers,
            );
            $this->db->update($this->table, $param, "url = '" . $item['url'] . "'");
            $this->Head('?c=analysis');
        }
    }
    public function Index(){
        if (isset($this->post['action']) && $this->post['action'] == 'add-sites'){
            $this->AddSites();
        }
        if (isset($this->get['action']) && $this->get['action'] == 'remove-site'){
            $this->RemoveItem();
        }
        if (isset($this->get['action']) && $this->get['action'] == 'download-site'){
            $this->DownloadSite();
        }
        $this->ShowMenu();
        $this->ShowIndex();

        return $this->content;
    }
}