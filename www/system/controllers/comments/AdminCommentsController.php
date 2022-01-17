<?php

class AdminCommentsController extends AdminController {
    public function __construct() {
        parent::__construct();
        $this->categories    = array();
        $this->structure     = array();
        $this->id            = $this->get['id'];
        $this->cid           = $this->get['cid'];
        $this->act           = $this->get['act'];
        $this->filter        = $this->get['filter'];
        $this->per_page      = 20;
        $this->start         = 0;
        $this->num_pages     = 1;
    }

    public function SetPlugins(){
        $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.min.js';
        $this->js[]   = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.rfm.js';
        $this->css[]  = HTML_PLUGINS_DIR.'cleeditor/jquery.cleditor.css';
    }

    public function ShowMenu(){
        $sql = "SELECT DISTINCT `CONTROLLER` FROM `".db_pref."comments`";
        $query = $this->db->query($sql);
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $controllers[] = array(
                    'controller' => $row['CONTROLLER'],
                    'name'       => $this->getModuleName($row['CONTROLLER']),
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

/*    public function getPagination($filer = false){
        $where = '';
        if ($filer){
            $where = "WHERE `CONTROLLER`='$filer'";
        }
        $sql = "SELECT *  FROM `".db_pref."comments` $where";
        $query = $this->db->query($sql);
        $total = $this->db->num_rows($query);
        $this->num_pages = ceil($total / $this->per_page);
        $this->total = $total;
        $cur_page = 1;
        if (isset($_GET['p']) && $_GET['p'] > 0) {
            $cur_page = $_GET['p'];
        }
        $this->start = ($cur_page - 1) * $this->per_page;
    }*/

    public function getItems($filer = false,$start, $count){
        $comments = array();

        $url = '';
        if ($filer){
            $where = "WHERE `CONTROLLER`='$filer'";
            $url = "&filter=$filer";
        }
        $sql = "SELECT *  FROM `".db_pref."comments` $where ORDER BY `DATE_PUBL` DESC";

        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => $this->get['page'],
            'link' => '?c=comments'.$url,
            'get_name' => 'page',
        );
        $result = $this->getPagination($params);
        $query = $result['query'];
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $row["DATE_PUBL"] = $this->DateFormat($row["DATE_PUBL"]);
                $row["MODULE_NAME"] =  $this->getModuleName($row["CONTROLLER"]);
                $comments[] = $row;
            }
        }
        return $comments;
    }
    public function ShowItems(){
        $comments = array();
        $filer = $this->filter;
        $url = '';
        if ($filer){
            $where = "WHERE `CONTROLLER`='$filer'";
            $url = "&filter=$filer";
        }
        $sql = "SELECT *  FROM `".db_pref."comments` $where ORDER BY `DATE_PUBL` DESC";

        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => $this->get['page'],
            'link' => '?c=comments'.$url,
            'get_name' => 'page',
        );
        $result = $this->getPagination($params);
        $query = $result['query'];
        if ($this->db->num_rows($query) > 0){
            for ($i=0; $i < $this->db->num_rows($query); $i++) {
                $row = $this->db->fetch_array($query);
                $row["DATE_PUBL"] = $this->DateFormat($row["DATE_PUBL"]);
                $row["MODULE_NAME"] =  $this->getModuleName($row["CONTROLLER"]);
                $comments[] = $row;
            }
        }
        $num_pages = $result['num_pages'];
        $pagination = $result['pagination'];
        $total = $result['total'];
        $start = $result['start'];
        $this->assign(array(
            'comments'        =>$comments,
            'filter'          =>$this->filter,
            'num_pages'       => $this->num_pages,
            'items_count'     => count($comments),
            'total'           => $total,
            'start'           => $start,
            'pagination'      => $pagination,
        ));
        $this->content = $this->SetTemplate('comments.tpl');
    }

    public function Index(){
        $this->SetPlugins();
        $this->ShowMenu();
        $this->page_title = 'Комментарии';
        if (isset($_POST['comment'])){
            $date = strtotime($_POST['date']);
            $name = $_POST['name'];
            $email = $_POST['email'];
            $comment = $this->db->input($_POST['comment']);
            $sql = "UPDATE `".db_pref."comments` SET
    `DATE_PUBL` = '$date',
    `USER_NAME` = '$name',
    `USER_EMAIL` = '$email',
    `USER_COMMENT` = '$comment'
    WHERE `ID` = $this->id";
            $query = $this->db->query($sql);
            $this->Head("?c=comments&id=$this->id");
        }
        if (isset($_GET['status'])){
            $status = $_GET['status'];
            $sql = "UPDATE `".db_pref."comments` SET `STATUS` = '$status' WHERE `ID` = $this->id";
            $query = $this->db->query($sql);
            $this->Head("?c=comments");
        }

        if ($this->act == 'del'){
            $sql = "DELETE FROM `".db_pref."comments` WHERE `ID` = $this->id";
            $query = $this->db->query($sql);
            $this->Head("?c=comments");
        }

        if (isset($this->id)){
            $sql = "SELECT * FROM `".db_pref."comments` WHERE `ID` = $this->id";
            $query = $this->db->query($sql);
            $row = $this->db->fetch_array($query);
            $row["DATE_PUBL"] = $this->DateFormat($row["DATE_PUBL"]);
            $this->assign(array(
                'comment' =>$row,
            ));
            $this->content = $this->SetTemplate('comment.tpl');
        } else {
            $this->ShowItems();
        }

        return $this->content;
    }
}
?>