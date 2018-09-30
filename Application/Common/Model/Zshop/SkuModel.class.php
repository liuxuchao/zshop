<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of SkuModel商品分类
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class SkuModel extends BaseModel
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
    protected $trueTableName = 'zs_sku';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'product_id',
        'sku_key',
        'price',
        'stock_number',
        'create_time',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
 
    /**
     * [findByName 根据字符串查找分类属性中文名称是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function findByCname($name)
    {
        $where = [];
        $where['attr_cn'] = $name;
        $result = $this->where($where)->find();
        return $result;   
    }
    /**
     * 根据类ID 删除操作
     * @author liuxuchao
     * @param string $catId 分类ID
     * @return array | boolean
     */
    public function doDelete($catid)
    {
        $catId = intval( $catid );
        if ( 0 >= $catId) {
            return false;
        }
        $where['id'] = $catId;
        $data = $this->where($where)->delete();
        if ( $data ) {
            return $data;
        }
        return false;
    }
    /**
     * 根据分类ID查找属性
     * @author liuxuchao
     * @param string $catId 分类ID
     * @return array 
     */
    public function getAttrByCate($catId)
    {
        $catId = intval( $catId );
        if ( 0 >= $catId) {
            return false;
        }
        $where['cate_id'] = $catId;
        return $this->where($where)->select();
    }
    
    /**
     * 根据产品ID查找商品的sku
     * @param type $proId
     */
    public function getSkuByProductId($proId)
    {
        $proId = intval( $proId );
        if ( 0 >= $proId) {
            return false;
        }
        $where['product_id'] = $proId;
        return $this->where($where)->select();
    }
    /**
     * 根据产品ID查找商品的sku
     * @param type $proId
     */
    public function getSkuById($id)
    {
        $id = intval( $id );
        if ( 0 >= $id) {
            return false;
        }
        $where['id'] = $id;
        return $this->where($where)->field('stock_number')->select();
    }
}

