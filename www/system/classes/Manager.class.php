<?phpclass Manager{    private $ModuleDefault;    private $query;    private $controller;    private $ClassName;    protected static $instance;    public static function getInstance() {        return (self::$instance === null) ?            self::$instance = new self() :            self::$instance;    }    public function __construct() {        $this->ModuleDefault = "pages"; // Будет в конфиге    }    private function GetController(){        $query = array();        $string = $_SERVER['REQUEST_URI'];        $string = substr($string,1);        $module = $this->ModuleDefault;        if ($string){            $query = explode('/',$string);            $query = array_filter($query);            if (count($query) >= 1){                $file = CONTROLLERS_DIR.$query[0].'/'.mb_convert_case($query[0], MB_CASE_TITLE, "UTF-8").'Controller.php';                if (file_exists($file)){                    include_once($file);                    if (class_exists(mb_convert_case($query[0], MB_CASE_TITLE, "UTF-8").'Controller')){                        $module = $query[0];                        unset($query[0]); // получаем массив параметров запроса без названия контроллера                        //sort($query);                        if (count($query) > 1){                            $query2 = array();                            foreach ($query as $q){                                if ($q !== ''){                                    $query2[] = $q;                                }                            }                            $query = $query2;                        }                    }                }            }        }        $this->query = array_values($query);        $this->controller = $module;        $this->ClassName = mb_convert_case($this->controller, MB_CASE_TITLE, "UTF-8").'Controller';        return $this->query;    }    function GetFunc($text) {        $search = '/\[agwid name=\"([^>]*)\" params=\"([^>]*)\"\]/siu';        return preg_replace_callback($search, 'self::GetFuncCallback', $text);    }    function GetFuncCallback($data) {        if (function_exists($data[1])){            $r = $data[1]($data[2]);        }        return $r;    }    public function exec(){        $content = '';        $this->GetController();        $ControllerFile = CONTROLLERS_DIR.$this->controller.'/'.$this->ClassName.'.php';        if (file_exists($ControllerFile)){            include_once($ControllerFile);            $class = new $this->ClassName($this->query, $this->controller);            $content = $class->Index();            $content = $this->GetFunc($content);//TODO Доделать            /*if ($content==''){                $this->Head("/error404");            }*/            //$content = str_replace('</head>', $this->getCss()."\r\n</head>",$content);            //$content = str_replace('</head>', $this->getJs()."\r\n</head>",$content);            //$content = str_replace(array("\r", "\n"), '', $content);            //$content = preg_replace("/ +/", " ", $content);        }        echo $content;    }}