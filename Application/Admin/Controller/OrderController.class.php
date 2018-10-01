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
	function __construct(argument)
	{
		parent::__construct();
		$this->orderService = new OrderService();
	}


	/**
	 *订单列表
	 */
	public function orderList(){
		
	}
}