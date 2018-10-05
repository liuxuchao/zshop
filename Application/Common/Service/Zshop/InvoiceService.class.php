<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\InvoiceModel;

/**
 * ti_order
 *
 * @author caizhuan
 */
class InvoiceService extends BaseService
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
            $this->model = new InvoiceModel();
        }
        return;
    }


    /**
     * 获取发票信息
     * @auther caizhaun
     * return array | false
     */
    public function getInvoiceList($tPage, $tPageSize,$orderBy,$where){

        return $this->model->getInvoice($tPage, $tPageSize,$orderBy,$where);

    }


}
