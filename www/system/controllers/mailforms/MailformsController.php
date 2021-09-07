<?php
class MailformsController extends Controller
{
    private $alias;
    private $table;
    private $table_fields;

    public function __construct($query, $controller)
    {
        parent::__construct($query, $controller);
        $config = include (__DIR__) . '/init.php';
        $this->alias = $config['alias'];
        $this->table = db_pref . $config['table'];
        $this->table_fields = db_pref . $config['table2'];
    }

    public function GetForm($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id = $id LIMIT 1";
        $form = $this->db->select($sql, array("single" => true));
        $sql = "SELECT * FROM " . $this->table_fields . " WHERE form_id = $id";
        $form['fields'] = $this->db->select($sql);
        return $form;
    }

    public function Index(){
        if (isset($this->post['form_id'])){
            $rs = '';
            if ($form = $this->GetForm($this->post['form_id'])){
                $body = '';
                foreach ($form['fields'] as $f){
                    $body .= $f['name'] . " : " . $this->post["field_" . $f['id']] . "\r\n";
                }
                $this->func->SendMail($form['emails'], 'Тестовое', $body);
                $rs = $form['answer'];
            } else {
                $rs = 'Форма не найдена';
            }
            echo $rs;
            exit;
        }
        return $this->content;
    }

}
?>