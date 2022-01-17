<?php

class CommentsController extends Controller {
    public $material_id;
    public $premoderation;
    public $tpl_view;
    public $tpl_form;
    public $strip_tags;
    public $table;
    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $this->tpl_view = 'default.tpl';
        $this->tpl_form = 'default.tpl';
        $this->material_id = 0;
        $this->premoderation = 1;
        $this->strip_tags = '<a><b><i><u><p><h1><h2><h3><h4><h5><h6><ul><li><div>';
        $this->table = db_pref . 'comments';
    }
    public function AddComment(){
        $error = false;
        $status = false;
        if ($this->post["username"] !== '' || $this->post["useremail"] !== ''){
            $error = 'Ваши действия похожи на робота. Комментарий не добавлен';
        }
        if ($error === false){
            $params = array(
                'controller' => $this->controller,
                'material_id' => $this->material_id,
                'date_publ' => time(),
                'user_name' => $this->post["name"],
                'user_email' => $this->post["email"],
                //'user_id' => ,
                'user_comment' => strip_tags($this->post["comment"], $this->strip_tags),
                'parent_id' => $this->post["comment-parent"],
                'ip' => $_SERVER['REMOTE_ADDR'],
                'status' => $this->premoderation ? 0 : 1,
            );
            $this->db->insert($this->table, $params);
            if ($this->db->error() !== ''){
                $error = $this->db->error();
            } else {
                if ($this->premoderation){
                    $status = 'Ваш комментарий отправлен на проверку';
                } else {
                    $status = '1';
                }
            }
        }
        $rs = array('status' => $status, 'error' => $error, 'parent' => $this->post["comment-parent"]);
        die(json_encode($rs));
    }

    public function GetComments(){
        $items = false;
        if ($this->material_id > 0){
            $sql = "SELECT * FROM $this->table WHERE controller = '$this->controller' AND material_id = '$this->material_id' AND status = 1 ORDER BY date_publ DESC";
            if ($items = $this->db->select($sql)){
                foreach ($items as &$i){
                    $i["date_publ"] = $this->DateFormat($i["date_publ"]);
                }
            }
        }
        return $items;
    }

    public function ShowComments(){
        $comments = $this->GetComments();
        $this->SetPath('comments/');
        $this->AssingCommonVars();
        $this->SetPath('comments/form/');
        $comments_form = $this->fetch($this->tpl_form);
        $structure = Func::getInstance()->getStructure($comments);

        $this->smarty->assign(array(
            'comments'  => $structure,
            'tpl_name'  => $this->tpl_view,
        ));
        $this->SetPath('comments/view/');
        $comments = $this->fetch($this->tpl_view);

        $this->comments_form = $comments_form;
        $this->comments = $comments;
    }

    public function Index(){
        if (isset($this->post['action']) && $this->post['action'] == 'add-comment'){
            $this->AddComment();
        }

        $this->ShowComments();
    }
}