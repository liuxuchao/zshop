<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\ProductModel;

/**
 * ti_product
 *
 * @author liuxuchao
 */
class ProductService extends BaseService
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
            $this->model = new ProductModel();
        }
        return;
    }
    
    /**
     * 根据商品名称查找
     * @param type $name
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
}
