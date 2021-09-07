<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
include_once __DIR__ . '/../../classes/Config.class.php';
include_once __DIR__ . '/../../classes/Database.class.php';
include_once __DIR__ . '/../../classes/Func.class.php';
$config = include __DIR__ . '/init.php';
$table = db_pref . $config['table'];
$table_fields = db_pref . $config['table2'];

function GetForm($id){
    global $table;
    global $table_fields;
    $db = Database::getInstance();
    $sql = "SELECT * FROM $table WHERE id = $id";
    $form = $db->select($sql, array("single" => true));
    $sql = "SELECT * FROM $table_fields WHERE form_id = $id";
    if ($fields = $db->select($sql)){
        foreach ($fields as &$f){
            if ($f['type'] == 'select' || $f['type'] == 'radio'){
                $f['values'] = explode("\n", $f['values']);
            }
        }
    }
    $form['fields'] = $fields;
    return $form;
}

function MailForm($id){
    $form = GetForm($id);
    $smarty = Smart::getInstance();
    $smarty->template_dir = __DIR__ . "/templates/";
    $smarty->assign(array('form' => $form));
    $rs = $smarty->fetch($form['template']);
    Manager::getInstance()->SetJS(HTML_CONTROLLERS_DIR.'mailforms/action.js');
    return $rs;
}

if (isset($_POST['form_id'])){

    Func::getInstance()->SendMail('grominfo@gmail.com','fdfdf');
    return 1;
}


?>