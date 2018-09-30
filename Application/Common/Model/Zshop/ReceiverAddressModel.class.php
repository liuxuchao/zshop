<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * 收货地址ReceiverAddressModel
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class ReceiverAddressModel extends BaseModel
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
    protected $trueTableName = 'zs_receiver_address';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'user_id',
        'address_code',
        'address_detail',
        'receiver_name',
        'receiver_phone',
        'create_time'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    
}

