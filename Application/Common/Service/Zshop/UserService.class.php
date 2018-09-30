<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\UserModel;

/**
 * uu_users
 *
 * @author liuxuchao
 */
class UserService extends BaseService
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
            $this->model = new UserModel();
        }
        
        return;
    }
    
    /**
     * 登录
     * @param type $username
     * @param type $password
     * @return array | bool
     */
    public function doLogin($username,$password)
    {
        $username = trim($username);
        if ( empty($username) ) {
            return false;
        }
        $password = trim($password);
        if ( empty($password) ) {
            return false;
        }
        $data = $this->model->doLogin($username, $password);
        return $data;
    }
    /**
     * 根据用户名查找用户
     * @param type $mobile
     * @return boolean
     */
    public function getByUserName($userName)
    {
        if ( empty($userName) ) {
            return false;
        }
        return $this->model->getByUserName($userName);
    }
    
    /**
     * 验证密码是否合法
     * 长度：6-16
     * 复杂度：不能是单纯的数字
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-19 17:26
     * @param string $password 密码
     * @return boolean
     */
    public static function verifyPassword( $password )
    {
        if ( empty($password) ) {
            return false;
        }
        
        //全部是数字返回错误，不能都是数字。
        if ( is_int($password) ) {
            return false;
        }
        
        //检验长度是否合法
        $length = mb_strlen($password,'utf8');
        if (C('PASSWORD_MAX_LENGTH') < $length || $length < C('PASSWORD_MIN_LENGTH')) {
            return false;
        }
        
        return true;
    }

    /**修改手机号码
     * @author liuxuchao
     * @param  $userId 用户ID
     * return array | false
     */
    public function changeMobileNo($userId,$mobile)
    {
        $userId=intval($userId);
        $mobile=intval($mobile);

        if($userId==0 || $mobile==0){
            return false;
        }
        $data=$this->model->changeMobileNo($userId,$mobile);
        return $data;
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
        
        return  $this->model->getByUserId($userId);
    }

    /**根据UserId 修改用户信息
     * @author liuxuchao
     * @param  $userId 用户ID
     * @param  $Arr  要修改的参数
     * return array | false
     */
    public function updateUserInfo($userId,$data)
    {
        $userId = intval($userId);
        if( $userId==0 ){
            return false;
        }
        if (!is_array($data)  || empty($data)) {
            return false;
        }
        $result = $this->model->updateUserInfo($userId,$data);
        return $result;
    }
    
}
