<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\AdvertService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class AdvertController extends AdminBaseController
{
	private $advertService = null;
	function __construct()
	{
		parent::__construct();
		$this->advertService = new AdvertService();
	}


	/**
	 *广告列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
                $tPage = I('page', 1, 'intval');
                $tPageSize = I('page_size', 10, 'intval');

                $where = array();
        

                //获取总数
         //        $tCount = $this->advertService->countByCondition($where);
         //        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
	        // $orderList = $this->advertService->getOrderList($tPage, $tPageSize,$orderBy,$where);

        	// $this->assign('param', $param);
         //        $this->assign('count', $tCount);
         //        $this->assign('orderList', $orderList);
         //        $this->assign('currentPage', $tPage);
		$this->display();
	}


        /**
         * 添加广告
         *
         */
}