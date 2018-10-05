<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\ActivityModel;

/**
 * ti_order
 *
 * @author caizhuan
 */
class ActivityService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 设置当前service默认model
     * @author caizhuan
     * @date 2016-07-13 19:01
     * @param obj $model Mysql Model对象
     * @return null
     */
    public function setModel($model=null)
    {
        if ( !empty($model) && is_object($model) ) {
            $this->model = $model;
        } else {
            $this->model = new ActivityModel();
        }
        return;
    }


    /**
     * 获取活动名称与活动id
     * @auther caizhaun
     * return array | false
     */
    public function getActivityInfo($where = array()){

        return $this->model->getActivityInfo($where);

    }


}
