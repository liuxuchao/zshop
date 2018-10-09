<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of ProductModel商品模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class ProductModel extends BaseModel
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
    protected $pk = 'pro_id';
    
    /**
     * 实际数据表名（包含表前缀）
     * @var string 
     */
    protected $trueTableName = 'zs_product';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'pro_id',
        'cate_id',
        'product_name',
        'small_title',
        'status',
        'stock_number',
        'price',
        'market_price',
        'description',
        'commodity_number',
        'attributes',
        'integral',
        'list_order',
        'create_time',
        'update_time',
        'create_ip',
        'update_ip',
        'contents',
        'template_style',
        'thumb',
        'group_img'
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


    /**
     *获取产品
     */
    public function getProduct(){
        return $this->select();
    }
    


}

