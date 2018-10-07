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
        if (!empty($param['usertype'])) {
            $where['userType'] = $param['usertype'];
        }

        if ($param['date'] == 'today') {
            //php获取今日开始时间戳和结束时间戳
            $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $where['create_time'] = array('egt',$beginToday);
            $where['create_time'] = array('elt',$endToday);
        }
            
        if ($param['date'] == 'yesterday') {
            //php获取昨日起始时间戳和结束时间戳
            $beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
            $endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
            $where['create_time'] = array('egt',$beginYesterday);
            $where['create_time'] = array('elt',$endYesterday);
        }

        if ($param['date'] == 'week') {
            //php获取本周起始时间戳和结束时间戳
            $beginWeek = strtotime(date('Y-m-d', strtotime("this week Monday", time())));
            $endWeek = strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
            $where['create_time'] = array('egt',$beginWeek);
            $where['create_time'] = array('elt',$endWeek);
        }

        if ($param['date'] == 'month') {
            //php获取本周起始时间戳和结束时间戳
            $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
            $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
            $where['create_time'] = array('egt',$beginThismonth);
            $where['create_time'] = array('elt',$endThismonth);
        }

        //开始时间
        if (!empty($param['srtime'])) {
            $where['create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        }

        //结束时间
        if (!empty($param['ertime'])) {
            $where['create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        }
        
        //获取总数
        $tCount = $this->userService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $userList = $this->userService->getList($where, $tPage, $tPageSize, 'id DESC');

        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('userList', $userList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }


    /**
     *添加员工信息
     */
    public function addUser(){
        $this->display();
    }

    
    // public function add()
    // {
    //     $this->assign('retister_type', 3);
    //     $this->display();
    // }
    
    public function doAdd()
    {
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }

        $userNum = I('post.userNum', '', 'trim,htmlspecialchars');
        $username = I('post.username', '', 'trim,htmlspecialchars');
        $icon_url = I('post.thumb', '', 'trim,htmlspecialchars');
        $gender = I('post.gender', '', 'intval,htmlspecialchars');
        $creatime = time();
        if (empty($userNum)) {
            $this->error('工号不能为空', '/Admin/Users/addUser/usertype/2');

            return;
        }
        $data['userNum'] = $userNum;
        if (!empty($username)) {
            $data['username'] = $username;
        }
        if (!empty($icon_url)) {
            $data['icon_url'] = $icon_url;
        }

        $data['create_time'] = $creatime;
        $data['userType'] = 2;
        $data['password'] = md5('123456');
        $data['gender'] = $gender;
        $result = $this->userService->add($data);
        if ($result) {
            $this->success('新增成功', '/Admin/Users/index/usertype/2');

            return;
        }
        $this->error('新增失败', '/Admin/Users/addUser/usertype/2');

        return;

        // $data = $this->receive_add_parames();
        
        // if(empty($data['username'])){
        //     $this->error('商品分类名称不能为空','/Admin/ArticleCate/add',2);
        //     return;
        // } 
    }


    /**
     *修改员工信息
     */
    public function updateUser(){
        $userId = I('userId', '', 'intval,htmlspecialchars');
        $data = $this->userService->getUserInfo($userId);
        $this->assign('data', $data);
        $this->display();
    }



    public function doUpdate(){
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }

        $userId = I('user_id', '', 'intval,htmlspecialchars');
        $userNum = I('post.userNum', '', 'trim,htmlspecialchars');
        $username = I('post.username', '', 'trim,htmlspecialchars');
        $icon_url = I('post.thumb', '', 'trim,htmlspecialchars');
        $gender = I('post.gender', '', 'intval,htmlspecialchars');
        $creatime = time();
        if (empty($userNum)) {
            $this->error('工号不能为空', '/Admin/Users/addUser/usertype/2');

            return;
        }
        $data['userNum'] = $userNum;
        if (!empty($username)) {
            $data['username'] = $username;
        }
        if (!empty($icon_url)) {
            $data['icon_url'] = $icon_url;
        }

        $data['create_time'] = $creatime;
        $data['userType'] = 2;
        $data['password'] = md5('123456');
        $data['gender'] = $gender;
        
        $result = $this->userService->updateUserInfo($userId,$data);
        if ($result) {
            $this->success('修改成功', '/Admin/Users/index/usertype/2');

            return;
        }
        $this->error('修改失败', '/Admin/Users/index/usertype/2');

        return;
    }


    /**
     * ajax 检查分类名称是否存在
     */
    // public function ajaxCheckUserName()
    // {
    //     $userName = I('post.user_name','','trim,strip_tags');
    //     $hasName = $this->userService->getByUserName($userName);
    //     if($hasName){
    //         exit('{"valid":false}');
    //     }else{
    //         exit('{"valid":true}');
    //     }
    // }

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

    // public function doUpdate()
    // {
    //     $userId = I('post.userNum', '', 'intval,htmlspecialchars');
    //     $realName = I('post.user_name', '', 'trim,htmlspecialchars');
    //     $mobile = I('post.mobile', '', 'trim,htmlspecialchars');
    //     $companyName = I('post.corporation_name', '', 'trim,htmlspecialchars');
    //     $job = I('post.user_job_title', '', 'trim,htmlspecialchars');
    //     $gender = I('post.gender', '', 'intval,htmlspecialchars');
    //     if (0 >= $userId) {
    //         $this->error('ID错误', '/Admin/Users/index', 2);

    //         return;
    //     }
    //     if (!empty($realName)) {
    //         $data['real_name'] = $realName;
    //     }
    //     if (!empty($mobile)) {
    //         $data['mobile'] = $mobile;
    //     }
    //     if (!empty($companyName)) {
    //         $data['company_name'] = $companyName;
    //     }
    //     if (!empty($job)) {
    //         $data['job'] = $job;
    //     }

    //     $data['gender'] = $gender;
    //     $result = $this->usersService->updateUserInfo($userId, $data);
    //     if ($result) {
    //         $this->success('修改成功', '/Admin/Users/index', 2);

    //         return;
    //     }
    //     $this->error('修改失败', '/Admin/Users/index', 2);

    //     return;
    // }

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
        if (!IS_POST) {
            exit("非法请求");
        }

        $userId = I('userid', '', 'intval,htmlspecialchars');
        $oldPassword = I('post.oldPassword', '', 'trim,htmlspecialchars');
        $password = I('post.password', '', 'trim,htmlspecialchars');
        $confirmPassword = I('post.confirmPassword', '', 'trim,htmlspecialchars');

        if ($password != $confirmPassword) {
            $this->error('两次密码不一致，请重新输入', '/Admin/Users/resetPwd/userId/'.$userId);
            return;
        }
        $res = $this->userService->getUserInfo($userId);
        if(md5($oldPassword) != $res['password']){
            $this->error('原密码输入不正确，请重新输入', '/Admin/Users/resetPwd/userId/'.$userId);
            return;
        }
        $data['password'] = md5($password);
        $result = $this->userService->updateUserInfo($userId,$data);

        if ($result) {
            $this->success('修改成功', '/Admin/Users/index/usertype/2');

            return;
        }
        $this->error('修改失败', '/Admin/Users/resetPwd/userId/'.$userId);

        return;
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
        $data = $this->userService->doDelete($userId);
        if ($data) {
            echo 1;

            return;
        }
        echo 0;

        return;
    }

}
