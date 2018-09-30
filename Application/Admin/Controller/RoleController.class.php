<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\RoleService;
class RoleController extends AdminBaseController
{

    private $roleService = null;

    public function __construct()
    {
        parent::__construct();
        $this->roleService = new RoleService();
    }

    public function index()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->roleService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $roleList = $this->roleService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('roleList', $roleList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    
    /**
     * 显示添加角色页面
     */
    public function add()
    {
        
        $this->display();
    }
    
    /**
     * ajax 检查角色是否存在
     */
    public function ajaxCheckRoleName()
    {
        $data['role_name'] = I('post.role_name','','trim,strip_tags');
        $hasName = $this->roleService->findByName($data['role_name']);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /*
     * 角色添加
     */
    public function doAdd ()
    {
       //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        //准备数据
        $data = [];
        $data['role_name'] = I('post.role_name','','trim,strip_tags');
        $data['create_time'] = time();
        $data['create_ip'] = get_client_ip();
        $addresult = $this->roleService->add($data);
        if($addresult){
            $this->success('角色添加成功','/Admin/Role/index',2);
            return;
        }else{
            $this->error('角色添加失败','/Admin/Role/add',2);
            return; 
        }

    }
    /*
     * 显示更新页面
     */

    public function updates()
    {
        $id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->roleService->getByPrimaryKey($id);
        $this->assign('data', $data);
        $this->display();
    }

    /*
     * 处理更新数据
     */

    public function doUpdate()
    {
   
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = [];
        $data['id'] = I('post.id','','trim,strip_tags');
        $data['role_name'] = I('post.role_name','','trim,strip_tags');
        
        if(empty($data['role_name'])){
            $this->error('角色名称不能为空','/Admin/Role/updates/id'.$data['id'],2);
            return;
        }
        $data['update_time'] = time();
        $data['update_ip'] = get_client_ip();
        $upResult = $this->roleService->updateByPrimaryKey($data['id'],$data);
        if ($upResult) {
            $this->success('角色修改成功', '/Admin/Role/index', 2);
            return;
        }
        $this->error('角色修改失败', '/Admin/Role/updates/id'.$data['id'], 2);

        return;
    }

    /*
     * 删除操作
     */
    public function doDelete()
    {
        $roleId = I('id', '', 'intval,htmlspecialchars');
        if (0 >= $roleId) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }
        $data = $this->roleService->deleteByPrimaryKey($roleId);
        if ($data) {
            $result = ['error_code'=>'0','message'=>'删除成功'];
            echo json_encode($result);
            return;
        }
        $result = ['error_code'=>'1','message'=>'删除失败'];
        echo json_encode($result);
        return;
    }

}
