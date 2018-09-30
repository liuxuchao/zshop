<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of RuleModel 规则模型
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class RuleModel extends BaseModel
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
    protected $trueTableName = 'zs_auth_rule';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'title',
        'type',
        'status',
        'condition',
        'level',
        'parent_id'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * [findByName 根据字符串查找权限规则是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function ajaxCheckRuleName($name='',$title='')
    {
        $where = [];
        if(!empty($name) && empty($title)){
            $where['name'] = $name;
        }else{
            $where['title'] = $title;
        }
        
        $result = $this->where($where)->find();
        return $result;   
    }
    
    /**
     * [gettree 获取栏目树]
     * @param  integer $p  [description]
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function getTree($p = 0, $lv = 0)
    {
        //定一个数组变量
        $t = [];
        //循环读取                            
        foreach ($this->select() as $k => $v) {
            //判断谁的父栏目等于0      
            if ($v['parent_id'] == $p) {
                $v['lv'] = $lv;
                //然后把（整条）数据放到 $t
                $t[] = $v;
                //检查   查出一个数据放到$t  +   递归开始                         
                $t = array_merge($t, $this->getTree($v['id'], $lv + 1));
            }
        }

        return $t;
    }
}

