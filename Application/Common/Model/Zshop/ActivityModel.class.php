<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class ActivityModel extends BaseModel
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
    protected $trueTableName = 'zs_activities';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'img_url_ids',
        'up_limit',
        'theme',
        'expenses',
        'desc',
        'params'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    


    /**
     * [getActivityInfo 获取活动信息]
     * @return [type]      [description]
     */
    public function getActivityInfo($where)
    {
        return $this->where($where)->field('id','name')->select();
    }

}

