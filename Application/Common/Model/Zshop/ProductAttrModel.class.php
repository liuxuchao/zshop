<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of ProductCateModel商品分类
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class ProductAttrModel extends BaseModel
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
    protected $trueTableName = 'zs_product_attr';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'cate_id',
        'cate_name',
        'attr_cn',
        'attr_en',
        'types',
        'unit',
        'json_values',
        'create_time',
        'update_time',
        'create_ip',
        'update_ip',
        'is_sku'
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
     * [findByName 根据字符串查找分类属性英文名称是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function findByEname($name)
    {
        $where = [];
        $where['attr_en'] = $name;
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
     * 根据商品分类ID获取sku属性的名称 数组
     */
    public function getSkuAttrNameByCateId($catId)
    {
        $catId = intval( $catId );
        if ( 0 >= $catId) {
            return false;
        }
        $where['cate_id'] = $catId;
        $where['is_sku'] = 1;
        return $this->where($where)->field('attr_cn,unit,json_values')->select();
    }
    /**
     * 根据商品分类英文名获取中文名 string
     */
    public function getAttrByAttrEn($en){
        $en = trim($en);
        if (empty($en)) {
            return false;
        }
        $where['attr_en'] = $en;
        return $this->where($where)->field('attr_cn,attr_en,unit')->select();
    }
  
}

