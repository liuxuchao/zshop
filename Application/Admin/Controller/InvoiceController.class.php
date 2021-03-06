<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\InvoiceService;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class InvoiceController extends AdminBaseController
{
	private $invoiceService = null;
	function __construct()
	{
		parent::__construct();
		$this->invoiceService = new InvoiceService();
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
        $tCount = $this->invoiceService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->invoiceService->getInvoiceList($tPage, $tPageSize,$orderBy,$where);

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

            if ($value['itype'] == -1) {
                $advertList[$key]['handleName']  = '已删除';
            }elseif ($value['invoice_type'] == 1) {
                $advertList[$key]['handleName']  = '待处理';
            }else{
                $advertList[$key]['handleName']  = '已完成';
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
     * 开票申请
     */
    public function ApplyInvoice(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->invoiceService->getByPrimaryKey($Id);
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
        $data['id'] = I('post.InvoiceID','','strip_tags');
        $data['type'] = I('post.type','','strip_tags');
        $data['price'] = I('post.price','','strip_tags');
        $data['invoice_title'] = I('post.invoice_title','','strip_tags');
        $data['taxpayer_number'] = I('post.taxpayer_number','','strip_tags');
        $data['address'] = I('post.address','','strip_tags');
        $data['invoice_type'] = I('post.invoice_type','','strip_tags');
        $data['taxpayer_tel'] = I('post.taxpayer_tel','','strip_tags');
        $data['taxpayer_blank_account'] = I('post.taxpayer_blank_account','','strip_tags');
        $data['itype'] = I('post.itype','','strip_tags');
        if(!isset($data['itype']))
       

        $upResult = $this->invoiceService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('开票失败','/Admin/Invoice/ApplyInvoice/id/'.$data['id']);
            return;
        }else{
        	$this->error('修改成功','/Admin/Invoice/index');
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

        $data = $this->invoiceService->doDelete($Id);
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