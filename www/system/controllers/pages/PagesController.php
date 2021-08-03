<?php
class PagesController extends Controller
{
    public function __construct($query, $controller)
    {
        //parent::__construct($query, $controller);
        $this->table_name = '`' . db_pref . 'pages`';
        $this->module_alias = 'pages';
    }

    public function Index(){
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        echo $url;
    }
}

?>