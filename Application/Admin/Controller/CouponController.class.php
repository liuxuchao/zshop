<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\CouponService;
use Common\Service\Zshop\ActivityService;
use Common\Service\Zshop\ProductService;
use Vendor\Excel\PHPExcel;

/**
 * 管理员登陆
 *
 * @author caizhuan <zhuan1127@163.com>
 * @date 2018-10-1 21:20
 */
class CouponController extends AdminBaseController
{
	private $couponService = null;
    private $activityService = null;
    private $productService = null;
	function __construct()
	{
		parent::__construct();
		$this->couponService = new CouponService();
        $this->activityService = new ActivityService();
        $this->productService = new ProductService();
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
        	$where['coupon.name'] = array('like','\'%'.$param['name'].'%\'');
        	$wheres['name'] = array('like','\'%'.$param['name'].'%\'');
        }


        //开始时间
        if (!empty($param['srtime'])) {
        	$where['coupon.create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        	$wheres['create_time'] = array('egt',strtotime($param['srtime'].' 00:00:00'));
        }

        //结束时间
        if (!empty($param['ertime'])) {
        	$where['coupon.create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        	$wheres['create_time'] = array('elt',strtotime($keyWord['ertime'].' 23:59:59'));
        }

        $orderBy = ' coupon.create_time desc';
        
    	//获取总数
        $tCount = $this->couponService->countByCondition($wheres); 
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
		$advertList = $this->couponService->getCouponList($tPage, $tPageSize,$orderBy,$where);

		foreach ($advertList as $key => $value) {
			$advertList[$key]['statusName'] = ($value['status'] == 1) ? '正常':'禁用';
			$advertList[$key]['creatime'] = date("Y-m-d",$value['create_time']) ;
            $advertList[$key]['use_from_time'] = date("Y-m-d",$value['use_from_time']) ;
            $advertList[$key]['use_end_time'] = date("Y-m-d",$value['use_end_time']) ;
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
        // //开始时间
        // $where['startTime'] = array('egt',strtotime(date('Y-m-d',time()).' 00:00:00'));

        // //结束时间
        // $where['endTime'] = array('elt',strtotime(date('Y-m-d',time()).' 23:59:59'));

        //获取产品
        $productInfo = $this->productService->getProduct();
        $this->assign('productInfo', $productInfo);

    	$activityInfo = $this->activityService->getActivityInfo();
        $this->assign('activityInfo',$activityInfo);
        $this->display();
    }


    public function doAdd(){
    	$data = [];
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
        $data['create_time'] = time();
        $data['moduleValue'] = I('post.moduleValue','','strip_tags');

        if (empty($data['name'])) {
        	$this->error('优惠券名称不能为空','/Admin/Coupon/addCoupon');
            return;
        }

        $addresult = $this->couponService->add($data);
        if($addresult){
        	$this->success('优惠券添加成功','/Admin/Coupon/index');
            return;
        }else{
        	$this->success('优惠券添加失败','/Admin/Coupon/addCoupon');
        }
    }


    /**
     * 修改广告
     */
    public function updateCoupon(){
    	$Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->couponService->getByPrimaryKey($Id);
        //获取产品
        $productInfo = $this->productService->getProduct();
        $this->assign('productInfo', $productInfo);

        $activityInfo = $this->activityService->getActivityInfo();
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
        $data['moduleValue'] = I('post.moduleValue','','strip_tags');

        if(empty($data['name'])){
            $this->error('优惠券名称不能为空','/Admin/Coupon/updateCoupon/id'.$data['id']);
            return;
        }

        $upResult = $this->couponService->updateByPrimaryKey($data['id'],$data);

        if($upResult>=0){
            $this->success('修改成功','/Admin/Coupon/index');
            return;
            
        }else{
        	$this->error('修改失败','/Admin/Coupon/updateCoupon/id/'.$data['id']);
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

        $data = $this->couponService->doDelete($Id);
        if ($data) {
            $result = ['error_code'=>'0','message'=>'删除成功'];
            echo json_encode($result);
            return;
        }
        $result = ['error_code'=>'1','message'=>'删除失败'];
        echo json_encode($result);
        return;
    }


    /**
     *上架
     */
    public function upAdv(){
        $data = [];
        $data['id'] = I('get.id','','strip_tags');
        $data['status'] = 1;
        $upResult = $this->couponService->updateByPrimaryKey($data['id'],$data);
        if($upResult>=0){
            $this->success('上架成功','/Admin/Coupon/index');
            return;
        }else{
            $this->error('上架失败','/Admin/Coupon/index');
            return;
        }
    }


    /**
     *下架
     */
    public function downAdv(){
        $data = [];
        $data['id'] = I('get.id','','strip_tags');
        $data['status'] = 0;
        $upResult = $this->couponService->updateByPrimaryKey($data['id'],$data);
        if($upResult>=0){
            $this->success('下架成功','/Admin/Coupon/index');
            return;
        }else{
            $this->error('下架失败','/Admin/Coupon/index');
            return;
        }
    }


    /**
     *优惠券发放
     */
    public function sendCoupon(){
        $Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->couponService->getByPrimaryKey($Id);
        $this->assign('data', $data);
        $this->display();
    }


    /**
     * 导入excel文件
     * @param  string $file excel文件路径
     * @return array        excel文件内容数组
     */
    function import_excel($file){
        // 判断文件是什么格式
        $type = pathinfo($file); 
        $type = strtolower($type["extension"]);
        $type=$type==='csv' ? $type : 'Excel5';
        ini_set('max_execution_time', '0');
        Vendor('PHPExcel.PHPExcel');
        // 判断使用哪种格式
        $objReader = PHPExcel_IOFactory::createReader($type);
        $objPHPExcel = $objReader->load($file); 
        $sheet = $objPHPExcel->getSheet(0); 
        // 取得总行数 
        $highestRow = $sheet->getHighestRow();     
        // 取得总列数      
        $highestColumn = $sheet->getHighestColumn(); 
        //循环读取excel文件,读取一条,插入一条
        $data=array();
        //从第一行开始读取数据
        for($j=1;$j<=$highestRow;$j++){
            //从A列读取数据
            for($k='A';$k<=$highestColumn;$k++){
                // 读取单元格
                $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
            } 
        }  
        echo "<pre/>";var_dump($data);die();
        return $data;
    }


    /**
     * 导入xls格式的数据 
     * 也可以用来导入csv格式的数据
     * 但是csv建议使用 下面的import_csv 效率更高
     */
    public function import_xls(){
        $data = $this->import_excel('./Upload/excel/simple.xls');
        p($data);
    }

}