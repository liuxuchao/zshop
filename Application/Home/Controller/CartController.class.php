<?php
namespace Home\Controller;

use Application\HomeBaseController;
use Common\Service\Zshop\ProductService;
use Common\Service\Zshop\ProductCateService;
use Common\Service\Zshop\ProductAttrService;
use Common\Service\Zshop\SkuService;
use Common\Service\Zshop\CartService;
class CartController extends HomeBaseController
{
    private $productService = null;
    private $productcateService = null;
    private $productattrService = null;
    private $skuService = null;
    private $cartService = null;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
        $this->productcateService = new ProductCateService();
        $this->productattrService = new ProductAttrService();
        $this->skuService = new SkuService();
        $this->cartService = new CartService();
    }
    
    public function index()
    {
        $this->assign('title','首页');
        $this->display();
    }
    
    //添加商品到购物车
    public function addToCart()
    {
        //接收 数据
        $data=[];
        $data['user_id'] = I('post.user_id','','intval');
        $data['product_id'] = I('post.proid','','intval');
        $data['sku_id'] = I('post.skuid','','intval');
        $data['num'] = I('post.num','','intval');
        
        if($data['user_id'] !='' &&  $data['product_id'] !='' && $data['sku_id'] !='' && $data['num'] !=''){
            $res_add = $this->cartService->addDuplicateIgnore($data);//插入数据，当重复时忽略
            if($res_add){
                $respon=array('status'=>'1','msg'=>'添加购物车成功！');
                exit(json_encode($respon,true));
            }else{
                $respon=array('status'=>'1','msg'=>'添加购物车失败！');
                exit(json_encode($respon,true));
            }
        }else{
            $respon=array('status'=>'0','msg'=>'参数错误');
            exit(json_encode($respon,true));
        } 
    }
    
    

}