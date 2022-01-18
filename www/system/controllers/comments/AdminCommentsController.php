<?php

class AdminCommentsController extends AdminController {
    public $table;
    public function __construct() {
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

    public function SetPlugins(){
        $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.min.js';
        $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.rfm.js';
        $this->css[]  = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.css';
    }

    public function ShowMenu(){
        $sql = "SELECT DISTINCT module FROM $this->table";
        if ($items = $this->db->select($sql)){
            foreach ($items as $i){
                $controllers[] = array(
                    'controller' => $i['module'],
                    'name'       => $this->getModuleName($i['module']),
                );
            }
        }
        $this->assign(array(
            'controllers' =>$controllers,
        ));
        $this->widget_left_top .=$this->fetch('menu.tpl');
    }

    public function getModuleName($controller){
        $r = '';
        foreach ($this->modules as $m){
            if ($m['alias'] == $controller){
                $r = $m['name'];
                break;
            }
        }
        return $r;
    }

    public function ShowItems(){
        $comments = array();
        $where = false;
        $url = '';
        if (isset($this->get['module'])){
            $where[] = "module='" . $this->get['module'] . "'";
            $url .= "&module=" . $this->get['module'];
        }
        $sql = "SELECT *  FROM $this->table";
        if ($where !== false){
            $sql .= " WHERE " . implode(" AND ", $where);

        }
        $sql .= " ORDER BY date_publ DESC";
        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => $this->get['page'],
            'link' => '?c=comments' . $url,
            'get_name' => 'page',
        );
        $result = $this->func->getPagination($params);
        $query = $result['query'];
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $row["date_publ"] = $this->DateFormat($row["date_publ"]);
                $row["module_name"] =  $this->getModuleName($row["module"]);
                $comments[] = $row;
            }
        };
        $this->assign(array(
            'comments'        =>$comments,
            'items_count'     => count($comments),
            'total'           => $result['total'],
            'start'           => $result['start'],
            'pagination'      => $result['pagination'],
        ));
        $this->content = $this->SetTemplate('comments.tpl');
    }
    public function ShowItem(){
        $sql = "SELECT * FROM $this->table WHERE id = " . $this->get['id'] . " LIMIT 1";
        if ($item = $this->db->select($sql, array('single' => true))){
            $item["date_publ"] = $this->DateFormat($item["date_publ"]);
            $this->assign(array(
                'item' =>$item,
            ));
        }
        $this->content = $this->SetTemplate('comment.tpl');
    }
    public function SaveItem(){
        $params = array(
            'date_publ' => strtotime($this->post['date']),
            'user_name' => $this->post['name'],
            'user_email' => $this->post['email'],
            'user_comment' => $this->post['comment'],
        );
        $this->db->update($this->table, $params, 'id = ' . $this->get['id']);
        $_SESSION['alert'] = 'Комментарий обновлен';
        $this->Head("?c=comments");
    }

    public function SetStatus(){
        $status = $this->get['status'];
        $sql = "UPDATE $this->table SET status = $status WHERE id = " . $this->get['id'];
        $this->db->query($sql);
        $_SESSION['alert'] = 'Статус изменен';
        $this->Head("?c=comments");
    }

    public function RemoveItem(){
        $sql = "DELETE FROM $this->table WHERE id = " . $this->get['id'];
        $this->db->query($sql);
        $_SESSION['alert'] = 'Комментарий удален';
        $this->Head("?c=comments");
    }

    public function Index(){
        //$this->SetPlugins();
        $this->ShowMenu();
        $this->page_title = 'Комментарии';
        if (isset($this->post['save-comment'])){
            $this->SaveItem();
        }
        if (isset($this->get['action']) && $this->get['action'] == 'remove'){
            $this->RemoveItem();
        }
        if (isset($this->get['status'])){
            $this->SetStatus();
        }

        if (isset($this->get['id'])){
            $this->ShowItem();
        }
        else {
            $this->ShowItems();
        }

        return $this->content;
    }
}
?>