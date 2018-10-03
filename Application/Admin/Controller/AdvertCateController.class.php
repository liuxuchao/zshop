<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\AdvertCateService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class AdvertCateController extends AdminBaseController
{
	private $advertCateService = null;
	function __construct()
	{
		parent::__construct();
		$this->advertCateService = new AdvertCateService();
	}


	/**
	 *广告分类列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 20, 'intval');
        $where = array();
        //获取总数
        $tCount = $this->advertCateService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $cateList = $this->advertCateService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        //获取分类下商品数量
        
        if($cateList){
            foreach($cateList as $key=>&$val){
                if($val['fid']==0){
                    $val['name'] = '顶级分类';
                }else{
                   $parentData = $this->advertCateService->getByPrimaryKey($val['fid']);
                    $val['parent_name'] = $parentData['cate_name']; 
                }
                $which_cate = array('cate_id'=>$val['cate_id']);
                $productNum = $this->advertCateService->countByCondition($which_cate);
                $val['product_num'] = $productNum;
            }
        }
        //获取分类下数据总数
        //$cateList['product_totle'] = '12';
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('cateList', $cateList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
		$this->display();
	}


    /**
     * 添加广告分类
     *
     */
    public function addAdvType(){
        $resTree = $this->advertCateService->gettree();
        $this->assign('tree',$resTree);
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
        $data = $this->receive_update_parames();
        if(empty($data['cate_name'])){
            $this->error('商品分类名称不能为空','/Admin/ProductCate/updates/id'.$data['id'],2);
            return;
        }
        $data['update_time'] = time();
        $data['update_ip'] = get_client_ip();
        $upResult = $this->productcateService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/ProductCate/updates/id/'.$data['id'],2);
            return;
        }
        $oldData = $this->productcateService->findByName($data['cate_name']);
        if($oldData['parent_id'] != $data['parent_id']){
            if($oldData['parent_id']==0 && $data['parent_id']>0){               //顶级分类改成子分类
                $upToCateDate = $this->productcateService->getByPrimaryKey($data['parent_id']);
                $updateData = ['has_child'=>1,'arr_childid'=>trim($upToCateDate['arr_childid'].",".$data['id'],",")];
                $this->productcateService->updateByPrimaryKey($data['parent_id'], $updateData);
            }elseif($oldData['parent_id']>0 && $data['parent_id']==0){          //子分类改成顶级分类

                $upToCateDate = $this->productcateService->getByPrimaryKey($oldData['parent_id']);
                $oldChilds = explode(",",$upToCateDate['arr_childid']);
                if(count($oldChilds)==1){
                    $updateData = ['has_child'=>0,'arr_childid'=>''];
                }elseif(count($oldChilds)>1){
                    $tmpArrChildid = '';
                    foreach($oldChilds as $val){
                        if($val != $data['id']){
                            $tmpArrChildid .= ','.$val;
                        }
                    }
                    $tmpArrChildid = trim($tmpArrChildid,",");
                    $updateData = ['arr_childid'=>$tmpArrChildid];
                    $this->productcateService->updateByPrimaryKey($oldData['parent_id'], $updateData);
                }
            }
            $this->success('修改成功', '/Admin/ProductCate/index', 2);
            return;
        }else{
            $this->success('修改成功', '/Admin/ProductCate/index', 2);
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
        //检查有无子分类，如果有子分类不能删除，
        $resFindChild = $this->productcateService->findChildCateById($cateId);
        if($resFindChild){
            $result = ['error_code'=>'1','message'=>'有子分类不能删除'];
            echo json_encode($result);
            return;
        }
        //  检查有无商品 如果有不能删除  商品做完了加上
        $data = $this->productcateService->doDelete($cateId);
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
     *添加广告分类
     */
    public function doAdd(){
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_add_parames();
        
        if(empty($data['name'])){
            $this->error('广告分类名称不能为空','/Admin/AdvertCate/addAdvType',2);
            return;
        } 
        $fData = $this->advertCateService->findByName($data['name']);
        if ($fData) {
            $this->error('广告分类已经存在','/Admin/AdvertCate/addAdvType',2);
            return;
        }
        $data['create_time'] = time();
        $addresult = $this->advertCateService->add($data);
        
        if ($addresult && $data['fid']>0){
            //添加分类完成后修改非顶级的父级分类的has_child arrchildid
             // 获取父级分类信息 
              // 如果无子分类 将has_child=1，arrchildid 添加 $addresult['id'],
              // 如果有子分类 将arr_childid字符串添加新的 $addresult['id'],
            $resParent = $this->advertCateService->getByPrimaryKey($data['fid']);
            $parentData=array();
            if($resParent['has_child'] == 0){
                $parentData['has_child'] = 1;
                $parentData['arr_childid']= $addresult;
            }else{
                $parentData['arr_childid']= $resParent['arr_childid'].','.$addresult;
            }
            $fData = $this->advertCateService->updateByPrimaryKey($data['fid'],$parentData);
            if($fData){
                $this->success('分类添加成功','/Admin/AdvertCate/index',2);
                return;
            }else{
                $this->advertCateService->deleteByPrimaryKey($addresult);
                $this->error('分类添加失败','/Admin/AdvertCate/add',2);
                return;
            }
        }elseif ($addresult && $data['fid']==0) {
            $this->success('分类添加成功','/Admin/AdvertCate/index',2);
            return;
        }else{
            $this->error('分类添加失败','/Admin/AdvertCate/add',2);
            return; 
        }
    }



    /*
    *  接收添加分类post参数
    * 
    */
    private function receive_add_parames(){
        $data = [];
        $data['cate_name'] = I('post.cate_name','','strip_tags');
        $data['description'] = I('post.description','','strip_tags');
        $parent_id = I('post.parent_id','','strip_tags');
        $data['parent_id'] = $parent_id != '0' ? $parent_id : 0;
        return $data;
    }


    /**
     *  接收修改分类post参数
     * 
     */
    private function receive_update_parames(){
        $data = [];
        $data['id'] = I('post.id','','strip_tags');
        $data['cate_name'] = I('post.cate_name','','strip_tags');
        $data['description'] = I('post.description','','strip_tags');
        $parent_id = I('post.parent_id','','strip_tags');
        $data['parent_id'] = $parent_id != '0' ? $parent_id : 0;
        return $data;
    }
}