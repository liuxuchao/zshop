<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * tihold_system_config 系统配置表
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class SystemConfigModel extends BaseModel
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
    protected $trueTableName = 'zs_system_config';
    
    /**
     * 数据表字段猎豹
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'content',
        'create_time',
        'update_time',
    ];
    
    /**
     * 魔术方法允许的操作
     * 操作对应的配置ID
     * @var array
     */
    private $allowMethod = [
        'getRewardConfig' => 1,
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return boolean
     */
    public function __call($name, $arguments)
    {
        if ( !isset($this->allowMethod[$name]) ) {
            return false;
        }
        
        $id = $this->allowMethod[$name];
        $data = parent::find($id);
        return $data;
    }
}
