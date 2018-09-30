<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\ProductCateModel;

/**
 * ti_product_cate
 *
 * @author liuxuchao
 */
class ProductCateService extends BaseService
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
            $this->model = new ProductCateModel();
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
     * 根据商品分类ID查找名称
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
     * 获取商品顶级分类
     * @return array | bool
     */
    public function getparentCate($where)
    {
        if ( empty($where) ) {
            return false;
        }
        $data = $this->model->getparentCate($where);
        return $data;
    }
    /**
     * 获取商品子分类
     * @return array | bool
     */
    public function getchildCate($where)
    {
        if ( empty($where) ) {
            return false;
        }
        $data = $this->model->getchildCate($where);
        return $data;
    }
}
