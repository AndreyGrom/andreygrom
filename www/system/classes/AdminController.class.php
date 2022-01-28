<?php

class AdminController {
    public $get;
    public $post;
    public $session;
    public $controller;
    public $db;
    public $config;
    public $smarty;
    public $modules;
    public $themes;
    public $func;
    public $templates_dir;
    public $admin_templates_dir;
    public $alert;
    public $lang;
    public $content;
    public $js;
    public $css;
    public $widget_head_top;
    public $widget_head_bottom;
    public $widget_left_top;
    public $widget_left_bottom;
    public $widget_content_top;
    public $widget_content_bottom;
    public $widget_footer_top;
    public $page_title;
    public $site_url;
    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->session = $_SESSION;
        $this->controller = $this->get['c'];
        $this->db = Database::getInstance();
        $this->config = Config::getInstance()->get();
        $this->smarty = Smart::getInstance();
        $this->modules = $this->GetModules();
        $this->themes = $this->GetThemes();
        $this->func = Func::getInstance();
        $this->templates_dir = TEMPLATES_DIR . $this->config->Theme . '/tpl/';
        $this->admin_templates_dir = CONTROLLERS_DIR . $this->controller . '/tpl/';
        $this->smarty->template_dir = $this->admin_templates_dir;
        if (isset($_SESSION['alert'])){
            $this->alert = $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
        $this->lang = 'ru';
        $this->js = array();
        $this->css = array();
        $this->widget_head_top = '';
        $this->widget_head_bottom = '';
        $this->widget_left_top = '';
        $this->widget_left_bottom = '';
        $this->widget_content_top = '';
        $this->widget_content_bottom = '';
        $this->widget_footer_top = '';
        $this->page_title = '';
        $this->site_url = $this->GetSiteUrl();
    }

    public function LoadModel($model){
        $file = MODELS_DIR . $model .'.php';
        $model = mb_convert_case($model, MB_CASE_TITLE, "UTF-8");
        if (file_exists($file) && !is_dir($file)){
            include_once ($file);
            $class_name = 'Model'. $model;
            $method_name = 'Model' . $model;
            $this->$method_name = new $class_name();
        }
    }

    // TODO перенести в функции
    public function GetSiteUrl(){
        if( isset($_SERVER['HTTPS'] ) ) {
            $proto = 'https://';
        } else {
            $proto = 'http://';
        }
        return $proto.$_SERVER['SERVER_NAME'].'/';
    }


    public function AssingCommonVars(){
        $this->smarty->assign(array(
            'js'                       => $this->getJs(),
            'css'                      => $this->getCss(),
            'lang'                     => $this->lang,
            'content'                  => $this->content,
            'alert'                    => $this->alert,
            'widget_head_top'          => $this->widget_head_top,
            'widget_head_bottom'       => $this->widget_head_bottom,
            'widget_left_top'          => $this->widget_left_top,
            'widget_left_bottom'       => $this->widget_left_bottom,
            'widget_content_top'       => $this->widget_content_top,
            'widget_content_bottom'    => $this->widget_content_bottom,
            'widget_footer_top'        => $this->widget_footer_top,
            'title'                    => $this->page_title,
            'modules'                  => $this->modules,
            'themes'                   => $this->themes,
            'site_url'                 => $this->site_url,
            'upload_images_dir'        => UPLOAD_IMAGES_DIR,
            'upload_files_dir'         => UPLOAD_FILES_DIR,
            'cache_images'             => CACHE_IMAGES,
            'module_name'              => $_GET['c'],
            'config'                   => $this->config,
            'html_plugins_dir'         => HTML_PLUGINS_DIR,
            'html_controllers_dir'     => HTML_CONTROLLERS_DIR,
            'html_classes_dir'         => HTML_CLASSES_DIR,
        ));
    }

    public function assign($arr){
        $this->smarty->assign($arr);
    }

    public function SetTemplate($tpl){
        $this->AssingCommonVars();
        $result = $this->smarty->fetch($tpl);
        $this->smarty->assign(array(
            'content' => $result,
        ));
        $this->smarty->template_dir = SYSTEM_DIR . 'design/';
        $result = $this->smarty->fetch('index.tpl');
        // TODO подумать
        /*$result = str_replace('</head>', $this->getCss()."\r\n</head>",$result);
        $result = str_replace('</body>', $this->getJs()."\r\n</body>",$result);*/
        return $result;
    }

    public function display($temp=''){
        $this->smarty->display($temp);
    }

    public function fetch($temp=''){
        return $this->smarty->fetch($temp);
    }

    public function SetPath($path){
        $this->smarty->template_dir = $this->admin_templates_dir . $path;
    }

    public function getJs(){
        $r = '';
        if (count($this->js) > 0){
            foreach ($this->js as $val){
                if (trim($val)!==''){
                    $r .= '<script type="text/javascript" src="'.$val.'"></script>'."\r\n";
                }
            }
        }
        return $r;
    }

    public function SetJS($js){
        $b = true;
        if (count($this->js) > 0){
            foreach ($this->js as  $j){
                if (trim($js) == $j)  {
                    $b = false;
                    break;
                }
            }
        }
        if ($b){
            $this->js[] = $js;
            $this->assign(array(
                'js'  => $this->js,
            ));
        }
    }

    public function getCss(){
        $r = '';
        if (count($this->css) > 0){
            foreach ($this->css as $val){
                if (trim($val)!==''){
                    $r .= ' <link type="text/css" rel="stylesheet" href="'.$val.'">'."\r\n";
                }
            }
        }
        return $r;
    }

    public function DateFormat($date){
        return date("d.m.Y G:i:s", $date);
    }
    public function DateFormat2($date){
        return date("d.m.Y G:i:s", $date);
    }
    public function Head($url, $anch=''){
        if ($anch!==''){
            $url.='#'.$anch;
        }
        header("Location: ".$url);
        exit;
    }

    public function GetModules(){
        $list = scandir(CONTROLLERS_DIR);
        $m = array();
        foreach($list as $v){
            if (file_exists(CONTROLLERS_DIR.$v.'/init.php')){
                $module = include_once(CONTROLLERS_DIR.$v.'/init.php');

                //$class_name = 'Init'.mb_convert_case($v, MB_CASE_TITLE, "UTF-8");
                //$class_name = 'InitModule';
                //if (class_exists($class_name)){
                    //$class = new $class_name();
                    $module_class_name = mb_convert_case($v, MB_CASE_TITLE, "UTF-8").'Controller';
                    $module_admin_class_name = 'Admin'.$module_class_name;
                    // TODO ПОДУМАТЬ
                    $m [] = array(
                        'admin_class_name'  => $module_admin_class_name,
                        'class_name'        => $module_class_name,
                        'alias'             => $v,
                        'name'              => $module['name'],
                        'author'            => $module['author'],
                        'visible'           => $module['visible'],
                    );
                //}
            }
        }

        return $m;
    }
    public function GetThemes(){
        $list = scandir(TEMPLATES_DIR);
        $t = array();
        foreach($list as $v){
            if ($v == '.' || $v == '..') continue;
            $t[] = $v;
        }
        return $t;
    }

    public function alert($message){
        $this->alert = $_SESSION['alert'] = $message;
    }
} 