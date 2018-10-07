<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\OrderService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class OrderController extends AdminBaseController
{
	private $orderService = null;
	public $orderType = 0;
	function __construct()
	{
		parent::__construct();
		$this->orderService = new OrderService();
		$this->orderType     = I('get.orderType', '', 'intval,htmlspecialchars');
		$this->assign('orderType', $this->orderType);
	}


	/**
	 *订单列表
	 */
	public function orderList(){

		$param = parent::_handleTime(I());
		$tPage = I('page', 1, 'intval');
                $tPageSize = I('page_size', 10, 'intval');

                $where = array();
                $where['sorder.order_type'] = $this->orderType;

                if ($param['date'] == 'today') {
        	       //php获取今日开始时间戳和结束时间戳
		      $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
		      $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        	       $where['sorder.create_time'] = array('egt',$beginToday);
        	       $where['sorder.create_time'] = array('elt',$endToday);
                }
        	
		if ($param['date'] == 'yesterday') {
        	       //php获取昨日起始时间戳和结束时间戳
		      $beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
		      $endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
        	       $where['sorder.create_time'] = array('egt',$beginYesterday);
        	       $where['sorder.create_time'] = array('elt',$endYesterday);
                }

                if ($param['date'] == 'week') {
        	       //php获取本周起始时间戳和结束时间戳
		      $beginWeek = strtotime(date('Y-m-d', strtotime("this week Monday", time())));
		      $endWeek = strtotime(date('Y-m-d', strtotime("this week Sunday", time()))) + 24 * 3600 - 1;
        	       $where['sorder.create_time'] = array('egt',$beginWeek);
        	       $where['sorder.create_time'] = array('elt',$endWeek);
                }

                if ($param['date'] == 'month') {
                	//php获取本周起始时间戳和结束时间戳
        		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
        		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
                	$where['sorder.create_time'] = array('egt',$beginThismonth);
                	$where['sorder.create_time'] = array('elt',$endThismonth);
                }

                //开始时间
                if (!empty($param['srtime'])) {
                	$where['sorder.pay_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
                }

                //结束时间
                if (!empty($param['ertime'])) {
                        $where['sorder.pay_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
                }

                if (!empty($param['ordersn'])) {
                        $where['sorder.order_code'] =  $param['ordersn'];
                }

                if (!empty($param['paytype'])) { 
                	echo $param['paytype'];die();
                	$where['sorder.pay_status'] =  $param['paytype'];
                }

                $orderBy = 'sorder.id DESC';

                //获取总数
                $tCount = $this->orderService->countByCondition($where);
                $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出

        	$orderList = $this->orderService->getOrderList($tPage, $tPageSize,$orderBy,$where);

        	$this->assign('param', $param);
                $this->assign('count', $tCount);
                $this->assign('orderList', $orderList);
                $this->assign('currentPage', $tPage);
		$this->display();
	}
}