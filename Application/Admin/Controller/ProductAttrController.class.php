<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\ProductCateService;
use Common\Service\Zshop\ProductAttrService;

class ProductAttrController extends AdminBaseController
{

    private $productcateService = null;
    private $productattrService = null;
    public function __construct()
    {
        parent::__construct();
        $this->productcateService = new ProductCateService();
        $this->productattrService = new ProductAttrService();
    }

    /**
     * 商品分类列表
     */
    public function index()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');
        $where = array();
        //获取总数
        $tCount = $this->productattrService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $attrList = $this->productattrService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        //获取分类信息
        $cateId = I('get.cate_id', '', 'intval,htmlspecialchars');
        $cateInfo = $this->productcateService->getByPrimaryKey($cateId);
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('attrList', $attrList);
        $this->assign('cateInfo', $cateInfo);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    /**
     * 显示添加页面
     */
    public function add()
    {
        $cateId = I('get.cate_id', '', 'intval,htmlspecialchars');
        $cateInfo = $this->productcateService->getByPrimaryKey($cateId);
        $this->assign('cateInfo', $cateInfo);
        $this->display();
    }
    /**
     * ajax 检查分类属性中文名称是否存在
     */
    public function ajaxCheckAttrNameOfCn()
    {
        $data['attr_cn'] = I('post.attr_cn','','trim,strip_tags');
        $data['type'] = I('post.type','','intval');
        $hasName = $this->productattrService->findByCname($data['attr_cn']);
        if($data['type']==1 && $hasName['attr_cn'] == $data['attr_cn']){
             exit('{"valid":true}');
        }
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /**
     * ajax 检查分类属性英文名称是否存在
     */
    public function ajaxCheckAttrNameOfEn()
    {
        $data['attr_en'] = I('post.attr_en','','trim,strip_tags');
        $data['type'] = I('post.type','','intval');
        $hasName = $this->productattrService->findByEname($data['attr_en']);
        if($data['type']==1 && $hasName['attr_en'] == $data['attr_en']){
             exit('{"valid":true}');
        }
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /*
     * 商品分类属性添加
     */
    public function doAdd () {

        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_add_parames();
        
        if(empty($data['attr_cn'])){
            $this->error('商品分类属性中文名称不能为空','/Admin/ProductAttr/add',2);
            return;
        } 
        $fData = $this->productattrService->findByCname($data['attr_cn']);
        if ($fData) {
            $this->error('商品分类属性中文已经存在','/Admin/ProductAttr/add',2);
            return;
        }
        if(empty($data['attr_en'])){
            $this->error('商品分类属性英文名称不能为空','/Admin/ProductAttr/add',2);
            return;
        } 
        $fData = $this->productattrService->findByEname($data['attr_n']);
        if ($fData) {
            $this->error('商品分类属性英文已经存在','/Admin/ProductAttr/add',2);
            return;
        }
        $data['create_time'] = time();
        $data['create_ip'] = get_client_ip();
        $addresult = $this->productattrService->add($data);
        if ($addresult){
            $this->error('分类属性添加成功','/Admin/ProductAttr/index',2);
            return; 
        }else{
            $this->error('分类属性添加失败','/Admin/ProductAttr/add',2);
            return; 
        }
        
    }

    /*
     * 显示更新页面
     */

    public function updates()
    {
        $Id = I('get.id', '', 'intval,htmlspecialchars');
        $attrData = $this->productattrService->getByPrimaryKey($Id);
        $cateId = I('get.cate_id', '', 'intval,htmlspecialchars');
        $cateInfo = $this->productcateService->getByPrimaryKey($cateId);
        $this->assign('attrData', $attrData);
        $this->assign('cateInfo', $cateInfo);
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
        $attrData = $this->productattrService->getByPrimaryKey($data['id']);
        $data = $this->receive_update_parames();
        if(empty($data['attr_cn'])){
            $this->error('商品分类属性中文名称不能为空','/Admin/ProductAttr/add',2);
            return;
        }
        if(empty($data['attr_en'])){
            $this->error('商品分类属性英文名称不能为空','/Admin/ProductAttr/add',2);
            return;
        }
        $data['update_time'] = time();
        $data['update_ip'] = get_client_ip();
        $upResult = $this->productattrService->updateByPrimaryKey($data['id'],$data);
        if($upResult){
            $this->success('修改成功', '/Admin/ProductAttr/index', 2);
            return;
        }else{
            $this->success('修改成功', '/Admin/ProductAttr/index', 2);
            return;
        }
    }

    /*
     * 删除操作
     */
    public function doDelete()
    {
        $cateId = I('id', '', 'intval,htmlspecialchars');
       
        if (0 >= $cateId) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }
        $data = $this->productattrService->doDelete($cateId);
        if ($data) {
            $result = ['error_code'=>'0','message'=>'删除成功'];
            echo json_encode($result);
            return;
        }
        $result = ['error_code'=>'1','message'=>'删除失败'];
        echo json_encode($result);
        return;
    }

    /*
    *  接收添加分类post参数
    * 
    */
    private function receive_add_parames(){
        $data = [];
        $data['cate_id'] = I('post.cate_id','','strip_tags');
        $data['attr_cn'] = I('post.attr_cn','','strip_tags');
        $data['attr_en'] = I('post.attr_en','','strip_tags');
        $data['types'] = I('post.types','','strip_tags');
        $data['is_sku'] = I('post.is_sku','','intval');
        $data['unit'] = I('post.unit','','intval');
        $json_values = I('post.json_values','','strip_tags');
        $data['json_values'] = !empty($json_values)? trim($json_values):'';
        return $data;
    }
    
    /*
    *  接收修改分类post参数
    * 
    */
    private function receive_update_parames(){
        $data = [];
        $data['id'] = I('post.id','','strip_tags');
        $data['attr_cn'] = I('post.attr_cn','','strip_tags');
        $data['attr_en'] = I('post.attr_en','','strip_tags');
        $data['types'] = I('post.types','','strip_tags');
        $data['is_sku'] = I('post.is_sku','','intval');
        $data['unit'] = I('post.unit','','intval');
        $json_values = I('post.json_values','','strip_tags');
        $data['json_values'] = !empty($json_values)? trim($json_values):'';
        return $data;
    }
}
