<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\ArticleCateModel;

/**
 * ti_article_cate
 *
 * @author liuxuchao
 */
class ArticleCateService extends BaseService
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
            $this->model = new ArticleCateModel();
        }
        return;
    }
    
    /**
     * [gettree 获取栏目树]
     * @param  integer $p  [description]
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function getTree()
    {
        $t = $this->model->getTree();
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
}
