<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\OrderModel;

/**
 * ti_order
 *
 * @author liuxuchao
 */
class OrderService extends BaseService
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
            $this->model = new OrderModel();
        }
        return;
    }
    

    /**根据UserId 渠道id 获取 用户信息
     * @author liuxuchao
     * @param  $userId 用户ID
     * @param  $channelId 渠道ID
     * return array | false
     */
    public function getUserInfo($userId)
    {
        $userId = intval($userId);
        if( $userId==0 ){
            return false;
        }
        
        $result = $this->model->getByUserId($userId);
        return $result;
    }



    /**
     *订单列表
     * @auther caizhaun
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * return array | false
     */
    public function getOrderList($page, $pageSize,$orderBy,$where){

        return $this->model->getOrder($page, $pageSize,$orderBy,$where);

    }


    /**
     *订单统计
     * @auther caizhuan
     * @param array $where 
     * return array | false
     */
    public function countByCondition($where){
        return $this->model->countByCondition($where);
    }

}
