<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of AdminUserModel
 *
 * @author liuxuchao
 */
class AdminUserModel extends BaseModel
{
    
    /**
     * 数据库连接配置
     * @var string
     */
    protected $connection = 'ZSHOP_DB';
    
    /**
     * 主键字段名称
     * @var string 
     */
    protected $pk = 'id';
    
    /**
     * 实际数据表名（包含表前缀）
     * @var string 
     */
    protected $trueTableName = 'zs_admin_users';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'password',
        'nickname',
        'create_time',
        'update_time' 
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 后台登录
     * @author liuxuchao
     * @param string $name 用户名
     * @param array $password 登录密码
     * @return array | boolean
     */
    public function doLogin($name, $password)
    {
        $name = trim( $name );
        if ( empty($name) || empty($password) ) {
            return false;
        }
        $data = $this->where(['name'=>$name,'password'=>$password ] )->find();
        if ( $data ) {
            return $data;
        }
        return false;
    }


    /**
     * 获取管理员列表
     * @author liuxuchao
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * @return array | boolean
     */
    public function getList($page, $pageSize,$orderType=1)
    {
        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        //排序规则列表
        $orderRules = [
            1 => 'create_time DESC',
            2 => 'id DESC',
            3 => 'create_time DESC',
            4 => 'id DESC',
        ];
        
        //排序
        $order = isset($orderRules[$orderType]) ? $orderRules[$orderType] : '';
        if ( !empty($order) ) {
            $this->order($order);
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
            $this->limit($offset, $pageSize);
        }
        $data = $this->select();
        if ( $data ) {
            return $data;
        }
        return false;
    }

    /**
     * 获取管理员总数
     * @author liuxuchao
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * @return array | boolean
     */
    public function getCount($where)
    {
        $where = trim($where);
        $data = $this->where($where)->count();
        if ( $data ) {
            return $data;
        }
        return false;
    }
        
    /**
     * 后台登录
     * @author liuxuchao
     * @param string $name 用户名
     * @param array $password 登录密码
     * @param array $nickname 昵称
     * @return array | boolean
     */
    public function doAdd($name, $password, $nickname)
    {
        $name = trim( $name );
        $nickname = trim( $nickname );
        $password = md5( trim($password) );
        if ( empty($name) || empty($password) ) {
            return false;
        }
        $data['name'] = $name;
        $data['password'] = $password;
        $data['nickname'] = $nickname;
        $data['create_time'] = time();
        $data = $this->add($data);
        if ( $data ) {
            return $data;
        }
        return false;
    }

    /**
     * 根据用户名称查找数据
     * @author liuxuchao
     * @param string $name 用户名
     * @param array $password 登录密码
     * @param array $nickname 昵称
     * @return array | boolean
     */
    public function findByName($name)
    {
        $name = trim( $name );
       
        if ( empty($name) ) {
            return false;
        }
        $where['name'] = $name;
        $data = $this->where($where)->find();
        if ( $data ) {
            return $data;
        }
        return false;
    }

    /**
     * 根据用户名称查找数据
     * @author liuxuchao
     * @date 2016-07-26
     * @param string $userId 用户id
     * @return array | boolean
     */
    public function findById($userId)
    {
        $userId = intval( $userId );
       
        if ( 0 >= $userId) {
            return false;
        }
        $where['id'] = $userId;
        $data = $this->where($where)->find();
        if ( $data ) {
            return $data;
        }
        return false;
    }

    /**
     * 根据用户名ID 删除操作
     * @author liuxuchao
     * @param string $userId 用户ID
     * @return array | boolean
     */
    public function doDelete($userId)
    {
        $userId = intval( $userId );
       
        if ( 0 >= $userId) {
            return false;
        }
        $where['id'] = $userId;
        $data = $this->where($where)->delete();
        if ( $data ) {
            return $data;
        }
        return false;
    }

    /**
     * 更新数据
     * @author liuxuchao
     * @param int $userId 用户ID
     * @param string $name 用户名
     * @param string $password 登录密码
     * @param string $nickname 昵称
     * @return array | boolean
     */
    public function doUpdate($userId,$name, $password, $nickname)
    {
        $userId = intval( $userId );
        $name = trim( $name );
        $nickname = trim( $nickname );
        if (0 >= $userId ) {
            return false;
        }
        if (!empty($name)) {
            $data['name'] = $name;
        }
        if (!empty($password)) {
            $data['password'] = md5($password);
        }if (!empty($nickname)) {
            $data['nickname'] = $nickname;
        }
        $data['update_time'] = time();
        $data = $this->where(['id'=>$userId])->save($data);
        if ( $data ) {
            return $data;
        }
        return false;
    }


    /**
     * 更新密码
     * @author liuxuchao
     * @param int $userId 用户ID
     * @param string $password 新密码
     * @return array | boolean
     */
    public function doChangepwd($userId,$password)
    {
        $userId = intval( $userId );
        $password = trim( $password );
        
        if (0 >= $userId ) {
            return false;
        }

        if (!empty($password)) {
            $data['password'] = md5($password);
        }else{
            return false;
        }
        $data['update_time'] = time();
        $data = $this->where(['id'=>$userId])->save($data);
        if ( $data ) {
            return $data;
        }
        return false;
    }
}
