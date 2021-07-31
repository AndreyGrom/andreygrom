<?php

class AdminLoginController extends AdminController {
    public function __construct() {
        parent::__construct();
    }
    public function Index(){
        if (isset($this->get['out'])){
            unset($this->session['admin']);
            unset($this->session['superadmin']);
            unset($_SESSION['admin']);
            unset($_SESSION['superadmin']);
            setcookie('admin_hash','',time()+3600*24*30*6,'/');
            if (isset($this->get['all'])){
                $this->config->set('admin_hash','');
            }
            $this->Head("?");
        }
        if (isset($this->get['login']) && isset($this->get['password'])){
            if ($this->get['login']==$this->config->AdminLogin && $this->get['password']==$this->config->AdminPassword){
                $_SESSION['admin']=$this->config->AdminLogin;
                if (!$this->config->admin_hash || $this->config->admin_hash == ''){
                    $hash = $this->generatePassword(20);
                    $this->config->set('admin_hash',$hash);
                }
                setcookie('admin_hash',$this->config->admin_hash,time()+3600*24*30*6,'/');
                $this->Head($_SERVER['HTTP_REFERER']);
            }
        }
        if (isset($this->post['user'])&& isset($this->post['password'])){
            if ($this->post['user']==$this->config->AdminLogin && $this->post['password']==$this->config->AdminPassword){
                $_SESSION['admin']=$this->config->AdminLogin;
                if (!$this->config->admin_hash || $this->config->admin_hash == ''){
                    $hash = $this->generatePassword(20);
                    $this->config->set('admin_hash',$hash);
                }
                setcookie('admin_hash',$this->config->admin_hash,time()+3600*24*30*6,'/');
                $this->Head($_SERVER['HTTP_REFERER']);
            }
            else $error='Неверные данные!';
        }


        if (isset($_COOKIE['admin_hash'])){
            $hash = $_COOKIE['admin_hash'];
            if ($this->config->admin_hash == $hash){
                $_SESSION['admin']=$this->config->AdminLogin;
                $this->session['admin']=$this->config->AdminLogin;;

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