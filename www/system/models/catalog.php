<?php

class ModelCatalog extends Model {
    public $table;
    public $table2;
    public $table3;
    public $table4;
    public $table5;
    public $table6;
    public $alias;
    public function __construct() {
        parent::__construct();
        $config = include CONTROLLERS_DIR . '/catalog/init.php';
        $this->table = db_pref . $config['table'];
        $this->table2 = db_pref . $config['table2'];
        $this->table3 = db_pref . $config['table3'];
        $this->table4 = db_pref . $config['table4'];
        $this->table5 = db_pref . $config['table5'];
        $this->table6 = db_pref . $config['table6'];
        $this->alias = $config['alias'];
    }
    function CheckAliasCategory($alias, $id){
        $par = array('table' => $this->table, 'field' => 'alias');
        if ($id > 0){
            $par['id'] = $id;
        }
        return $this->func->CheckAlias($alias, $par);
    }
    function CheckAliasItem($alias, $id){
        $par = array('table' => $this->table2, 'field' => 'alias');
        if ($id > 0){
            $par['id'] = $id;
        }
        return $this->func->CheckAlias($alias, $par);
    }
    function SaveCategory($params, $id = 0){
        $error = false;
        $alias = ($params['alias'] !=='') ? $params['alias'] : $this->func->TranslitURL($params['title']);
        $param = array(
            'parent_id' => (int)$params['parent_id'],
            'alias' => $alias,
            'title' => $params['title'],
            'desc1' => $params['desc1'],
            'desc2' => $params['desc2'],
            'position'  => is_int($params['position']) ? $params['position'] : 0,
            'meta_title' => $params['meta_title'],
            'meta_desc' => $params['meta_desc'],
            'meta_keywords' => $params['meta_keywords'],
            'public' => (int)$params['public'],
            'comments' => (int)$params['comments'],
            'template' => $params['template'],
            'user_id' => $this->session['admin']['id'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        );
        $upload_path = UPLOAD_IMAGES_DIR . $this->alias . '/';
        $old_img = $upload_path . $this->post['old_image'];
        $image = Func::getInstance()->UploadFile($_FILES["image"]['name'],$_FILES["image"]['tmp_name'], $upload_path);
        if ($this->post['delete_image']) {
            $param['image'] = '';
            if (file_exists($old_img) && file_exists($old_img)){
                unlink($old_img);
            }
        }
        if ($image !== false){
            $param['image'] = $image;
            if (!is_dir($old_img) && file_exists($old_img)){  // если есть новое изображение, то удаляем прежнее
                unlink($old_img);
            }
        }
        $alias_info = $this->CheckAliasCategory($alias, $id);
        if ($alias_info === 0){
            if ($id == 0){
                $param['date_create'] = time();
                $param['date_edit'] = time();
                if ($this->db->insert($this->table, $param, true)){
                    $id = $this->db->last_id();
                }
            } else {
                $this->db->update($this->table, $param, "id = $id");
            }
        } else {
            $error = $alias_info;
        }
        if ($this->db->error() !== ''){
            $error = $this->db->error();
        }
        $rs = array('id' => $id, 'error' => $error);
        return $rs;
    }
    public function GetCategoryOnly($id, $params = array()){
        $sql = "SELECT * FROM $this->table WHERE ";
        if (is_numeric($id)){
            $sql .= "id = $id";
        } else {
            $sql .= "alias = '$id'";
        }
        if (isset($params['public'])){
            $sql .= "AND public = 1";
        }
        $row = $this->db->select($sql, array('single' => true));
        $row['date_create'] = $this->func->DateFormat($row["date_create"]);
        $row['date_edit'] = $this->func->DateFormat($row["date_edit"]);
        return $row;
    }
    function GetCategories($params = array()){
        $result = false;
        $sort = isset($params['sort']) ? $params['sort'] : 'id DESC';
        $where = isset($params['where']) ? $params['where'] : "";
        $sql = "SELECT * FROM $this->table $where ORDER BY $sort";
        if ($list = $this->db->select($sql)){
            foreach ($list as $l) {
                $l['date_create'] = $this->func->DateFormat($l["date_create"]);
                $l['date_edit'] = $this->func->DateFormat($l["date_edit"]);
                $result[] = $l;
            }
        }
        return $result;
    }
    public function RemoveCategory($id){
        $category = $this->GetCategoryOnly($id);
        $img = UPLOAD_IMAGES_DIR . $this->alias . '/' .$category['image'];
        if (!is_dir($img) && file_exists($img)){
            unlink($img);
        }
        $sql = "DELETE FROM $this->table WHERE id = $id";
        $rs = $this->db->query($sql);
        $sql = "DELETE FROM $this->table3 WHERE category_id = $id";
        $rs = $this->db->query($sql);
        return $rs;
    }

    public function GetCategoryMaterials($category_id = -1){
        if ($category_id > 0){
            $sql = "SELECT i.* FROM $this->table2 i 
            LEFT JOIN $this->table3 p ON p.material_id = i.id
            WHERE p.category_id = $category_id";
        } elseif ($category_id == -1){
            $sql = "SELECT * FROM $this->table2";
        } elseif ($category_id == 0){
            $sql = "SELECT i.* FROM $this->table2 i 
            LEFT JOIN $this->table3 p ON p.material_id = i.id
            WHERE p.material_id is NULL";
        }
        $sql .= " ORDER BY id DESC";
        $params = array(
            'sql' => $sql,
            'per_page' => 20,
            'current_page' => isset($this->get['page']) ? $this->get['page'] : 0,
            'link' => '?c=' . $this->alias . '&category_id=' . $category_id,
            'get_name' => 'page',
        );
        $result = $this->func->getPagination($params);
        return $result;
    }

    function SaveItem($params, $id = 0){
        $error = false;
        $alias = ($params['alias'] !=='') ? $params['alias'] : $this->func->TranslitURL($params['title']);
        $param = array(
            'alias' => $alias,
            'title' => $params['title'],
            'short_content' => $params['short_content'],
            'content' => $params['content'],
            'position'  => is_int($params['position']) ? $params['position'] : 0,
            'meta_title' => $params['meta_title'],
            'meta_desc' => $params['meta_description'],
            'meta_keywords' => $params['meta_keywords'],
            'public' => (int)$params['public'],
            'comments' => (int)$params['comments'],
            'template' => $params['template'],
            'user_id' => $this->session['admin']['id'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'price' => $params['price'] ? $params['price'] : 0,
            'price_new' => $params['price_new'] ? $params['price_new'] : 0,
            'views' => $params['views'] ? $params['views'] : 0,
        );
        $alias_info = $this->CheckAliasItem($alias, $id);
        if ($alias_info === 0){
            if ($id == 0){
                $param['date_publ'] = time();
                $param['date_edit'] = time();
                if ($this->db->insert($this->table2, $param, true)){
                    $id = $this->db->last_id();
                }
            } else {
                $this->db->update($this->table2, $param, "id = $id");
            }
            if (count($params['parents']) > 0){
                $sql = "DELETE FROM $this->table3 WHERE material_id = $id";
                $this->db->query($sql);
                foreach ($params['parents'] as $p){
                    $param = array('category_id' => $p, "material_id" => $id);
                    $this->db->insert($this->table3, $param);
                }
            }
            if (trim($params['tags']) !== ''){
                if ($tags = explode(',', $params['tags'])){
                    $sql = "DELETE FROM $this->table5 WHERE material_id = $id";
                    $this->db->query($sql);
                    foreach ($tags as $t){
                        $t = trim($t);
                        if ($t !== ''){
                            $param = array(
                                'module' => $this->alias,
                                'material_id' => $id,
                                'name' => $t,
                            );
                            $this->db->insert($this->table5, $param);
                        }
                    }
                }
            }
        } else {
            $error = $alias_info;
        }
        if ($this->db->error() !== ''){
            $error = $this->db->error();
        }
        $rs = array('id' => $id, 'error' => $error);
        return $rs;
    }

    public function GetItem($id){
        $sql = "SELECT i.*, img.name AS img_name FROM $this->table2 i 
                LEFT JOIN $this->table4 img ON img.id = i.skin
                WHERE ";
        if (is_numeric($id)){
            $sql .= "i.id = $id";
        } else {
            $sql .= "i.alias = '$id'";
        }
        if ($row = $this->db->select($sql, array('single' => true))) {
            $row['date_publ'] = $this->func->DateFormat2($row["date_publ"]);
            $row['date_edit'] = $this->func->DateFormat2($row["date_edit"]);
            $sql = "SELECT p.*, c.* FROM $this->table3 p
            LEFT JOIN $this->table c ON c.ID = p.category_id 
            WHERE p.material_id = " . $row['id'];
            if ($parents = $this->db->select($sql)) {
                $row['parents'] = $parents;
            }
            $sql = "SELECT * FROM $this->table4 WHERE module = '$this->alias' AND material_id = " . $row['id'];
            $row['images'] = $this->db->select($sql);
            $sql = "SELECT * FROM $this->table5 WHERE module = '$this->alias' AND material_id = " . $row['id'];
            $row['tags'] = $this->db->select($sql);
            $sql = "SELECT * FROM $this->table6 WHERE module = '$this->alias' AND material_id = " . $row['id'];
            $row['files'] = $this->db->select($sql);
        }
        return $row;
    }
    public function RemoveItem($id){
        if ($item = $this->GetItem($id)){
            // Удаляем файлы
            if (count($item['files']) > 0){
                $path = UPLOAD_FILES_DIR . $this->alias . "/";
                foreach ($item['files'] as $f){
                    if (is_file($path . $f['name'])){
                        unlink($path . $f['name']);
                    }
                }
            }
            if (count($item['images']) > 0){
                // Удаляем изображения
                $path = UPLOAD_IMAGES_DIR . $this->alias . "/";
                foreach ($item['images'] as $f){
                    if (is_file($path . $f['name'])){
                        unlink($path . $f['name']);
                    }
                }
            }
        }
        $sql = "DELETE FROM $this->table2 WHERE id = $id";
        $rs = $this->db->query($sql);
        $sql = "DELETE FROM $this->table3 WHERE material_id = $id";
        $rs = $this->db->query($sql);

        // Удаляем данные изображений из таблицы
        $sql = "DELETE FROM $this->table4 WHERE material_id = $id";
        $rs = $this->db->query($sql);
        // Удаляем данные файлов из таблицы
        $sql = "DELETE FROM $this->table5 WHERE material_id = $id";
        $rs = $this->db->query($sql);
        // Удаляем теги
        $sql = "DELETE FROM $this->table6 WHERE material_id = $id";
        $rs = $this->db->query($sql);
        return $rs;
    }
    public function UploadImages($material_id){
        $upload_path = UPLOAD_IMAGES_DIR . $this->alias . '/';
        $done_files = array();
        if ($material_id > 0){
            foreach($_FILES as $file ){
                $image = Func::getInstance()->UploadFile($file['name'], $file['tmp_name'], $upload_path);
                $params = array(
                    'module' => $this->alias,
                    'material_id' => $material_id,
                    'name' => $image,
                );
                $this->db->insert($this->table4, $params);
                $done_files[] = array('id' => $this->db->last_id(), 'img' => $image) ;
            }
        }
        $error = $this->db->error();
        return array('files' => $done_files , 'error' => $error);
    }
    public function RemoveImageItem($id){
        $sql = "DELETE FROM $this->table4 WHERE id = $id";
        if ($this->db->query($sql)){
            $rs = true;
        } else {
            $rs = $this->db->error();
        }
        return $rs;
    }
    public function SetSkinItem($material_id, $id){
        $sql = "UPDATE $this->table2 SET skin = $id WHERE id = $material_id";
        if ($this->db->query($sql)){
            $rs = true;
        } else {
            $rs = $this->db->error();
        }
        return $rs;
    }
    public function SetViews($id, $plus){
        $sql = "UPDATE $this->table2 SET views = views + $plus WHERE id = $id";
        $result = $this->db->query($sql);
        if ($this->db->error() != ''){
            $error = $this->db->error();
        }
        return array('error' => $error);
    }
    public function CategoryExists($categories, $alias){
        $rs = false;
        foreach ($categories as $c){
            if ($c['alias'] == $alias){
                $rs = $c;
                break;
            }
        }
        return $rs;
    }
    public function GetItems($params = array()){
        $rs = false;
        $category_id = $params['category_id'];
        $sort = $params['sort'] ? $params['sort']: "id DESC";
        $sql = "SELECT i.*, img.name AS img_name FROM $this->table3 p 
                LEFT JOIN $this->table2 i ON i.id = p.material_id
                LEFT JOIN $this->table4 img ON img.id = i.skin
                WHERE p.category_id = $category_id AND i.id IS NOT NULL ORDER BY $sort";
        if ($items = $this->db->select($sql)){
            foreach ($items as &$i){
                $i['date_publ'] = $this->func->DateFormat2($i['date_publ']);
                $i['date_edit'] = $this->func->DateFormat2($i['date_edit']);
            }
            $rs = $items;
        }
        return $rs;
    }

    public function GetOthersFromParents($parents, $current_id){
        $where = array();
        foreach ($parents as $p){
            $where[] = 'p.category_id = ' . $p['id'];
        }
        $where = "WHERE (" . implode(' OR ', $where) . ") AND i.id IS NOT NULL AND i.id <> $current_id";
        $sql = "SELECT i.* FROM $this->table3 p
                    LEFT JOIN $this->table2 i ON i.id = p.material_id
                $where LIMIT 10";
        $items = $this->db->select($sql);
        return $items;
    }

}
?>