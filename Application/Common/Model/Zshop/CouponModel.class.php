<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class CouponModel extends BaseModel
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
    protected $trueTableName = 'zs_coupons';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'activity_id',
        'amount',
        'use_from_time',
        'use_end_time',
        'status',
        'create_time',
        'limit_num',
        'moduleValue',
        'linkUrl'
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
    public function getCoupon($page, $pageSize,$orderBy, $where){

        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }

        return $this->alias('coupon')
                    ->join('left join zs_activities activities on coupon.activity_id = activities.id')
                    ->where($where)
                    ->field('coupon.id,coupon.name,coupon.amount,coupon.use_from_time,coupon.use_end_time,coupon.create_time,coupon.status,coupon.limit_num,activities.name cname')
                    ->order($orderBy)
                    ->limit($offset, $pageSize)
                    ->select();
    }


    /**
     * 根据类ID 删除操作
     * @author liuxuchao
     * @param string $Id 优惠券ID
     * @return array | boolean
     */
    public function doDelete($id)
    {
        $id = intval( $id );
        if ( 0 >= $id) {
            return false;
        }
        $where['id'] = $id;
        $data = $this->where($where)->delete();
        if ( $data ) {
            return $data;
        }
        return false;
    }

}

