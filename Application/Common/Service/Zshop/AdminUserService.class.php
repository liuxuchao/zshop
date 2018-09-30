<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\AdminUserModel;

/**
 * uu_admin_users
 * 
 * @author liuxuchao
 */
class AdminUserService extends BaseService
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
            $this->model = new AdminUserModel();
        }
        
        return;
    }
    
    /**
     * 登录
     * @param type $name
     * @param type $password
     * @return array | bool
     */
    public function doLogin($name,$password)
    {
        $name = trim($name);
        if ( empty($name) ) {
            return false;
        }
        $password = trim($password);
        if ( empty($password) ) {
            return false;
        }
        $data = $this->model->doLogin($name, $password);
        return $data;
    }
    
    /**
     * 获取列表
     * @author  liuxuchao
     * @param type $page
     * @param type $pagesize
     * @return array | bool
     */
    public function getList ( $page=1, $pageSize=10)
    {
        $page = intval($page);
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0 >= $pageSize) {
            return false;
        }
        $data = $this->model->getList( $page, $pageSize);
        return $data;
    }
    
    /**
     * 获取总数
     * @param type $where   查询条件
     * @return int | bool
     */
    public function getCount ( $where)
    {
        $data = $this->model->getCount( $where);
        return $data;
    }

    /**
     * 添加管理员
     * @param type $name
     * @param type $password
     * @param type $nickname
     * @return array | bool
     */
    public function doAdd($name, $password, $nickname)
    {
        $name = trim($name);
        $nickname = trim($nickname);
        if ( empty($name) ||  empty($nickname) ) {
            return false;
        }
        $password = trim($password);
        if ( empty($password) ) {
            return false;
        }
        $data = $this->model->doAdd($name, $password, $nickname);
        return $data;
    } 

      /**
     * 更新数据
     * @param type $userId
     * @param type $name
     * @param type $password
     * @param type $nickname
     * @return array | bool
     */
    public function doUpdate($userId, $name, $password, $nickname)
    {
        $userId = intval($userId);
        $name = trim($name);
        $nickname = trim($nickname);
        $password = trim($password);
        $data = $this->model->doUpdate($userId, $name=null, $password=null, $nickname=null);
        return $data;
    }

    /**
     * 根据用户名称查找
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
     * 根据用户ID查找
     * @param type $userId
     * @return array | bool
     */
    public function findById($userId)
    {
        $userId = trim($userId);
        if ( 0>= $userId) {
            return false;
        }
        $data = $this->model->findById($userId);
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


    /**
     * 根据用户ID删除操作
     * @param type $userId
     * @param type $password
     * @return bool
     */
    public function doChangepwd($userId,$password)
    {
        $userId = intval($userId);
        if ( 0>= $userId) {
            return false;
        }
        $password = trim($password);
        $data = $this->model->doChangepwd($userId, $password);
        return $data;
    }

}
