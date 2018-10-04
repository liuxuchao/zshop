<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\AdvertCateModel;

/**
 * ti_order
 *
 * @author caizhuan
 */
class AdvertCateService extends BaseService
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
            $this->model = new AdvertCateModel();
        }
        return;
    }


    /**
     * [gettree 获取栏目树]
     * @param  integer $p  [description]
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function gettree()
    {
        $t = $this->model->gettree();
        return $t;
    }
    

    /**根据UserId 渠道id 获取 用户信息
     * @author caizhuan
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
     *广告列表
     * @auther caizhaun
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * return array | false
     */
    public function getAdverCatetList($page, $pageSize,$orderBy,$where){

        return $this->model->getAdverCate($page, $pageSize,$orderBy,$where);

    }


    /**
     *分类统计
     * @auther caizhuan
     * @param array $where 
     * return array | false
     */
    public function countByCondition($where){
        return $this->model->countByCondition($where);
    }


    /**
     * 根据商品分类名称查找
     * @param type $name
     * @param type $password
     * @param type $nickname
     * @return array | bool
     */
    public function findByName($name)
    {
        $name = trim($name);
        if ( empty($name) ) {
            return false;
        }
        $data = $this->model->findByName($name);
        return $data;
    }


    /**
     * 根据商品分类有无子分类
     * @return array | bool
     */
    public function findChildCateById($name)
    {
        $name = trim($name);
        if ( empty($name) ) {
            return false;
        }
        $data = $this->model->findChildCateById($name);
        return $data;
    }


    /**
     * 根据商品分类ID删除操作
     * @param type $catId
     * @return array | bool
     */
    public function doDelete($catId)
    {
        $catId = intval($catId);
        if ( 0>= $catId) {
            return false;
        }
        $data = $this->model->doDelete($catId);
        return $data;
    }

}
