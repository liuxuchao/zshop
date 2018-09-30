<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of AuthGroupModel 用户组模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class AuthGroupModel extends BaseModel
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
    protected $trueTableName = 'zs_auth_group';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'title',
        'status',
        'rules'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * [findByName 根据字符串查找权限组是否存在]
     * @param  [string] $title [description]
     * @return [boole]       [description]
     */
    public function findByName($name)
    {
        $where = [];
        $where['title'] = $name;
        $result = $this->where($where)->find();
        return $result;   
    }
}

