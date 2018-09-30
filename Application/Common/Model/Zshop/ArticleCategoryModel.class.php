<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of ArticleCategoryModel
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class ArticleCategoryModel extends BaseModel
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
    protected $trueTableName = 'zs_article_category';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'cate_name',
        'fid',
        'is_display',
        'create_time',
        'update_time',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    
}

