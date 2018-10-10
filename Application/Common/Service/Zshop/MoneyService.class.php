<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\MoneyModel;

/**
 * uu_admin_users
 * 
 * @author liuxuchao
 */
class MoneyService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 设置当前service默认model
     * @author 刘徐超
     * @date 2016-07-26 17:01
     * @param obj $model Mysql Model对象
     * @return null
     */
    public function setModel($model=null)
    {
        if ( !empty($model) && is_object($model) ) {
            $this->model = $model;
        } else {
            $this->model = new MoneyModel();
        }
        
        return;
    }

    
    /**
     * 获取列表
     * @author  liuxuchao
     * @param type $page
     * @param type $pagesize
     * @return array | bool
     */
    public function getMoneyList ( $page=1, $pageSize=10)
    {
        $page = intval($page);
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0 >= $pageSize) {
            return false;
        }
        $data = $this->model->getMoneyList( $page, $pageSize);
        return $data;
    }
    

    /**
     * 根据用户ID删除操作
     * @param type $userId
     * @return array | bool
     */
    public function doDelete($userId)
    {
        $userId = intval($userId);
        if ( 0>= $userId) {
            return false;
        }
        $data = $this->model->doDelete($userId);
        return $data;
    }

}
