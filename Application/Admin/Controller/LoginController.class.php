<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\AdminUserService;

/**
 * 管理员登陆
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-7-25 15:13:27
 */
class LoginController extends AdminBaseController
{
    private $adminUserService = null;
    public function __construct()
    {
        parent::__construct();
        $this->adminUserService = new AdminUserService();
    }
    
    /**
     * 登陆页面
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-25 15:18
     * @return null
     */
    public function login()
    {
        $this->display();
    }
    
    /**
     * 执行管理员登陆
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-25 16:12
     * @return null;
     */
    public function doLogin()
    {
        $user     = I('post.name', '', 'trim,htmlspecialchars');
        $password = I('post.password', '', 'trim,htmlspecialchars');
        if ( empty($user) || empty($password) ) {
            $this->error("请填写用户名、密码");
            return;
        }
        $password = $this->buildPassword($password);
        $data = $this->adminUserService->doLogin($user,$password);
        if ($data) {
            $this->nickname = $data['nickname'];
            $this->adminUserId = $data['id'];
            session('admin_user',$data);
            redirect('/Admin/index');
            return;
        }
        $this->error('登录失败','/Admin/Login/login',2);
        return;
    }


    /**
     * 退出
     * @return  null
     */
    public function logout()
    {
        session('admin_user',null);
        cookie('admin_user',null);
        if (cookie('admin_user') == null) {
            redirect('/Admin/Login/login');
        }else{
            $this->error('退出失败');
        }
    }
}
