<?php

class AdminFilesController extends AdminController {
    private $table;
    public function __construct() {
        parent::__construct();
        $this->table = db_pref . 'files';
    }

    public function UploadFiles(){
        $html = '';
        $module = $this->post['module'];
        $id = $this->post['id'];
        $upload_path = UPLOAD_FILES_DIR . $module . '/';
        if ($id > 0){
            foreach($_FILES as $file ){
                $file_name = Func::getInstance()->UploadFile($file['name'], $file['tmp_name'], $upload_path);
                $params = array(
                    'module' => $module,
                    'material_id' => $id,
                    'name' => $file_name,
                    'desc' => $file['name'],
                );
                $this->db->insert($this->table, $params);
                $this->assign(array(
                    'file_name' => $file_name,
                    'file_id' => $this->db->last_id(),
                    'module_config' => array('alias' => $module),
                    'desc' => $file['name'],
                ));
                $this->smarty->template_dir = CONTROLLERS_DIR . $module . '/tpl/';
                $html .= $this->fetch( 'file.tpl');
                $done_files[] = array('id' => $this->db->last_id(), 'file' => $file_name, 'desc' => $file['name']) ;
            }
        }

        $data = array('files' => $done_files, 'html' => $html, 'error' => $this->db->error());
        die( json_encode( $data ) );
    }

    public function RemoveFile(){
        $sql = "SELECT * FROM $this->table WHERE id = " . $this->post['id'] . ' LIMIT 1';
        $file = $this->db->select($sql, array('single' => true));
        $file = UPLOAD_FILES_DIR . $this->post['module'] . '/' . $file['name'];
        if (file_exists($file)){
            unlink($file);
        }
        $sql = "DELETE FROM $this->table WHERE id = " . $this->post['id'];
        if ($this->db->query($sql)){
            $rs = true;
        } else {
            $rs = $this->db->error();
        }
        die($rs);
    }

    public function Index(){
        if (isset($this->post['action']) && $this->post['action'] == "files-upload"){
            $this->UploadFiles();
        }
        if (isset($this->post['action']) && $this->post['action'] == "remove-file"){
            $this->RemoveFile();
        }
    }
}
?>