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
        'user_id',
        'pro_id',
        'buy_number',
        'is_pay',
        'pay_uuid',
        'pay_type',
        'create_time',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    


    /**
     * @auther caizhuan
     * @param $order_type 订单分类
     * return array | false
     */
    public function getOrderList($order_type = 0){

        if ( empty($order_type) ) {
            return false;
        }

        return $this->where(['order_type'=>$order_type])->select();
    }
}

