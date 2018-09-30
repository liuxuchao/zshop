<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\SkuModel;

/**
 * ti_sku
 *
 * @author liuxuchao
 */
class SkuService extends BaseService
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
            $this->model = new SkuModel();
        }
        return;
    }
    
    /**
     * 根据商品分类属性中文名称查找
     * @param type $name
     * @param type $password
     * @param type $nickname
     * @return array | bool
     */
    public function findByCname($name)
    {
        $name = trim($name);
        if ( empty($name) ) {
            return false;
        }
        $data = $this->model->findByCName($name);
        return $data;
    }
    /**
     * 根据商品分类属性ID查找名称
     * @param type $name
     * @param type $password
     * @param type $nickname
     * @return array | bool
     */
    public function findById($id)
    {
        if ( intval($id)==0 ) {
            return false;
        }
        $data = $this->model->findById($id);
        return $data;
    }
    
    /**
     * 根据商品分类属性ID删除操作
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
    /**
     * 根据商品分类查属性json字符串
     * @param type $catId
     * @return array | bool
     */
    public function getAttrByCate($catId)
    {
        $catId = intval($catId);
        if ( 0>= $catId) {
            return false;
        }
        return $this->model->getAttrByCate($catId);
    }
    /*
     * 根据商品id查找 返回 sku数组
     */
    public function getSkuByProductId($proId){
        $proId = intval($proId);
        if ( 0>= $proId) {
            return false;
        }
        return $this->model->getSkuByProductId($proId);
    }
    /*
     * 根据id查找 库存 返回
     */
    public function getSkuById($id){
        $id = intval($id);
        if ( 0>= $id) {
            return false;
        }
        return $this->model->getSkuById($id);
    }
}
