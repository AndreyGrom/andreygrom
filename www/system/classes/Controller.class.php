<?php
class Controller
{
    public $post;
    public $get = array();
    public $query;
    public $controller;
    public $db;
    public $config;
    public $theme;
    public $theme_dir;
    public $templates_dir;
    public $smarty;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $meta_image;
    public $content;
    public $js = array();
    public $css = array();
    public $breadcrumbs = array();
    public $page_title;

    public function __construct($query, $controller)
    {
        $this->post = $_POST;
        $this->get = array();
        $this->query = $query;
        $this->ParseQuery();
        $this->controller = $controller;
        $this->db = Database::getInstance();
        $this->config = Config::getInstance();
        $this->theme = $this->config->Theme;
        $this->theme_dir = TEMPLATES_DIR . $this->config->Theme .'/';
        $this->templates_dir = TEMPLATES_DIR . $this->config->Theme . '/tpl/';
        $this->smarty = Smart::getInstance();
    }

    function ParseQuery(){
        $arr = array();
        if (count($this->query) > 0){
            foreach($this->query as $q){
                $s = explode('=',$q);
                if (count($s) > 1){
                    $arr[$s[0]] = $s[1];
                } else {
                    $arr[$s[0]] = '';
                }
            }
        }
        $this->get = $arr;
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

    public function assign($arr){
        $this->smarty->assign($arr);
    }

    public function display($temp=''){
        $this->smarty->display($temp);
    }

    public function fetch($temp=''){
        return $this->smarty->fetch($temp);
    }

    public function SetPath($path){
        $this->smarty->template_dir = $this->templates_dir . $path;
    }

    public function AssingCommonVars(){
        if ($this->meta_title == ''){
            $this->meta_title = $this->config->SiteTitle;
        }

        if ($this->meta_description==''){
            $this->meta_description = $this->config->DefaultMetaDesc;
        }
        if ($this->meta_keywords==''){
            $this->meta_keywords = $this->config->DefaultMetaKeywords;
        }
        $this->smarty->assign(array(
            'meta_title'                 => $this->meta_title,
            'meta_description'           => $this->meta_description,
            'meta_keywords'              => $this->meta_keywords,
            'meta_image'                 => $this->meta_image,
            'site_name'                  => $this->config->SiteTitle,
            'site_description'           => $this->config->SiteDescription,
            'site_director'              => $this->config->SiteDirector,
            'site_theme'                 => $this->config->Theme,
            'module_default'             => $this->config->ModuleDefault,
            'module_name'                => $this->controller,
            // TODO сделать получение URL через функцию
            'site_url'                   => 'http://'.$_SERVER['SERVER_NAME'].'/',
            'self_url'                   => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
            'template_dir'               => '/'.$this->templates_dir,
            'theme_dir'                  => HTML_THEMES_DIR . $this->config->Theme.'/',
            'config'                     => $this->config,
            'js'                         => $this->getJs(),
            'css'                        => $this->getCss(),
            'breadcrumbs'                => count($this->breadcrumbs) > 0 ? $this->breadcrumbs : false,
            'query_count'                => $this->db->query_count,
            'upload_images_dir'          => '/'.UPLOAD_IMAGES_DIR,
            'cache_images'               => '/'.CACHE_IMAGES,
            'html_upload_images_dir'     => HTML_UPLOAD_IMAGES_DIR,
            'html_cache_images'          => HTML_CACHE_IMAGES,
            'html_plugins_dir'           => HTML_PLUGINS_DIR,
            'html_controllers_dir'       => HTML_CONTROLLERS_DIR,
            'html_classes_dir'           => HTML_CLASSES_DIR,
        ));
    }
    public function SetTemplate($tpl){
        if ($this->config->SiteEnabled == 0 && !isset($_SESSION['admin'])){
            $result = $this->SetSystemPage('Сайт временно отключен', $this->config->SiteDisabledMessage);
        } else{
            $this->AssingCommonVars();
            $result = $this->smarty->fetch($tpl);

            $result = str_replace('</head>', $this->getCss()."\r\n</head>",$result);
            $result = str_replace('</body>', $this->getJs()."\r\n</body>",$result);
        }

        if (is_dir(CONTROLLERS_DIR)){
            $list = scandir(CONTROLLERS_DIR);
            foreach ($list as $l){
                $file_func = CONTROLLERS_DIR.$l.'/after_fn.php';
                if (file_exists($file_func)){
                    include_once($file_func);
                }
            }
        }
        return $result;
    }

    public function SetSystemPage($title, $message){
        $this->assign(array(
            'title'       => $title,
            'message'       => $message,
        ));
        $this->smarty->template_dir = CONTROLLERS_DIR;
        return $result = $this->smarty->fetch('system.tpl');
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
                    $r .= ' <link rel="stylesheet" href="'.$val.'">'."\r\n";
                }
            }
        }
        return $r;
    }

    public function DateFormat($date){
        return date("d.m.Y G:i:s", $date);
    }
    public function DateFormatForum($date){
        return date("d.m.Y, в G:i:s", $date);
    }
    public function Head($url){
        header("Location: ".$url);
        exit;
    }
}
?>