<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\ProductService;
use Common\Service\Zshop\ProductCateService;
use Common\Service\Zshop\ProductAttrService;
use Common\Service\Zshop\SkuService;
class ProductController extends AdminBaseController
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
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->productService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $productList = $this->productService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        //显示商品分类
        $resTree = $this->productcateService->gettree();
        if($productList){
            foreach($productList as $key=>&$val){
                $parentData = $this->productcateService->getByPrimaryKey($val['cate_id']);
                $val['parent_name'] = $parentData['cate_name']; 
            }
        }
        $this->assign('tree',$resTree);
        $this->assign('tree_child',$resTree);
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('productList', $productList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    /**
     * 显示添加商品页面
     */
    public function add()
    {
        $resTree = $this->productcateService->gettree();
        $this->assign('tree',$resTree);
        $this->display();
    }
    /**
     * ajax获取当前分类下的商品分类属性
     * @param cate_id 
     * return  html 
     */
    public function ajaxgetAttrByCate()
    {
        $catId = I('post.cate_id','','trim,strip_tags');
        $resAttr = $this->productattrService->getAttrByCate($catId);
        if($resAttr){
            exit($this->buildAjaxHtml($resAttr));
        }else{
            exit(json_encode(["error_code"=>'1',"msg"=>'该类商品暂无添加属性'],true));
        }
    }
    
    
    /**
     * 根据数组的数值生成属性的input html 
     * @param type $data    使用的数据 
     */
    private function buildAjaxHtml($data)
    {
        $strs = array("text"=>'',"radio"=>'',"checkbox"=>'',"select"=>'');
        $skuData = [];
        foreach($data as $key=>$val){
                if($val['is_sku']==0){
                   if($val['types']==0){
                        $strs['text'].='<div class="col-lg-5 col-md-5 input-group" style="height:34px;line-height:34px"><label for="'.$val['attr_en'].'" class="col-lg-2 col-sm-2 control-label" style="padding:0 5px;">'.$val['attr_cn'].'：</label><div class="col-lg-10 col-md-10 input-group"><input type="text" name="attr['.$val['attr_en'].']" class="form-control" id="'.$val['attr_en'].'" value="" placeholder="'.$val['attr_cn'].'"></div></div>';
                   }
                }elseif($val['is_sku']==1){
                   array_push($skuData,$val); 
                }
            }
        $skuHtml = $this->buildSkuHtml($skuData);
        $Html = implode('',$strs);
        return json_encode(["error_code"=>'0',"input"=>$Html,"sku"=>$skuHtml],true);
    }

    /**
     * 生成SKU属性的html
     * @param type $data
     */
    private function buildSkuHtml($data)
    {
        if(empty($data)){
            return '';
        }
        $listOfAttr = [];
        $listKeyOfAttr = [];
        $keyName = [];
        foreach ($data as $key=>$val){
            $listKeyOfAttr[$key] = $val['attr_en'];
            $listOfAttr[$key]= explode(",",$val['json_values']);
            $keyName[$key] = $val['attr_cn'].$val['unit'];
        }
        $list = $this->getArrSet($listOfAttr);
        if(empty($list) || empty($keyName)){
            return '';
        }
        $html = '<table class="table table-bordered" id="skus"><tr>';
        foreach($keyName as $vals){
            $html .= "<th>".$vals."</th>";
        }
        $html .= '<th>价格</th><th>库存</th></tr>';
        foreach ($list as $k=>$v){
            $tmpTr = '<tr>';
            $name = '';
            foreach($v as $d){
                //$valueArray = explode("|",$d);
                $name .= "_".$d;
                $tmpTr .="<td>".$d."</td>";
            }
            $name = trim($name,"_");
            $tmpTr .= '<td><input type="text" class="form-control attr_prices" value="0.00" name="sku['.$name.'_price]" style="padding:0"></td>';
            $tmpTr .= '<td><input type="text" class="form-control attr_stock_number" value="0" name="sku['.$name.'_stock_number]" style="padding:0"></td>';
            $html .= $tmpTr."</tr>";
        }
        $html .="</table>";
        return $html;
    }
    
    /**
     * 生成排列组合不重复的数据  的算法
     * @staticvar type $_total_arr //总数组
     * @staticvar int $_total_arr_index//总数组下标计数
     * @staticvar type $_total_count//输入的数组长度
     * @staticvar type $_temp_arr//临时拼凑数组
     * @param type $arrs
     * @param type $_current_index
     * @return type
     */
    private function getArrSet($arrs, $_current_index = -1)
    {
        static $_total_arr=0;
        static $_total_arr_index=0; 
        static $_total_count=0; 
        static $_temp_arr=array(); 
        //进入输入数组的第一层，清空静态数组，并初始化输入数组长度
        if ($_current_index < 0) {
            $_total_arr = array();
            $_total_arr_index = 0;
            $_temp_arr = array();
            $_total_count = count($arrs) - 1;
            $this->getArrSet($arrs, 0);
        } else {
            foreach ($arrs[$_current_index] as $v) {//循环第$_current_index层数组
                if ($_current_index < $_total_count) {//如果当前的循环的数组少于输入数组长度
                    $_temp_arr[$_current_index] = $v; //将当前数组循环出的值放入临时数组

                    $this->getArrSet($arrs, $_current_index + 1); //继续循环下一个数组
                } else if ($_current_index == $_total_count) {//如果当前的循环的数组等于输入数组长度(这个数组就是最后的数组)
                    $_temp_arr[$_current_index] = $v; //将当前数组循环出的值放入临时数组 
                    $_total_arr[$_total_arr_index] = $_temp_arr; //将临时数组加入总数组 
                    $_total_arr_index++; //总数组下标计数+1
                }
            }
        }
        return $_total_arr;
    }

    public function ajaxgetAttrByCateAndValue()
    {
        $catId = I('post.cate_id','','intval');
        $productId = I('post.product_id','','intval');
        $resAttr = $this->productattrService->getAttrByCate($catId);
        if($resAttr){
            if($productId >0){
                exit($this->buildAjaxHtmlAndSelected($resAttr,$productId));
            }
            exit($this->buildAjaxHtml($resAttr));
        }else{
            exit('该类商品暂无添加属性');
        }
    }
    
    
    /**
     * 根据数组的数值生成属性的input html 
     * @param type $data    使用的数据 
     */
    private function buildAjaxHtmlAndSelected($data,$productId)
    {
        $productInfo = $this->productService->getByPrimaryKey($productId);
        $attrs = json_decode($productInfo['attributes'],true);
        $strs = array("text"=>'',"radio"=>'',"checkbox"=>'',"select"=>'');
        
        foreach($data as $key=>&$val){
            if($val['is_sku']==0){
                if($val['types']==0){   //单行文本
                    if(array_key_exists($val['attr_en'], $attrs) && !empty($attrs[$val['attr_en']])){
                        $tmpValue = $attrs[$val['attr_en']];
                    }else{
                        $tmpValue = '';
                    }
                    
                    $strs['text'].='<div class="col-lg-5 col-md-5 input-group" style="height:34px;line-height:34px"><label for="'.$val['attr_en'].'" class="col-lg-2 col-sm-2 control-label" style="padding:0 5px;">'.$val['attr_cn'].'：</label><div class="col-lg-10 col-md-10 input-group"><input type="text" name="attr['.$val['attr_en'].']" class="form-control" id="'.$val['attr_en'].'" value="'.$tmpValue.'" placeholder="'.$val['attr_cn'].'"></div></div>';
                }elseif($val['types']==1){  //下拉选项
                    $json_values = trim($val['json_values'],',');
                    $arr_select = explode(',',$json_values);
                    $option_select = '';
                    if(array_key_exists($val['attr_en'], $attrs) && $attrs[$val['attr_en']]){
                        $tmpValue = $attrs[$val['attr_en']];
                    }else{
                        $tmpValue = '';
                    }
                    foreach($arr_select as $key=>$value){
                        if($value == $tmpValue && !empty($tmpValue)){
                            $option_select .='<option value="'.$key.'" selected="selected">'.$value.'</option>';
                        }else{
                            $option_select .='<option value="'.$key.'">'.$value.'</option>';
                        }
                        
                    }
                    $strs['select'] .='<div class="col-lg-5 col-md-5 input-group" style="height:34px;line-height:34px"><label for="'.$val['attr_en'].'" class="col-lg-2 col-md-2 col-sm-2 control-label" style="padding:0 5px;">'.$val['attr_cn'].'：</label><div class="col-lg-5 col-md-5"><select class="form-control" name="attr['.$val['attr_en'].']" id="'.$val['attr_en'].'">'.$option_select.'</select></div></div>';
                }elseif($val['types']==2){  //单选按钮
                    $json_values = trim($val['json_values'],',');
                    $arr_radio = explode(',',$json_values);
                    $radios = '';
                    if(array_key_exists($val['attr_en'], $attrs) && $attrs[$val['attr_en']]){
                        $tmpValue = $attrs[$val['attr_en']];
                    }else{
                        $tmpValue = '';
                    }
                    
                    foreach($arr_radio as $value){
                        if($value == $tmpValue && !empty($tmpValue) ){
                           $radios .='<label class="radio-inline" style="padding-top:0;"><input type="radio" name="attr['.$val['attr_en'].']" value="'.$value.'" checked="checked" style="margin-top:11px;">'.$value.'</label>'; 
                        }else{
                           $radios .='<label class="radio-inline" style="padding-top:0;"><input type="radio" name="attr['.$val['attr_en'].']" value="'.$value.'" style="margin-top:11px;">'.$value.'</label>'; 
                        }
                    }
                    $strs['radio'] .='<div class="col-lg-5 col-md-5 input-group" style="height:34px;line-height:34px"><label for="'.$val['attr_en'].'" class="col-lg-2 col-sm-2 control-label" style="padding:0 5px;">'.$val['attr_cn'].'：</label><div class="col-lg-10 col-md-10 input-group">'.$radios.'</div></div>';
                }
            }
                
                
        }
            return implode('',$strs);
    }
    /**
     * ajax 检查商品名称是否存在
     */
    public function ajaxCheckProductName()
    {
        $data['product_name'] = I('post.product_name','','trim,strip_tags');
        $data['type'] = I('post.type','','intval');
        $hasName = $this->productService->findByName($data['product_name']);
        if($data['type']==1 && $hasName['product_name'] == $data['product_name']){
             exit('{"valid":true}');
        }
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    
    /*
     * 商品分类添加
     */
    public function doAdd ()
    {
       //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_add_parames();
        
        //准备数据
        $data['create_time'] = time();
        $data['create_ip'] = get_client_ip();
        $data['status'] = 1;//商品状态默认为1 即添加就可以显示
        $skus = $data['skus'];
        $arrayOfSku = array();
        foreach($skus as $key=>$val){
            if(strpos($key,"_price")){
                $trimKey = trim(str_replace("_price"," ", $key));
            }elseif(strpos($key,"_stock_number")){
                $trimKey = trim(str_replace("_stock_number"," ", $key));
            }
            if(!isset($arrayOfSku[$trimKey])){
                $arrayOfSku[$trimKey] = ["price"=>$skus[$trimKey."_price"],"stock_number"=>$skus[$trimKey."_stock_number"]];
            }else{
                continue;
            }
        }
        unset($data['skus']);
        $addresult = $this->productService->add($data);
        if($addresult){

            //上传完成后将缩略图图片添加至 资源表中
             //准数据
//            $source=[];
//            $source['source_id']=$addresult;
//            $source['type_id']=1;
//            $source['source_type']=0;
//            $source['url']=$data['thumb'];
//            $source['create_time'] = time();
//            $source['create_ip'] = get_client_ip();

            //$addsource = $this->sourceService->add($source);
            //添加商品sku属性
            if($arrayOfSku){
                foreach($arrayOfSku as $k=>$v)
                {
                    $v['product_id'] = $addresult;
                    $v['sku_key'] = $k;
                    $v['create_time'] = time();
                    $this->skuService->add($v);
                }
                
            }
            $this->success('商品添加成功','/Admin/Product/index',2);
            return;
        }else{
            $this->error('商品添加失败','/Admin/Product/add',2);
            return; 
        }

    }
    /*
    *  接收添加分类post参数
    * 
    */
    private function receive_add_parames(){
        $data = [];
        $data['cate_id'] = I('post.cate_id','','trim,strip_tags');
        $data['product_name'] = I('post.product_name','','trim,strip_tags');
        $data['small_title'] = I('post.small_title','','trim,strip_tags');
        $data['price'] = I('post.price','','trim');
        $data['market_price'] = I('post.market_price','','trim');
        $data['commodity_number'] = I('post.commodity_number','','intval');
        $data['stock_number'] = I('post.stock_number','','intval');
        $data['integral'] = I('post.integral','','intval');
        $data['thumb'] = I('post.thumb','','trim,strip_tags');
        $data['description'] = I('post.description','','trim,strip_tags');
        $data['contents'] = I('post.contents','','trim');
        $data['group_img'] = I('post.group_img','','trim,strip_tags');
        $data['group_img'] = trim($data['group_img'],',');
        $data['attributes'] = json_encode(I('post.attr','','trim,strip_tags'));
        $data['skus'] = I('post.sku','','trim,strip_tags');
        return $data;
    }
    /*
     * 显示更新页面
     */

    public function updates()
    {
        $id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->productService->getByPrimaryKey($id);
        $resTree = $this->productcateService->gettree();
        $sku = $this->skuService->getSkuByProductId($id);//拿到已经存在的sku
        $sku_attr_name = $this->productattrService->getSkuAttrNameByCateId($data['cate_id']);
        
        $this->assign('tree',$resTree);
        $this->assign('data', $data);
        $this->assign('sku', $sku);
        $this->assign('sku_name', $sku_attr_name);
        $this->display();
    }
    /*
     * 显示更新页面的组图
     */
    public function getGroupImg()
    {
        $id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->productService->getByPrimaryKey($id);
        $group_img = explode(',', $data['group_img']);
        $arr_keys = array_flip($group_img);
        echo json_encode($arr_keys,true);
        return;
    }
        /*
    *  接收添加分类post参数
    * 
    */
    private function receive_update_parames(){
        $data = [];
        $data['id'] = I('post.id','','intval');
        $data['cate_id'] = I('post.cate_id','','trim,strip_tags');
        $data['product_name'] = I('post.product_name','','trim,strip_tags');
        $data['small_title'] = I('post.small_title','','trim,strip_tags');
        $data['price'] = I('post.price','','trim,strip_tags');
        $data['market_price'] = I('post.market_price','','trim,strip_tags');
        $data['commodity_number'] = I('post.commodity_number','','intval');
        $data['stock_number'] = I('post.stock_number','','intval');
        $data['integral'] = I('post.integral','','intval');
        $data['thumb'] = I('post.thumb','','trim,strip_tags');
        $data['description'] = I('post.description','','trim,strip_tags');
        $data['contents'] = I('post.contents','','trim');
        $data['group_img'] = I('post.group_img','','trim,strip_tags');
        $data['group_img'] = trim($data['group_img'],',');
        $attrs = json_encode(I('post.attr','','trim,strip_tags'));
        $data['attributes'] = $attrs;
        $data['skus'] = I('post.sku','','trim,strip_tags');
        return $data;
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
        $data = $this->receive_update_parames();
        if(empty($data['product_name'])){
            $this->error('商品名称不能为空','/Admin/Product/update/id'.$data['id'],2);
            return;
        }
        $data['update_time'] = time();
        $data['update_ip'] = get_client_ip();
        
        $skus = $data['skus'];
        $arrayOfSku = array();
        foreach($skus as $key=>$val){
            if(strpos($key,"_price")){
                $trimKey = trim(str_replace("_price"," ", $key));
            }elseif(strpos($key,"_stock_number")){
                $trimKey = trim(str_replace("_stock_number"," ", $key));
            }
            if(!isset($arrayOfSku[$trimKey])){
                $arrayOfSku[$trimKey] = ["price"=>$skus[$trimKey."_price"],"stock_number"=>$skus[$trimKey."_stock_number"]];
            }else{
                continue;
            }
        }
        unset($data['skus']);
        $upResult = $this->productService->updateByPrimaryKey($data['id'],$data);
        if($arrayOfSku){
            foreach($arrayOfSku as $k=>$v)
            {
               $this->skuService->updateByPrimaryKey($k, $v);
            }
        }
        if ($upResult) {
            $this->success('修改成功'.$success, '/Admin/Product/index', 2);
            return;
        }
        $this->error('修改失败', '/Admin/Product/update/id'.$data['id'], 2);
        return;
    }

    /* 
    * 上架或者下架
    */
    public function changeStatus()
    {
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $id = I('post.id','','trim,strip_tags');
        $status = I('post.status','','trim,strip_tags');
        $status = $status ==0 ? 1 : 0;
        $data['status'] = $status;
        if(0>=$id){
            $this->error('参数错误', '/Admin/Product/index/', 2);
            return;
        }
        $upResult = $this->productService->updateByPrimaryKey($id,$data);
        if ($upResult) {
            $this->success('修改商品状态成功', '/Admin/Product/index', 2);
            return;
        }
        $this->error('修改商品状态失败', '/Admin/Product/index/', 2);
        return;
    }
    /*
     * 删除操作
     */
    public function doDelete()
    {
        $productId = I('id', '', 'intval,htmlspecialchars');
        if (0 >= $productId) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }
        $data = $this->productService->deleteByPrimaryKey($productId);
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
     * 商品前台显示样式 格式展示
     * 添加商品时候查看样式 无动态数据
     */
    
    public function templatesStyle()
    {
        $this->display();
    }


    /*
    * 上传 单图
    */
    public function thumbUpload()
    {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 3145728;
        $upload->rootPath = './Uploadfiles/';
        $upload->savePath = '';
        $upload->saveName = array('uniqid', '');
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->subName = array('date', 'Ymd');
        $info = $upload->uploadOne($_FILES['file']); // 上传文件
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功   图片处理 生成缩略图
            $image = new \Think\Image(); //实例化图片类
            $uploaded_img = './Uploadfiles/'. $info['savepath'] . $info['savename'];
            $image->open($uploaded_img); //打开物理图片
            $thumbResult = $image->save($uploaded_img);
            //赋值给html 绝对路径 
            $root_path= '/Uploadfiles/'. $info['savepath'] . $info['savename'];
            $d['status'] = '1';
            $d['info'] = '上传成功';
            $d['url'] = $root_path; //上传成功 返回给表单URL
            exit(json_encode($d, true));
        }
    }

    /*
     * 百度编辑器上传图片 包括多图上传
     */
    public function uploadUeditorImg()
    {
        date_default_timezone_set("Asia/Chongqing");
        error_reporting(E_ERROR);
        $configUrl = __ROOT__."/Ueditor/php/config.json";
	$ueditorFile = __ROOT__."/Ueditor/php/";
        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($configUrl)), true);
        $action = $_GET['action'];

        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
                $result = include($ueditorFile."action_upload.php");
                break;

            /* 列出图片 */
            case 'listimage':
                $result = include($ueditorFile."action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include($ueditorFile."action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include($ueditorFile."action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }
 

}
