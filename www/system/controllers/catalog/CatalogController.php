<?php
class CatalogController extends Controller{
    private $categories;
    private $structure;
    private $alias;
    private $table;
    private $table2;
    private $table3;
    private $table4;
    public function __construct($query, $controller) {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->table2 = db_pref . $config['table2'];
        $this->table3 = db_pref . $config['table3'];
        $this->table4 = db_pref . $config['table4'];
        $this->assign(array(
            'module_config' => $config,
        ));
    }
    public function Index(){
        $this->LoadModel($this->alias);
        $this->categories = $this->ModelCatalog->GetCategories(array('sort' => 'id ASC'));
        $this->structure = $this->func->getStructure($this->categories);

        $this->SetPath('/catalog/');
        $this->content = $this->SetTemplate('index.tpl');

        return $this->content;
    }
}
?>