<?php

class AdminImagesController extends AdminController {
    private $table;
    private $alias;
    private $name;
    private $version;
    public function __construct() {
        parent::__construct();
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . 'images';
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
    public function UploadImages(){
        $html = '';
        $module = $this->post['module'];
        $id = $this->post['id'];
        $upload_path = UPLOAD_IMAGES_DIR . $module . '/';
        if ($id > 0){
            foreach($_FILES as $file ){
                $image = Func::getInstance()->UploadFile($file['name'], $file['tmp_name'], $upload_path);
                $params = array(
                    'module' => $module,
                    'material_id' => $id,
                    'name' => $image,
                );
                $this->db->insert($this->table, $params);
                $this->assign(array(
                    'img' => $image,
                    'img_id' => $this->db->last_id(),
                    'module_config' => array('alias' => $module),
                ));
                $this->smarty->template_dir = CONTROLLERS_DIR . $module . '/tpl/';
                $html .= $this->fetch( 'image.tpl');
                $done_files[] = array('id' => $this->db->last_id(), 'img' => $image) ;
            }
        }

        $data = array('files' => $done_files, 'html' => $html, 'error' => $this->db->error());
        die( json_encode( $data ) );
    }

    public function RemoveImage(){
        $sql = "SELECT * FROM $this->table WHERE id = " . $this->post['id'] . ' LIMIT 1';
        $img = $this->db->select($sql, array('single' => true));
        $img = UPLOAD_IMAGES_DIR . $this->post['module'] . '/' . $img['name'];
        if (file_exists($img)){
            unlink($img);
        }
        $sql = "DELETE FROM $this->table WHERE id = " . $this->post['id'];
        if ($this->db->query($sql)){
            $rs = true;
        } else {
            $rs = $this->db->error();
        }
        die($rs);
    }
    public function SetSkin(){
        $table = $this->post['table'];
        $img_id = $this->post['img_id'];
        $material_id = $this->post['material_id'];
        $sql = "UPDATE $table SET skin = $img_id WHERE id = $material_id";
        if ($this->db->query($sql)){
            $rs = true;
        } else {
            $rs = $this->db->error();
        }
        die($rs);
    }

    public function ShowIndex(){
        $sql = "SELECT * FROM $this->table";

        $this->content = $this->SetTemplate('index.tpl');
    }
    public function Index(){
        if (isset($this->post['action']) && $this->post['action'] == "images-upload"){
            $this->UploadImages();
        }
        if (isset($this->post['action']) && $this->post['action'] == "remove-image"){
            $this->RemoveImage();
        }
        if (isset($this->post['action']) && $this->post['action'] == "set-skin"){
            $this->SetSkin();
        }

        $this->ShowMenu();
        $this->ShowIndex();
        return $this->content;
    }
}
?>