<?php
namespace Admin\Controller;

vendor('Curl.vendor.autoload');

use \Curl\Curl;
use Application\AdminBaseController;
use Common\Service\Zshop\AdminUserService;

class AdminController extends AdminBaseController
{
    private $adminUserService = null;

    public function __construct()
    {
        parent::__construct();
        
        $this->adminUserService = new AdminUserService();
    }
    public function index()
    {
        $tPage     = I('page', 1, 'intval');
        $tPageSize = I('page_size', 2, 'intval');
        $tCount = $this->adminUserService->getCount();
       
        $show       = $this->page($tCount,$tPage,$tPageSize);// 分页显示输出
        $tData = $this->adminUserService->getList($tPage, $tPageSize);
        $this->assign('data',$tData);
        $this->assign('count',$tCount);
        $this->assign('currentPage',$tPage);
        $this->assign('page',$show);
        $this->display();
    }
    /*
     *显示添加页面
     */
    public function add()
    {
        $this->display();
    }
    /*
     *处理添加数据
     */
    public function doAdd()
    {
        $name     = I('post.name', '', 'trim,htmlspecialchars');
        $password = '123456';
        $nickname = I('post.nickname', '', 'trim,htmlspecialchars');

        if ( empty($name) || empty($nickname) ) {
            $this->error("用户名或密码不能为空");
            return;
        }
        $fData = $this->adminUserService->findByName($name);
        if ($fData) {
            $this->error('用户名已经存在','/Admin/Admin/add',2);
            return;
        }
         $password .= $this->key;
         $data = $this->adminUserService->doAdd($name, $password, $nickname);
         if ($data) {
             $this->success('添加成功','/Admin/Admin/index',2);
             return;
         }
         $this->error('添加失败','/Admin/Admin/add',2);
         return;
    }

/*
 *显示更新页面
 */
    public function updates(){
        $userId     = I('userId', '', 'intval,htmlspecialchars');
        $data = $this->adminUserService->findById($userId);
        if(is_array($data)){
            unset($data['password']);
            unset($data['create_time']);
            unset($data['update_time']);
        }
        $this->assign('data',$data);
        $this->display();
    }
  /*
 *处理更新数据
 */      
    public function doUpdate()
    {
        $userId     = I('post.userId', '', 'intval,htmlspecialchars');
        $name     = I('post.name', '', 'trim,htmlspecialchars');
        $password     = I('post.password', '', 'trim,htmlspecialchars');
        $nickname = I('post.nickname', '', 'trim,htmlspecialchars');
         if (!empty($password)) {
             $password .= $this->key;
         }
         $data = $this->adminUserService->doUpdate($userId, $name=null, $password=null, $nickname=null);
         if ($data) {
             $this->success('修改成功','/Admin/Admin/index',2);
             return;
         }
         $this->error('修改失败','/Admin/Admin/add',2);
         return;
    }


/*
 *显示修改密码页面
 */
    public function changepwd(){
        $this->display();
    }
  /*
 *处理 更新密码
 */      
    public function doChangepwd()
    {
        $sessions = session('admin_user');
        $userId     = $sessions['id'];
        $password     = I('post.password', '', 'trim,htmlspecialchars');
        $confirmPassword     = I('post.confirmPassword', '', 'trim,htmlspecialchars');
        $oldPassword     = I('post.oldPassword', '', 'trim,htmlspecialchars');

         if (empty($oldPassword)) {
             $this->error('密码不能为空','/Admin/Admin/changepwd',2);
            return;
         }

         if ( ($confirmPassword !=$password ) || empty($confirmPassword) || empty($password) ) {
             $this->error('两次密码不一致或者存在空值','/Admin/Admin/changepwd',2);
            return;
         }
         $data = $this->adminUserService->findById($userId);

        if ( is_array($data) ) {
            $tmpOldPassword = $data['password'];
            $oldPassword .= $this->key;
            if (md5($oldPassword) != $tmpOldPassword) {
                $this->error('原密码错误','/Admin/Admin/changepwd',2);
                return;
            }
        }else{
            $this->error('账号信息获取失败无法修改密码','/Admin/Admin/changepwd',2);
            return;
        }
        $password .= $this->key;
         $data = $this->adminUserService->doChangepwd($userId, $password);
         if ($data) {
             $this->success('修改成功','/Admin/Admin/index',2);
             return;
         }
         $this->error('修改失败','/Admin/Admin/add',2);
         return;
    }

    /*
     *删除操作
     */      
    public function doDelete()
    {
        $userId     = I('userId', '', 'intval,htmlspecialchars');
        
         if ( 0>= $userId) {
             echo 'ID错误';
            return;
         }
         $data = $this->adminUserService->doDelete($userId);
         if ($data) {
             echo 1;
             return;
         }
             echo 0;
         return;
    }
    
    
    
    
}