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
        	$where['sOrderNo'] = array('like','\'%'.$param['order_id'].'%\'');
        }


        //开始时间
        if (!empty($param['srtime'])) {
        	$where['iCreateTime'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        }

        //结束时间
        if (!empty($param['ertime'])) {
        	$where['iCreateTime'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        }

        $orderBy = ' iCreateTime desc';
        
    	//获取总数
        $tCount = $this->refundService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->refundService->getRefundList($tPage, $tPageSize,$orderBy,$where);

		foreach ($advertList as $key => $value) {

            if ($value['iStatus'] == -1) {
                $advertList[$key]['statusName']  = '商家拒绝';
            }elseif ($value['status'] == 2) {
                $advertList[$key]['statusName']  = '待处理';
            }elseif ($value['status'] == 3) {
                $advertList[$key]['statusName']  = '已完成';
            }
			
			$advertList[$key]['creatime'] = date("Y-m-d",$value['iCreateTime']) ;
            $advertList[$key]['iOperationDate'] = date("Y-m-d",$value['iOperationDate']) ;
		}
		
		$this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('refundList', $advertList);
        $this->assign('currentPage', $tPage);
		$this->display();
	}


    /**
     * 退款显示
     */
    public function updateRefund(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->refundService->getByPrimaryKey($Id);
        
        $this->assign('data', $data);
        $this->display();
    }


    /**
     *
     */
    public function doUpdate(){
    	//接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = [];
        $data['sOrderNo'] = I('post.sOrderNo','','strip_tags');
        $data['fAmonut'] = I('post.fAmonut','','strip_tags');
        $data['fPayAmonut'] = I('post.fPayAmonut','','strip_tags');
        $iStatus = I('post.iStatus','','strip_tags');
        $data['iStatus'] = $iStatus != '0' ? $iStatus : 0;
        $data['iOpreation'] = time();
        if(empty($data['name'])){
            $this->error('分类名称不能为空','/Admin/Coupon/updateCoupon/id'.$data['id']);
            return;
        }

        $upResult = $this->refundService->updateByPrimaryKey($data['sOrderNo'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Refund/doUpdate/sOrderNo/'.$data['sOrderNo']);
            return;
        }else{
        	$this->success('修改成功','/Admin/Refund/index');
            return;
        }
    }


    /**
     * 删除
     */
    public function doDelete(){
    	$sOrderNo = I('sOrderNo', '', 'htmlspecialchars');
       
        if (empty($sOrderNo)) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }

        $data = $this->refundService->doDelete($sOrderNo);
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