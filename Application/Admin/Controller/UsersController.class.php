<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\UserService;

class UsersController extends AdminBaseController
{

    private $userService = null;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function index()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');
        
        $where = array();
        //获取总数
        $tCount = $this->userService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $userList = $this->userService->getList($where, $tPage, $tPageSize, [], 'id DESC');


        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('userList', $userList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    public function add()
    {
        $this->assign('retister_type', 3);
        $this->display();
    }
    
    public function doAdd()
    {
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_add_parames();
        
        if(empty($data['username'])){
            $this->error('商品分类名称不能为空','/Admin/ArticleCate/add',2);
            return;
        } 
    }
    /**
     * ajax 检查分类名称是否存在
     */
    public function ajaxCheckUserName()
    {
        $userName = I('post.user_name','','trim,strip_tags');
        $hasName = $this->userService->getByUserName($userName);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }

    /*
     * 显示更新页面
     */

    public function updates()
    {
        $userId = I('userId', '', 'intval,htmlspecialchars');
        $data = $this->usersService->getUserInfo($userId);
        $this->assign('data', $data);
        $this->display();
    }

    /*
     * 处理更新数据
     */

    public function doUpdate()
    {
        $userId = I('post.userId', '', 'intval,htmlspecialchars');
        $realName = I('post.user_name', '', 'trim,htmlspecialchars');
        $mobile = I('post.mobile', '', 'trim,htmlspecialchars');
        $companyName = I('post.corporation_name', '', 'trim,htmlspecialchars');
        $job = I('post.user_job_title', '', 'trim,htmlspecialchars');
        $gender = I('post.gender', '', 'intval,htmlspecialchars');
        if (0 >= $userId) {
            $this->error('ID错误', '/Admin/Users/index', 2);

            return;
        }
        if (!empty($realName)) {
            $data['real_name'] = $realName;
        }
        if (!empty($mobile)) {
            $data['mobile'] = $mobile;
        }
        if (!empty($companyName)) {
            $data['company_name'] = $companyName;
        }
        if (!empty($job)) {
            $data['job'] = $job;
        }

        $data['gender'] = $gender;
        $result = $this->usersService->updateUserInfo($userId, $data);
        if ($result) {
            $this->success('修改成功', '/Admin/Users/index', 2);

            return;
        }
        $this->error('修改失败', '/Admin/Users/index', 2);

        return;
    }

    /*
     * 显示重置密码页面
     */

    public function resetPwd()
    {
        $userId = I('userId', '', 'intval,htmlspecialchars');
        $this->assign('userId', $userId);
        $this->display("resetpwd");
    }

    /*
     * 显示重置密码页面
     */

    public function doResetPwd()
    {
        print_r($_POST);
    }

    /*
     * 删除操作
     */

    public function doDelete()
    {
        $userId = I('userId', '', 'intval,htmlspecialchars');

        if (0 >= $userId) {
            echo 'ID错误';

            return;
        }
        $data = $this->usersService->doDelete($userId);
        if ($data) {
            echo 1;

            return;
        }
        echo 0;

        return;
    }

}
