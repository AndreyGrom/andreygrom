<?php
class AnalysisController extends Controller{
    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }

    public function Index(){

        $this->SetPath('/analysis/single/');
        $this->content = $this->SetTemplate('default.tpl');
        return $this->content;
    }
}
?>