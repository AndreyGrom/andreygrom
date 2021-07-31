<?php

class AdminManager {
    public function __construct() {
        if (!isset($_SESSION['admin'])){
            $_GET['c'] = 'login';
        }
        if (isset($_GET['c']) && $_GET['c']!==''){
            $this->controller = $_GET['c'];
        } else {
            $this->Head('?c=index');
        }
    }
    public function getContent(){
        $ControllerFile = CONTROLLERS_DIR.$this->controller.'/Admin'.mb_convert_case($this->controller, MB_CASE_TITLE, "UTF-8").'Controller.php';
        $content = '';
        if (file_exists($ControllerFile)){
            include_once($ControllerFile);
            $class_name ='Admin'.mb_convert_case($this->controller, MB_CASE_TITLE, "UTF-8").'Controller';
            $class = new $class_name();
            $content = $class->Index();
        }

        if ($content !== ''){
            echo $content;
        } else{
            $this->Head('/error404');
        }

    }

    public function Head($url, $anch=''){
        if ($anch!==''){
            $url.='#'.$anch;
        }
        header("Location: ".$url);
        exit;
    }





}
?>