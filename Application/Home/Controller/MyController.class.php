<?php
namespace Home\Controller;

use Application\HomeBaseController;
use Common\Service\Zshop\UserService;
use Common\Service\Zshop\OrderService;


class MyController extends HomeBaseController
{
    private $userService = null;
    private $orderService = null;
    public function __construct()
    {
        parent::__construct();
        if(!$this->checkLoginStatus()){
             redirect('/Home/Login/login');
            return;
        }
        $this->userService = new UserService();
        $this->orderService = new OrderService();
    }
    
    /**
     * 登陆
     */
    public function Index()
    {
        $this->display();
    }
    
    /**
     * 订单列表
     */
    public function ordersList()
    {
        
    }
    
    /**
     * 订单详情
     */
    public function ordersDetail()
    {
        
    }
    
    /**
     * 编辑订单详情
     */
    public function editOrdersDetail()
    {
        
    }
    /**
     * 提交编辑订单详情
     */
    public function doEditOrdersDetail()
    {
        
    }
    
    /**
     * 历史订单
     */
    public function deleteOrders()
    {
        
    }
    
    
    /**
     * 浏览历史
     */
    public function viewHistory()
    {
        
    }
    
    /**
     * 个人信息
     */
    public function myInfo()
    {
       $userId = I("post.userId","","intval");
       $userInfo = $this->userService->getByPrimaryKey($userId);
       $this->assign("userInfo", $userInfo);
       $this->display();
    }
    
    /**
     * 提交编辑个人信息
     */
    public function editMyInfo()
    {
       $userId = I("post.userId","","intval");
       $realName = I("post.real_name","","trim,strip_tags");
       $mobile = I("post.mobile","","trim,strip_tags");
       $userInfo = $this->userService->getByPrimaryKey($userId);
       $updateData =[];
       if(!empty($realName) && $userInfo['real_name'] != $realName){
           $updateData['real_name'] = $realName;
       }
       if(!empty($mobile) && $userInfo['mobile'] != $mobile){
           $updateData['mobile'] = $mobile;
       }
       if($updateData){
           $updateResult = $this->userService->updateByPrimaryKey($userId, $updateData);
           if($updateData){
               $this->success("更新成功",'/Home/My/myInfo',2);
           }else{
               $this->error('更新失败','/Home/My/myInfo',2);
           }
       }else{
            $this->error('没有更新任何数据','/Home/My/myInfo',2);
       }
       return;
    }
    
    /**
     * 修改密码
     */
    public function changePassword()
    {
        
    }
    
    /**
     * 提交修改密码
     */
    public function doChangePassword()
    {
        $userId = I("post.user_id","","intval");
        session_start();
        $sessionInfo = $_SESSION['tihold_user'];
        if($userId !=$sessionInfo['']){}
        $userInfo = $this->userService->getByPrimaryKey($userId);
        $oldPassword = I("post.old_password","","trim,strip_tags");
        $data['password'] = $this->buildPassword($password);
        $password = I("post.new_password","","trim,strip_tags");
        $confirmPassword = I("post.confirmPassword","","trim,strip_tags");
        if(empty($password) || empty($confirmPassword)){
            $this->error("密码或者确认不能为空");
            return;
        }
        if($password != $confirmPassword){
            $this->error("请密码两次数据不一致！");
            return;
        }
        $insertPassword = 
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
     * 购物车
     */
    public function carList()
    {
        $this->display();
    }
    
    /**
     * 购物车
     */
    public function carDetail()
    {
        $this->display();
    }
    
    /**
     * 编辑购物信息
     */
    public function editCarDetail()
    {
        $this->display();
    }
    
    /**
     * 购物地址管理
     */
    public function addressList()
    {
        
    }
    
    /**
     * 编辑购物地址管理
     */
    public function editAddress()
    {
        
    }
    
    /**
     * 提交编辑购物地址管理
     */
    public function doEditAddress()
    {
        
    }
}