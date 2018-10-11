<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\ShopService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class ShopController extends AdminBaseController
{
	private $shopService = null;
	function __construct()
	{
		parent::__construct();
		$this->shopService = new ShopService();
	}


	/**
	 *门店列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');

        $where = array();

        if (!empty($param['name'])) {
        	$where['sname'] = array('like','\'%'.$param['name'].'%\'');
        }


        // //开始时间
        // if (!empty($param['srtime'])) {
        // 	$where['ad.create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        // 	$wheres['create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        // }

        // //结束时间
        // if (!empty($param['ertime'])) {
        // 	$where['ad.create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        // 	$wheres['create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        // }

        $orderBy = ' id desc';
        
    	//获取总数
        $tCount = $this->shopService->countByCondition($where); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$shopList = $this->shopService->getShopList($tPage, $tPageSize,$orderBy,$where);
	
		$this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('advertList', $shopList);
        $this->assign('currentPage', $tPage);
		$this->display();
	}


    /**
     * 添加广告
     *
     */
    public function addShop(){
        $this->display();
    }


    public function doAdd(){
    	$data = [];
        $data['sname'] = I('post.sname','','strip_tags');
        $data['pname'] = I('post.pname','','strip_tags');
        $data['jname'] = I('post.jname','','strip_tags');
        $data['xname'] = I('post.xname','','strip_tags');
        $data['lon'] = I('post.lon','','strip_tags');
        $data['lat'] = I('post.lat','','strip_tags');
        $data['address'] = I('post.address','','strip_tags');
       
       // $data['create_time'] = time();

        if (empty($data['sname'])) {
        	$this->error('门店名称不能为空','/Admin/Shop/addAdv');
            return;
        }

        $addresult = $this->shopService->add($data);
        if($addresult){
        	$this->success('门店添加成功','/Admin/Shop/index');
            return;
        }else{
        	$this->success('门店添加失败','/Admin/Shop/addShop');
        }
    }


    /**
     * 修改广告
     */
    public function updateShop(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->shopService->getByPrimaryKey($Id);
        $this->assign('data', $data);
        $this->display();
    }


    /**
     *
     */
    public function doApdate(){
    	//接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = [];
        $data['id'] = I('post.id','','strip_tags');
        $data['sname'] = I('post.sname','','strip_tags');
        $data['pname'] = I('post.pname','','strip_tags');
        $data['jname'] = I('post.jname','','strip_tags');
        $data['xname'] = I('post.xname','','strip_tags');
        $data['lon'] = I('post.lon','','strip_tags');
        $data['lat'] = I('post.lat','','strip_tags');
        $data['address'] = I('post.address','','strip_tags');
        if(empty($data['sname'])){
            $this->error('门店名称不能为空','/Admin/Shop/updateShop/id'.$data['id']);
            return;
        }

        $upResult = $this->shopService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Shop/updateShop/id/'.$data['id']);
            return;
        }else{
        	$this->error('修改成功','/Admin/Shop/index');
            return;
        }
    }


    /**
     * 删除
     */
    public function doDelete(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
       
        if (0 >= $Id) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }

        $data = $this->shopService->doDelete($Id);
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