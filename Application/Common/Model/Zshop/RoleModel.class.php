<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of RoleModel 资源模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class RoleModel extends BaseModel
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
    protected $trueTableName = 'zs_role';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'role_name',
        'create_time',
        'create_ip'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
}

