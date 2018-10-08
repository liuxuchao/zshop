<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class RefundModel extends BaseModel
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
    protected $trueTableName = 'zs_orderrefund';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'sOrderNo',
        'fAmonut',
        'fPayAmonut',
        'sFlowNo',
        'iOperationDate',
        'iOpreation',
        'iCreateTime',
        'iStatus',
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
    public function getRefund($page, $pageSize,$orderBy, $where){

        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }

        return $this->where($where)
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
    public function doDelete($sOrderNo)
    {
        $id = intval( $id );
        if ( empty($sOrderNo)) {
            return false;
        }
        $where['sOrderNo'] = $sOrderNo;
        $data = $this->where($where)->delete();
        if ( $data ) {
            return $data;
        }
        return false;
    }

}

