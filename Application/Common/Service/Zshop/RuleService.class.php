<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\RuleModel;

/**
 * ti_auth_rule
 *
 * @author liuxuchao
 */
class RuleService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 设置当前service默认model
     * @author 刘旭超
     * @date 2016-07-13 19:01
     * @param obj $model Mysql Model对象
     * @return null
     */
    public function setModel($model=null)
    {
        if ( !empty($model) && is_object($model) ) {
            $this->model = $model;
        } else {
            $this->model = new RuleModel();
        }
        return;
    }
    
     /**
     * 根据权限规则名称查找
     * @param type $title
     * @return array | bool
     */
    public function ajaxCheckRuleName($name='',$title='')
    {
        $name = trim($name);
        $title = trim($title);
        $data = $this->model->ajaxCheckRuleName($name,$title);
        return $data;
    }
    
    /**
     * [gettree 获取栏目树]
     * @param  integer $p  [description]
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function getTree()
    {
        $t = $this->model->getTree();
        return $t;
    }
}
