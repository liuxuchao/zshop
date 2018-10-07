<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\RefundModel;

/**
 * ti_order
 *
 * @author caizhuan
 */
class RefundService extends BaseService
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
            $this->model = new RefundModel();
        }
        return;
    }



    /**
     *广告列表
     * @auther caizhaun
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * return array | false
     */
    public function getRefundList($page, $pageSize,$orderBy,$where){

        return $this->model->getRefund($page, $pageSize,$orderBy,$where);

    }


     /**
     * 根据广告ID删除操作
     * @param type $Id
     * @return array | bool
     */
    public function doDelete($Id)
    {
        $Id = intval($Id);
        if ( 0>= $Id) {
            return false;
        }
        $data = $this->model->doDelete($Id);
        return $data;
    }

}
