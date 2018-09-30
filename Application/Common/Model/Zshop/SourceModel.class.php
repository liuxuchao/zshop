<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of SourceModel 资源模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class SourceModel extends BaseModel
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
    protected $pk = 'pic_id';
    
    /**
     * 实际数据表名（包含表前缀）
     * @var string 
     */
    protected $trueTableName = 'zs_source';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'pic_id',
        'source_type',
        'type_id',
        'source_id',
        'url',
        'create_time',
        'create_ip'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
}

