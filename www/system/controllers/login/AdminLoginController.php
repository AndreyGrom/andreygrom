<?php

class AdminLoginController extends AdminController {
    public function __construct() {
        parent::__construct();
    }
    public function Index(){
        if (isset($this->get['out'])){
            unset($this->session['admin']);
            unset($_SESSION['admin']);
            unset($_SESSION['superadmin']);
            setcookie('admin_hash','',time()+3600*24*30*6,'/');
            if (isset($this->get['all'])){
                //$this->db->select("SELECT * FROM " . db_pref . "users WHERE hash = '$hash'")
                $this->config->set('admin_hash','');
            }
            $this->Head("?");
        }
        if (isset($this->post['email'])&& isset($this->post['password'])){
            $u_login = $this->post['email'];
            $u_password = md5($this->post['password']);
            if ($user = $this->db->select("SELECT * FROM " . db_pref . "users WHERE email = '$u_login' && password = '$u_password' LIMIT 1")){
                $user = $user[0];
                if ($user['group_id'] == 1){
                    $_SESSION['admin'] = $user;
                    $hash = $user['hash'];
                    if ($hash == ''){
                        $hash = $this->generatePassword(20);
                        $this->db->query("UPDATE " . db_pref . "users SET hash = '$hash' WHERE id = " . $user['id']);
                    }
                    setcookie('admin_hash', $hash, time() + 3600*24*30*6, '/');
                    $this->Head($_SERVER['HTTP_REFERER']);
                }
            }
            else $error='Неверные данные!';
        }

        if (isset($_COOKIE['admin_hash'])){
            $hash = $_COOKIE['admin_hash'];
            if ($user = $this->db->select("SELECT * FROM " . db_pref . "users WHERE hash = '$hash' LIMIT 1")){
                $user = $user[0];
                if ($user['group_id'] == 1){
                    $_SESSION['admin'] = $user;
                    $this->session['admin'] = $user;
                }
            }
        }

        if (!isset($this->session['admin'])){
            if (isset($error)){
                $this->assign(array(
                    'error' => '<div class="error">'.$error.$this->config->AdminLogin.'</div>'
                ));
            }
            $this->display('login.tpl');
            exit;
        } else {
            $this->Head($_SERVER['HTTP_REFERER']);
        }
        return $this->content;
    }

    // TODO перенести в функции
    function generatePassword($length = 8){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}
?>