<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of ProductModel商品SKU模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class CartModel extends BaseModel
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
    protected $trueTableName = 'zs_cart';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'user_id',
        'product_id',
        'create_time',
        'status',
        'sku_id',
        'num',

    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * [findByName 根据字符串查找商品名称是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function findByName($name)
    {
        $where = [];
        $where['product_name'] = $name;
        $result = $this->where($where)->find();
        return $result;   
    }
    


}

