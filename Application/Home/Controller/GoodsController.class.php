<?php
namespace Home\Controller;

use Application\HomeBaseController;
use Common\Service\Zshop\ProductService;
use Common\Service\Zshop\ProductCateService;
use Common\Service\Zshop\ProductAttrService;
use Common\Service\Zshop\SkuService;
class GoodsController extends HomeBaseController
{
    private $productService = null;
    private $productcateService = null;
    private $productattrService = null;
    private $skuService = null;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
        $this->productcateService = new ProductCateService();
        $this->productattrService = new ProductAttrService();
        $this->skuService = new SkuService();
    }
    
    public function index()
    {
        $this->assign('title','首页');
        $this->display();
    }
    
    //列表页
    public function lists()
    {
        //接收分类id
        $cate = I('get.cate','','intval');
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->productService->countByCondition($where);
        $where = array('cate_id'=>$cate,'status'=>1);//条件为本类未下架产品
        $productList = $this->productService->getList($where, $tPage, $tPageSize, [], 'list_order ASC');
        $show = $this->page($tCount, $tPage, $tPageSize);
        
        $this->assign('productList', $productList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    //内容页
    public function show()
    {
        $id = I('get.id','','intval');
        $data = $this->productService->getByPrimaryKey($id);
        $AttrData = json_decode($data['attributes'],true);
        $attrs = array_keys($AttrData);
        $attr_name =array();
        foreach($attrs as $v){
            $datas = $this->productattrService->getAttrByAttrEn($v);
            array_push($attr_name, $datas[0]);
        }
        $c= array();
        foreach($attr_name as  $val){
            $c[$val['attr_cn']] = $AttrData[$val['attr_en']]."(".$val['unit'].")";
        }
        //获取sku属性
        $res_sku = $this->skuService->getSkuByProductId($id);
        $sku_type = $this->productattrService->getSkuAttrNameByCateId($data['id']);
        //var_dump($sku_type);
        foreach ($res_sku as $key=>&$val){
           $val['sku_key'] = str_replace("_", " ", $val['sku_key']);
        }
        //var_dump($res_sku);
        $this->assign('data', $data);
        $this->assign('AttrData', $c);
        $this->assign('skus', $res_sku);
        $this->assign('sku_type', $sku_type);
        $this->display();
    }
    //ajax 通过sku_id查找库存数 如果购买数大于库存数 返回不能大于库存数
    public function ajaxCheckStockBySku()
    {
        $id = I('post.skuid','','intval');
        if(0>=$id){
            $respon=array('status'=>'0','msg'=>'参数错误！');
            exit(json_encode($respon));
        }
        $res_sku = $this->skuService->getSkuById($id);
        if($res_sku){
            $respon=array('status'=>'1','msg'=>'查询库存成功！','num'=>$res_sku[0]['stock_number']);
            exit(json_encode($respon,true));
        }else{
            $respon=array('status'=>'0','msg'=>'查询库存失败！','num'=>0);
            exit(json_encode($respon,true));
        }
    }

}