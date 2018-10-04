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
        if (!empty($param['cate_id'])) {
            $where['id'] = $param['cate_id'];
        }
        //获取总数
        $tCount = $this->advertCateService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $cateList = $this->advertCateService->getList($where, $tPage, $tPageSize, [], 'id DESC');

        //获取分类下商品数量
        
        if($cateList){
            foreach($cateList as $key=>&$val){
                if($val['fid']==0){
                    $val['parent_name'] = '顶级分类';
                }else{
                   $parentData = $this->advertCateService->getByPrimaryKey($val['fid']);
                    $val['parent_name'] = $parentData['name']; 
                }
                $which_cate = array('fid'=>$val['id']);
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
     * 显示更新页面
     */

    public function updates()
    {
        $Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->advertCateService->getByPrimaryKey($Id);
        $resTree = $this->advertCateService->gettree();
        $this->assign('data', $data);
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
        if(empty($data['name'])){
            $this->error('分类名称不能为空','/Admin/AdvertCate/updates/id'.$data['id'],2);
            return;
        }

        $upResult = $this->advertCateService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/AdvertCate/updates/id/'.$data['id'],2);
            return;
        }
        $oldData = $this->advertCateService->findByName($data['name']);
        if($oldData['fid'] != $data['fid']){
            if($oldData['fid']==0 && $data['fid']>0){               //顶级分类改成子分类
                $upToCateDate = $this->advertCateService->getByPrimaryKey($data['fid']);
                $updateData = ['has_child'=>1,'arr_childid'=>trim($upToCateDate['arr_childid'].",".$data['id'],",")];
                $this->advertCateService->updateByPrimaryKey($data['fid'], $updateData);
            }elseif($oldData['fid']>0 && $data['fid']==0){          //子分类改成顶级分类

                $upToCateDate = $this->advertCateService->getByPrimaryKey($oldData['fid']);
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
                    $this->advertCateService->updateByPrimaryKey($oldData['fid'], $updateData);
                }
            }
            $this->success('修改成功', '/Admin/AdvertCate/index', 2);
            return;
        }else{
            $this->success('修改成功', '/Admin/AdvertCate/index', 2);
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
        $resFindChild = $this->advertCateService->findChildCateById($cateId);
        if($resFindChild){
            $result = ['error_code'=>'1','message'=>'有子分类不能删除'];
            echo json_encode($result);
            return;
        }
        //  检查有无商品 如果有不能删除  商品做完了加上
        $data = $this->advertCateService->doDelete($cateId);
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
                $this->error('分类添加失败','/Admin/AdvertCate/addAdvType',2);
                return;
            }
        }elseif ($addresult && $data['fid']==0) {
            $this->success('分类添加成功','/Admin/AdvertCate/index',2);
            return;
        }else{
            $this->error('分类添加失败','/Admin/AdvertCate/addAdvType',2);
            return; 
        }
    }



    /*
    *  接收添加分类post参数
    * 
    */
    private function receive_add_parames(){
        $data = [];
        $data['name'] = I('post.name','','strip_tags');
        $data['desc'] = I('post.desc','','strip_tags');
        $fid = I('post.fid','','strip_tags');
        $data['fid'] = $fid != '0' ? $fid : 0;
        return $data;
    }


    /**
     *  接收修改分类post参数
     * 
     */
    private function receive_update_parames(){
        $data = [];
        $data['id'] = I('post.id','','strip_tags');
        $data['name'] = I('post.name','','strip_tags');
        $data['desc'] = I('post.desc','','strip_tags');
        $fid = I('post.fid','','strip_tags');
        $data['fid'] = $fid != '0' ? $fid : 0;
        return $data;
    }


    /**
     * ajax 检查分类名称是否存在
     */
    public function ajaxCheckCateName()
    {
        $data['name'] = I('post.name','','trim,strip_tags');
        $data['type'] = I('post.type','','intval');
        $hasName = $this->advertCateService->findByName($data['name']);
        if($data['type']==1 && $hasName['name'] == $data['name']){
             exit('{"valid":true}');
        }
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
}