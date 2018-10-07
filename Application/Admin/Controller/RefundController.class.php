<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\RefundService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class RefundController extends AdminBaseController
{
	private $refundService = null;
	function __construct()
	{
		parent::__construct();
		$this->refundService = new RefundService();
	}


	/**
	 *发票列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');

        $where = array();

        if (!empty($param['order_id'])) {
        	$where['order_id'] = array('like','\'%'.$param['order_id'].'%\'');
        }


        //开始时间
        if (!empty($param['srtime'])) {
        	$where['create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        }

        //结束时间
        if (!empty($param['ertime'])) {
        	$where['create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        }

        $orderBy = ' create_time desc';
        
    	//获取总数
        $tCount = $this->refundService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->refundService->getInvoiceList($tPage, $tPageSize,$orderBy,$where);

		foreach ($advertList as $key => $value) {
            if ($value['type'] == 1) {
                $advertList[$key]['typeName']  = '电子发票';
            }else  {
                $advertList[$key]['typeName']  = '纸质发票';
            }
            

            if ($value['status'] == 1) {
                $advertList[$key]['statusName']  = '已发电子邮箱';
            }elseif ($value['status'] == 2) {
                $advertList[$key]['statusName']  = '已打印';
            }elseif ($value['status'] == 3) {
                $advertList[$key]['statusName']  = '已发快递';
            }else {
                $advertList[$key]['statusName']  = '未操作';
            }

            if ($value['invoice_type'] == 1) {
                $advertList[$key]['invoceName']  = '普票';
            }elseif ($value['invoice_type'] == 2) {
                $advertList[$key]['invoceName']  = '专票';
            }else{
                $advertList[$key]['invoceName']  = '未设置';
            }
			
			$advertList[$key]['creatime'] = date("Y-m-d",$value['create_time']) ;
            $advertList[$key]['useing_time'] = date("Y-m-d",$value['useing_time']) ;
		}
		
		$this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('invoiceList', $advertList);
        $this->assign('currentPage', $tPage);
		$this->display();
	}


    /**
     * 修改广告
     */
    public function updateCoupon(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->refundService->getByPrimaryKey($Id);
        //开始时间
        $where['startTime'] = array('egt',strtotime(date('Y-m-d',time()).' 00:00:00'));
        //结束时间
        $where['endTime'] = array('elt',strtotime(date('Y-m-d',time()).' 23:59:59'));
        $activityInfo = $this->activityService->getActivityInfo($where);
        $this->assign('activityInfo',$activityInfo);
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
        $data['name'] = I('post.name','','strip_tags');
        $data['amount'] = I('post.amount','','strip_tags');
        $data['use_from_time'] = strtotime(I('post.use_from_time','','strip_tags'));
        $data['use_end_time'] = strtotime(I('post.use_end_time','','strip_tags'));
        $limit_num = I('post.limit_num','','strip_tags');
        $data['limit_num'] = $limit_num != '0' ? $limit_num : 0;
        $activity_id = I('post.activity_id','','strip_tags');
        $data['activity_id'] = $activity_id != '0' ? $activity_id : 0;
        $status = I('post.status','','strip_tags');
        $data['status'] = $status != '0' ? $status : 0;
        if(empty($data['name'])){
            $this->error('分类名称不能为空','/Admin/Coupon/updateCoupon/id'.$data['id']);
            return;
        }

        $upResult = $this->refundService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Coupon/updateCoupon/id/'.$data['id']);
            return;
        }else{
        	$this->error('修改成功','/Admin/Coupon/index');
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

        $data = $this->refundService->doDelete($Id);
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