<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of AuthGroupAccessModel 用户组明细模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class AuthGroupAccessModel extends BaseModel
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
    protected $trueTableName = 'zs_auth_group_access';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'uid',
        'group_id'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
}

