<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\RoleModel;

/**
 * ti_role
 *
 * @author liuxuchao
 */
class RoleService extends BaseService
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
            $this->model = new RoleModel();
        }
        return;
    }
    

}
