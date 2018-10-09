<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class OrderModel extends BaseModel
{
    
    /**
     * 数据库连接配置
     * @var string
     */
    protected $connection = 'ZSHOP_DB';
    
    /**
     * 主键字段名称
     * @var string 
     */
    protected $pk = 'id';
    
    /**
     * 实际数据表名（包含表前缀）
     * @var string 
     */
    protected $trueTableName = 'zs_order';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
		'id',
		'order_code',
		'order_type',
		'product_id',
		'service_id',
		'customer',
		'phone',
		'services_name',
		'services_time',
		'attention',
		'create_time',
		'pay_status',
		'pay_type',
		'pay_serial_number',
		'pay_time',
		'coupon_num',
		'UID',
		'totalPrice',
		'couponPrice',
		'payPrice',
		'buyNum',
		'iUseCoupon',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    


    /**
     * @auther caizhuan
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * return array | false
     */
    public function getOrder($page, $pageSize,$orderBy, $where){

        if ( empty($where) ) {
            return false;
        }

        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }

        return $this->alias('sorder')
                    ->join('left join zs_users users on sorder.uid = users.id')
                    ->join('left join zs_product product on sorder.product_id = product.pro_id')
                    ->where($where)
                    ->field('sorder.order_code,sorder.create_time,sorder.pay_status,sorder.pay_type,sorder.pay_time,product.product_name,users.username')
                    ->order($orderBy)
                    ->limit($offset, $pageSize)
                    ->select();
		
    }


    /**
     *订单统计
     * @auther caizhuan
     * @param array $where 
     * return array | false
     */
    public function countByCondition($where){
        if ( empty($where) ) {
            return false;
        }
        return $this->alias('sorder')
                    ->join('left join zs_users users on sorder.uid = users.id')
                    ->join('left join zs_product product on sorder.product_id = product.pro_id')
                    ->where($where)
                    ->count();
    }
}

