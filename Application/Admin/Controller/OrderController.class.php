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
        	$where["to_days('sorder.create_time')"] = to_days(now());
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