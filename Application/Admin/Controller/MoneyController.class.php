<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\MoneyService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class MoneyController extends AdminBaseController
{
	private $moneyService = null;
	function __construct()
	{
		parent::__construct();
		$this->moneyService = new MoneyService();
	}


	/**
	 *广告列表
	 */
	public function index(){

		$param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');

        $where = array();
        // $wheres = array();

        // if (!empty($param['name'])) {
        // 	$where['ad.name'] = array('like','\'%'.$param['name'].'%\'');
        // 	$wheres['name'] = array('like','\'%'.$param['name'].'%\'');
        // }


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
        $tCount = $this->moneyService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->moneyService->getMoneyList($tPage, $tPageSize,$orderBy,$where);

		// foreach ($advertList as $key => $value) {
		// 	$advertList[$key]['statusName'] = ($value['status'] == 1) ? '正常':'下架';
		// 	$advertList[$key]['creatime'] = date("Y-m-d",$value['create_time']) ;
		// }
		
		$this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('advertList', $advertList);
        $this->assign('currentPage', $tPage);
		$this->display();
	}


    /**
     * 添加广告
     *
     */
    public function addMoney(){
        $this->display();
    }


    public function doAdd(){
    	$data = [];
        $data['amonut'] = I('post.amonut','','strip_tags');
        $data['giveMoney'] = I('post.giveMoney','','strip_tags');
        $data['creatime'] = time();

        if (empty($data['amonut'])) {
        	$this->error('充值金额不能为空','/Admin/Money/addAdv');
            return;
        }

        $addresult = $this->moneyService->add($data);
        if($addresult){
        	$this->success('添加成功','/Admin/Money/index');
            return;
        }else{
        	$this->success('添加失败','/Admin/Money/addAdv');
        }
    }


    /**
     * 修改广告
     */
    public function updateMoney(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->moneyService->getByPrimaryKey($Id);
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
        $data['amonut'] = I('post.amonut','','strip_tags');
        $data['giveMoney'] = I('post.giveMoney','','strip_tags');
        if(empty($data['amonut'])){
            $this->error('充值金额不能为空','/Admin/Money/updateAdv/id'.$data['id']);
            return;
        }

        $upResult = $this->moneyService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Money/updateAdv/id/'.$data['id']);
            return;
        }else{
        	$this->error('修改成功','/Admin/Money/index');
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

        $data = $this->moneyService->doDelete($Id);
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