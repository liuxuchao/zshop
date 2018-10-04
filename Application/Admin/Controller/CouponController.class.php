<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\CouponService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class CouponController extends AdminBaseController
{
	private $couponService = null;
	function __construct()
	{
		parent::__construct();
		$this->couponService = new CouponService();
	}


	/**
	 *广告列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');

        $where = array();
        $wheres = array();

        if (!empty($param['name'])) {
        	$where['ad.name'] = array('like','\'%'.$param['name'].'%\'');
        	$wheres['name'] = array('like','\'%'.$param['name'].'%\'');
        }


        //开始时间
        if (!empty($param['srtime'])) {
        	$where['ad.create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        	$wheres['create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        }

        //结束时间
        if (!empty($param['ertime'])) {
        	$where['ad.create_time'] = array('egt',strtotime($keyWord['ertime'].' 23:59:59'));
        	$wheres['create_time'] = array('egt',strtotime($keyWord['ertime'].' 23:59:59'));
        }

        $orderBy = ' ad.create_time desc';
        
    	//获取总数
        $tCount = $this->couponService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->couponService->getAdvertList($tPage, $tPageSize,$orderBy,$where);

		foreach ($advertList as $key => $value) {
			$advertList[$key]['statusName'] = ($value['status'] == 1) ? '正常':'禁用';
			$advertList[$key]['creatime'] = date("Y-m-d",$value['create_time']) ;
		}
		
		$this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('advertList', $advertList);
        $this->assign('currentPage', $tPage);
		$this->display();
	}


    /**
     * 添加优惠券
     *
     */
    public function addCoupon(){
    	$resTree = $this->advertCateService->getTree();
        $this->assign('tree',$resTree);
        $this->display();
    }


    public function doAdd(){
    	$data = [];
        $data['name'] = I('post.name','','strip_tags');
        $data['postion_desc'] = I('post.postion_desc','','strip_tags');
        $data['ad_link'] = I('post.ad_link','','strip_tags');
        $data['img_url'] = I('post.group_img','','strip_tags');
        $cate_id = I('post.cate_id','','strip_tags');
        $data['type_id'] = $cate_id != '0' ? $cate_id : 0;
        $data['create_time'] = time();

        if (empty($data['name'])) {
        	$this->error('广告名称不能为空','/Admin/Advert/addAdv');
            return;
        }

        $addresult = $this->advertService->add($data);
        if($addresult){
        	$this->success('广告添加成功','/Admin/Advert/index');
            return;
        }else{
        	$this->success('广告添加失败','/Admin/Advert/addAdv');
        }
    }


    /**
     * 修改广告
     */
    public function updateAdv(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->advertService->getByPrimaryKey($Id);
        $resTree = $this->advertCateService->gettree();
        $this->assign('data', $data);
        $this->assign('tree',$resTree);
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
        $data['name'] = I('post.name','','strip_tags');
        $data['postion_desc'] = I('post.postion_desc','','strip_tags');
        $data['ad_link'] = I('post.ad_link','','strip_tags');
        $data['img_url'] = I('post.group_img','','strip_tags');
        $cate_id = I('post.cate_id','','strip_tags');
        $data['type_id'] = $cate_id != '0' ? $cate_id : 0;
        $data['create_time'] = time();
        if(empty($data['name'])){
            $this->error('分类名称不能为空','/Admin/Advert/updateAdv/id'.$data['id']);
            return;
        }

        $upResult = $this->advertService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Advert/updateAdv/id/'.$data['id']);
            return;
        }else{
        	$this->error('修改成功','/Admin/Advert/index');
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

        $data = $this->advertService->doDelete($Id);
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