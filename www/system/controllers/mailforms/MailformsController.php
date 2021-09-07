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
        $this->table_messages = db_pref . $config['table3'];
    }

    public function GetForm($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE id = $id LIMIT 1";
        $form = $this->db->select($sql, array("single" => true));
        $sql = "SELECT * FROM " . $this->table_fields . " WHERE form_id = $id";
        $form['fields'] = $this->db->select($sql);
        return $form;
    }

    public function SaveMailToDB($form_id, $body){
        $params = array(
            'form_id' => $form_id,
            'body' => $body,
            'date' => time(),
            'ip'   => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert($this->table_messages, $params);
    }

    public function Index(){
        $errors = array();
        if (isset($this->post['form_id'])){
            if ($form = $this->GetForm($this->post['form_id'])){
                $body = '';
                foreach ($form['fields'] as $f){
                    if ($f['required'] == 1 && $this->post["field_" . $f['id']] !== ''){
                        $body .= $f['name'] . " : " . $this->post["field_" . $f['id']] . "\r\n";
                    } else {
                        $errors[] = "Поле '" . $f['name'] . "' должно быть заполнено";
                    }
                }
                if (count($errors) == 0){
                    if ($this->config->MailSMTPEnabled == 0){
                        if ($this->func->SendMail($form['emails'], 'Сообщение с сайта "' . $this->config->SiteTitle .'"', $body)){
                            $rs = $form['answer'];
                        } else {
                            $rs = "Ошибка отправки письма";
                        }
                    } else {
                        if ($this->func->SendSMTP($form['emails'], 'Сообщение с сайта "' . $this->config->SiteTitle .'"', $body)){
                            $rs = $form['answer'];
                        } else {
                            $rs = "Ошибка отправки письма";
                        }
                    }
                } else {
                    // TODO выводить $errors о незаполненных полях
                }
                $this->SaveMailToDB($form['id'], $body);

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