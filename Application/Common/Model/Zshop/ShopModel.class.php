<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class ShopModel extends BaseModel
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
    protected $trueTableName = 'shopname';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'sname',
        'pname',
        'jname',
        'xname',
        'lon',
        'lat',
        'address'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    


    /**
     *
     */
    public function getShopList($page, $pageSize,$orderBy, $where){
        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }

        return $this->order($orderBy)
                    ->limit($offset, $pageSize)
                    ->select();
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




}

