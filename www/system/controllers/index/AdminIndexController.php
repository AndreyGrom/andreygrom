<?php

class AdminIndexController extends AdminController {
    public function __construct() {
        parent::__construct();
        $this->pages = array();
        $this->pages_count = 0;
        $this->pages_last_count = 10;
        $this->catalog = array();
        $this->catalog_count = 0;
        $this->catalog_last_count = 10;
        $this->comments = array();
        $this->comments_count = 0;
        $this->comments_last_count = 10;
        $this->codes = array();
        $this->codes_count = 0;
        $this->codes_last_count = 10;
    }

    public function getPages(){
        $sql = "SELECT * FROM  `".db_pref."pages` ORDER BY `DATE_EDIT` DESC";
        $query = $this->db->query($sql);
        $this->pages_count = $this->db->num_rows($query);
        for ($i=0; $i < $this->pages_last_count-1; $i++) {
            if ($row = $this->db->fetch_array($query)){
                $row['DATE_PUBL'] = $this->DateFormat($row["DATE_PUBL"]);
                $row['DATE_EDIT'] = $this->DateFormat($row["DATE_EDIT"]);
                $this->pages[] = $row;
            }
        }
    }
    public function getCatalog(){
        $sql = "SELECT * FROM  `".db_pref."catalog_i` ORDER BY `DATE_EDIT` DESC";
        $query = $this->db->query($sql);
        $this->catalog_count = $this->db->num_rows($query);
        for ($i=0; $i < $this->catalog_last_count-1; $i++) {
            if ($row = $this->db->fetch_array($query)){
                $row['DATE_PUBL'] = $this->DateFormat($row["DATE_PUBL"]);
                $row['DATE_EDIT'] = $this->DateFormat($row["DATE_EDIT"]);
                $this->catalog[] = $row;
            }
        }
    }
    public function getComments(){
        $sql = "SELECT * FROM  `".db_pref."comments` ORDER BY `DATE_PUBL` DESC";
        $query = $this->db->query($sql);
        $this->comments_count = $this->db->num_rows($query);
        for ($i=0; $i < $this->comments_last_count-1; $i++) {
            if ($row = $this->db->fetch_array($query)){
                $row['DATE_PUBL'] = $this->DateFormat($row["DATE_PUBL"]);
                $this->comments[] = $row;
            }
        }
    }
    public function getCodes(){
        $sql = "SELECT * FROM  `".db_pref."codes` ORDER BY `DATE_EDIT` DESC";
        $query = $this->db->query($sql);
        $this->codes_count = $this->db->num_rows($query);
        for ($i=0; $i < $this->codes_last_count-1; $i++) {
            if ($row = $this->db->fetch_array($query)){
                $row['DATE_PUBL'] = $this->DateFormat($row["DATE_PUBL"]);
                $row['DATE_EDIT'] = $this->DateFormat($row["DATE_EDIT"]);
                $this->codes[] = $row;
            }

        }
    }
    public function Index(){
        $this->page_title = 'AG CMS';
        $this->getPages();
        $this->getCatalog();
        $this->getComments();
        $this->getCodes();
        $this->assign(array(
            'page_count'            => $this->pages_count,
            'pages'                 => $this->pages,
            'catalog_count'         => $this->catalog_count,
            'catalog'               => $this->catalog,
            'comments_count'        => $this->comments_count,
            'comments'              => $this->comments,
            'codes_count'           => $this->codes_count,
            'codes'                 => $this->codes,
        ));
        $this->content = $this->SetTemplate('index.tpl');
        return $this->content;
    }
}
?>