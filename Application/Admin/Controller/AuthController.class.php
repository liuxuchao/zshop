<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\RuleService;
use Common\Service\Zshop\AuthGroupService;
use Common\Service\Zshop\AuthGroupAccessService;

class AuthController extends AdminBaseController
{

    private $ruleService = null;
    private $authGroupService = null;
    private $authGroupAccessService = null;
    public function __construct()
    {
        parent::__construct();
        $this->ruleService = new RuleService();
        $this->authGroupService = new AuthGroupService();
        $this->authGroupAccessService = new AuthGroupAccessService();
    }

    //权限组列表
    public function index()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->authGroupService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $groupList = $this->authGroupService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('groupList', $groupList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);

        $this->display();
    }
    
    
    
    /**
     * 显示添加权限组页面
     */
    public function add()
    {
        $this->display();
    }
    
    /**
     * ajax 检查权限组是否存在
     */
    public function ajaxCheckGroupTitle()
    {
        $data['title'] = I('post.title','','trim,strip_tags');
        $hasName = $this->authGroupService->findByName($data['title']);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /*
     * 权限组添加
     */
    public function doAdd ()
    {
       //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        //准备数据
        $data = [];
        $data['title'] = I('post.title','','trim,strip_tags');
        $data['status'] = 1;
        
        $addresult = $this->authGroupService->add($data);
        if($addresult){
            $this->success('权限组添加成功','/Admin/Auth/index',2);
            return;
        }else{
            $this->error('权限组添加失败','/Admin/Auth/add',2);
            return; 
        }

    }
    /*
     * 显示更新页面
     */

    public function updates()
    {
        $id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->authGroupService->getByPrimaryKey($id);
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
        $data['title'] = I('post.title','','trim,strip_tags');
        
        if(empty($data['title'])){
            $this->error('权限组名称不能为空','/Admin/Auth/updates/id'.$data['id'],2);
            return;
        }
        $upResult = $this->authGroupService->updateByPrimaryKey($data['id'],$data);
        if ($upResult) {
            $this->success('权限组修改成功', '/Admin/Auth/index', 2);
            return;
        }
        $this->error('权限组修改失败', '/Admin/Auth/updates/id'.$data['id'], 2);

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
        $data = $this->authGroupService->deleteByPrimaryKey($roleId);
        if ($data) {
            $result = ['error_code'=>'0','message'=>'删除成功'];
            echo json_encode($result);
            return;
        }
        $result = ['error_code'=>'1','message'=>'删除失败'];
        echo json_encode($result);
        return;
    }
    
    /**
     * 查看 组权限 列表 
     */
    public function  ruleIndex()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->ruleService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $ruleList = $this->ruleService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('ruleList', $ruleList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);

        $this->display();
    }

    /**
     * 显示添加权限规则页面
     */
    public function ruleAdd()
    {
        $this->display();
    }
    /*
     * 权限规则添加
     */
    public function ruleDoAdd ()
    {
       //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        //准备数据
        $data = [];
        $data['name'] = I('post.name','','trim,strip_tags');
        $data['title'] = I('post.title','','trim,strip_tags');
        
        $addresult = $this->ruleService->add($data);
        if($addresult){
            $this->success('权限规则添加成功','/Admin/Auth/ruleIndex',2);
            return;
        }else{
            $this->error('权限规则添加失败','/Admin/Auth/ruleAdd',2);
            return; 
        }

    }
    
    /**
     * ajax 检查权限规则是否存在
     */
    public function ajaxCheckRuleName()
    {
        $data['name'] = I('post.name','','trim,strip_tags');
        $hasName = $this->ruleService->ajaxCheckRuleName($data['name']);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    public function ajaxCheckRuleTitle()
    {
        $data['title'] = I('post.title','','trim,strip_tags');
        $hasName = $this->ruleService->ajaxCheckRuleName('',$data['title']);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /*
     * 显示更新页面
     */

    public function ruleUpdates()
    {
        $id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->ruleService->getByPrimaryKey($id);
        $this->assign('data', $data);
        $this->display();
    }
    
    /*
     * 处理更新数据
     */

    public function ruleDoUpdates()
    {
   
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = [];
        $data['id'] = I('post.id','','trim,strip_tags');
        $data['title'] = I('post.title','','trim,strip_tags');
        $data['name'] = I('post.name','','trim,strip_tags');
        if(empty($data['title'])||empty($data['name'])){
            $this->error('权限规则名称和标识不能为空','/Admin/Auth/updates/id'.$data['id'],2);
            return;
        }
        $upResult = $this->ruleService->updateByPrimaryKey($data['id'],$data);
        if ($upResult) {
            $this->success('权限规则修改成功', '/Admin/Auth/ruleIndex', 2);
            return;
        }else{
            $this->error('权限规则修改失败', '/Admin/Auth/ruleUpdates/id'.$data['id'], 2);
        }
        

        return;
    }

    // 组权限管理

    public function groupAccessList()
    {
        $param = parent::_handleTime(I());
        $groupId = $param['groupId'];
        //查询该组的权限 ti_auth_group
        $groupRules = $this->authGroupService->getByPrimaryKey($groupId);
//        $authRules=trim($groupRules['rules'],',');
//        $allAuthRules = $this->ruleService->getList([]);
        $accessList = $this->getAccessList($groupId);
        $resTree = $this->ruleService->getTree();
        $keyOfTree = [];
        foreach($resTree as $key=>$val){
            $val['is_access'] = in_array($val['id'], $accessList) ? 1: 0;
            $keyOfTree[$val['id']] = $val;
        }
        $this->assign('resTree', $keyOfTree);
        $this->assign('resTree2', $keyOfTree);
        $this->assign('resTree3', $keyOfTree);
        $this->assign('groupRules', $groupRules);
        $this->display();
    }

    //获取权限组信息
    
    private function getAccessList($groupId)
    {
        if($groupId ==0){
            return [];
        }
        $where = [];
        $where['group_id'] = $groupId;
        $accessList = $this->authGroupAccessService->getAll($where);
        $accessListId = [];
        $accessListId = array_column($accessList,'uid');
        return $accessListId;
    }
    
    // 组权限 修改
    public function groupAccessUpdate()
    {
        
    }

    // 组权限 修改
    public function groupAccessDoUpdate()
    {
        
    }

}
