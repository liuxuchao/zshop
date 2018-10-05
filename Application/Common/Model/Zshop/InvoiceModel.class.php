<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class InvoiceModel extends BaseModel
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
    protected $trueTableName = 'zs_invoice';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'order_id',
        'type',
        'email',
        'invoice_title',
        'taxpayer_number',
        'invoice_type',
        'create_time',
        'useing_time',
        'status',
        'address',
        'taxpayer_tel',
        'taxpayer_blank_account'
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
    public function getInvoice($page, $pageSize,$orderBy, $where){

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
     * @param string $Id 广告ID
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

