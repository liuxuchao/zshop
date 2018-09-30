<?php
namespace Home\Controller;

use Application\HomeBaseController;
use Common\Service\Zshop\UserService;
use Think\Verify;
use Org\Util\RNCryptor;

class LoginController extends HomeBaseController
{
    private $userService = null;
    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }
    
    /**
     * 登陆
     */
    public function Login()
    {
        
        if($this->checkLoginStatus()){
             redirect('/Home/Index');
            return;
        }
        $this->display();
    }
    
    /**
     * 登陆
     */
    public function doLogin()
    {
        $username     = I('post.username', '', 'trim,htmlspecialchars');
        $password = I('post.password', '', 'trim,htmlspecialchars');
        if ( empty($username) || empty($password) ) {
            $this->error("请填写用户名、密码");
            return;
        }
        $password = $this->buildPassword($password);
        $data = $this->userService->doLogin($username,$password);
        if ($data && $username == $data['username']) {
            $sessionUserNameValue = RNCryptor::encrypt($username, C('ENCRYPT_KEY'));
            $sessionUserName = substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN'));
            session($sessionUserName,$sessionUserNameValue);
            $sessionUserId = RNCryptor::encrypt($data['id'], C('ENCRYPT_KEY'));
            session('user_id',$sessionUserId);
            ini_set('session.gc_maxlifetime', C('SESSION_KEEP_TIME'));
            redirect('/Home/Index');
            return;
        }
       
        $this->error('登录失败','/Admin/Login/login',2);
        return;
    }
    /**
     * 注册页面
     */
    public function register()
    {
        
        $this->display();
    }
    
    public function buildVerify()
    {
        $config = [
            'fontSize' => 18,   // 验证码字体大小
            'length' => 4,      // 验证码位数
            'imageH' => 42,
            'imageW'    => 130,               // 验证码图片宽度
        ];
        $verify = new \Think\Verify($config);
        $verify->entry();
    }
    
    public function checkVerify()
    {
        $code = I("post.code","","trim,strip_tags");
        $id = I("post.id","","trim,strip_tags");
        $verify = new \Think\Verify();
        $res = $verify->check($code, $id);
        $this->ajaxReturn($res, 'json');    
    }


    /**
     * 注册数据提交
     */
    public function doRegister()
    {
        $userName = I("post.username","","trim,strip_tags");
        $password = I("post.password","","trim,strip_tags");
        $code = I("post.code","","trim,strip_tags");
        $pwdconfirm = I("post.pwdconfirm","","trim,strip_tags");
        if(empty($password) || empty($pwdconfirm)){
            $this->error("密码或者确认不能为空");
            return;
        }
        if($password != $pwdconfirm){
            $this->error("请密码两次数据不一致！");
            return;
        }
        $data['password'] = $this->buildPassword($password);
        $data['username'] = $userName;
        $data['register_type'] = 1;
        $data['create_time'] = time();
        $insertResult = $this->userService->add($data);
        if($insertResult){
            $this->success("注册成功！");
            redirect('/Home/Index/index');
            return;
        }else{
            $this->error('注册失败','/Home/Login/register',2);
            return;
        }
    }
    
    /**
     * 退出
     */
    public function logout()
    {
        session(substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN')),null);
        cookie(substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN')),null);
        if (cookie(substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN'))) == null) {
            redirect('/Home/Login/login');
        }else{
            $this->error('退出失败');
        }
    }


    /**
     * 检查用户是否存在
     */
    public function ajaxCheckUserName()
    {
        $name = I("post.username","","trim,strip_tags");
        $hasName = $this->userService->getByUserName($name);
        if($hasName){
            exit('0');
        }else{
            exit('1');
        }
    }
    
    /**
     * 模态框登陆 返回json状态
     */
    public function modalLogin()
    {
        $username     = I('post.username', '', 'trim,htmlspecialchars');
        $password = I('post.password', '', 'trim,htmlspecialchars');
        if ( empty($username) || empty($password) ) {
            $respon=array('status'=>'0','msg'=>'用户名或者密码错误！');
            exit(json_encode($respon));
        }
        $password = $this->buildPassword($password);
        $data = $this->userService->doLogin($username,$password);
        if ($data && $username == $data['username']) {
            $sessionUserNameValue = RNCryptor::encrypt($username, C('ENCRYPT_KEY'));
            $sessionUserName = substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN'));
            session($sessionUserName,$sessionUserNameValue);
            ini_set('session.gc_maxlifetime', C('SESSION_KEEP_TIME'));
            $respon=array('status'=>'1','msg'=>'登录成功！');
            exit(json_encode($respon));
        }else{
            $respon=array('status'=>'0','msg'=>'登录失败！');
            exit(json_encode($respon));
        }
    }
}