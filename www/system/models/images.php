<?php

class ModelImages extends Model {
    public $table;
    public function __construct() {
        parent::__construct();
        $config = include CONTROLLERS_DIR . '/images/init.php';
        $this->table = db_pref . $config['table'];
    }

    public function UploadImages(){
        $module = $this->post['module'];
        $id = $this->post['id'];
        $upload_path = UPLOAD_IMAGES_DIR . $module . '/';
        $rs = array();
        if ($id > 0){
            foreach($_FILES as $file ){
                $image = Func::getInstance()->UploadFile($file['name'], $file['tmp_name'], $upload_path);
                $params = array(
                    'module' => $module,
                    'material_id' => $id,
                    'name' => $image,
                );
                $this->db->insert($this->table, $params);
                $params['error'] = $this->db->error();
                $rs[] = $params;
            }
        }
        return $rs;
    }
}
?>