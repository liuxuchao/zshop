<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of UserModel
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class UserModel extends BaseModel
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
    protected $trueTableName = 'zs_users';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'username',
        'mobile',
        'password',
        'real_name',
        'gender',
        'icon_url',
        'points',
        'register_type',
        'create_time',
        'update_time',
        'openid',
        'userType',
        'userNum'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 登录
     * @author liuxuchao
     * @param string $username 用户名
     * @param array $password 登录密码
     * @return array | boolean
     */
    public function doLogin($username, $password)
    {
        $username = trim( $username );
        if ( empty($username) || empty($password) ) {
            return false;
        }
        $data = $this->where(['username'=>$username,'password'=>$password ] )->find();
        if ( $data ) {
            return $data;
        }
        return false;
    }
    /**
     * 根据手机号码查找用户信息
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $userName 手机号码
     * @param array $fieldList 字段列表
     * @return boolean
     */
    public function getByUserName($userName)
    {
        if ( empty($userName) ) {
            return false;
        }
        return $this->where(['username'=>$userName])->find();
    }
    
    
    /**
     * 根据手机号码数组获取用户信息
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param array $mobileList 手机号码列表
     * @return boolean | array
     */
    public function getListByMobileList($mobileList)
    {
        if (empty($mobileList) || !is_array($mobileList)) {
            return false;
        }
        
        $where = "mobile IN ('" . implode("','", $mobileList) . "')";
        $data = $this->where($where)->select();
        return $data;
    }
    
    
    /**
     * 根据手机号码数组获取用户信息
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param array $mobileList 手机号码列表
     * @return boolean | array
     */
    public function getListByPkList($pkList)
    {
        if (empty($pkList) || !is_array($pkList)) {
            return false;
        }
        
        $where[$this->pk] = ['in', $pkList];
        $data = $this->where($where)->select();
        return $data;
    }
    
    
    /**
     * 根据UserId查找用户信息
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $userId
     * @param array $fieldList 字段列表
     * @return boolean
     */
    public function getByUserId($userId, $fieldList=[])
    {
        $userId = intval($userId);
        if ( empty($userId) ) {
            return false;
        }
        // $fieldList=['id','mobile','real_name','gender',
        //             'job','icon_url','company_name',
        //             'balance','channel_id','shortname',
        //             'company_size','company_nature',
        //             'company_trade','company_trade_v2','company_address'];
        // $this->field($fieldList);
        

        $data = $this->where(['id'=>$userId])->find();
        return $data;
    }

    /**
     * 修改手机号码
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $userId
     * @param array $mobile 新的手机号
     * @return boolean
     */
    public function changeMobileNo($userId,$mobile)
    {
        $userId = intval($userId);
        $mobile = intval($mobile);
        if (0>=$userId ||  0 >=$mobile) {
            return false;
        }
        $data['mobile'] = $mobile;
        $result=$this->where(['id'=>$userId])->save($data);
        if ($result) {
            return true;
        }else{
            return false;
        }
    }

     /**
     * 修改用户信息
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $userId
     * @param array $data 修改的
     * @return boolean
     */
    public function updateUserInfo($userId,$data)
    {
        $userId = intval($userId);
        if (0>=$userId) {
            return false;
        }
        $result=$this->where( [ 'id'=>$userId ] )->save($data);
        if ($result) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 扣除蛙币
     * @param int $primaryKey 用户ID
     * @param int $sum 扣除的金额
     * @return int | bool
     */
    public function deductMoneyByPrimaryKey($primaryKey, $sum)
    {
        $primaryKey = intval($primaryKey);
        $sum = intval($sum);
        if ( 0 >= $primaryKey || 0 > $sum ) {
            return false;
        }
        
        $sql = "UPDATE {$this->trueTableName} SET balance=balance-{$sum} WHERE {$this->pk}={$primaryKey}";
        $result = $this->execute($sql);
        return $result;
    }
    
    /**
     * 添加蛙币
     * @param int $primaryKey 用户ID
     * @param int $sum 扣除的金额
     * @return int | bool
     */
    public function addMoneyByPrimaryKey($primaryKey, $sum)
    {
        $primaryKey = intval($primaryKey);
        $sum = intval($sum);
        if ( 0 >= $primaryKey || 0 > $sum ) {
            return false;
        }
        
        $sql = "UPDATE {$this->trueTableName} SET balance=balance+{$sum} WHERE {$this->pk}={$primaryKey}";
        $result = $this->execute($sql);
        return $result;
    }


    /**
     * 获取用户列表
     * @author liuxuchao 
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * @return array | boolean
     */
    public function getList($where,$page, $pageSize,$orderBy)
    {
        $page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }
        // $field = 'ANY_VALUE(u.id) user_id ,ANY_VALUE(u.mobile) mobile, ANY_VALUE(u.real_name) name,';
        // $field .= 'ANY_VALUE(u.channel_id) channel_id, ANY_VALUE(u.balance) balance,';
        // $field .= 'ANY_VALUE(u.create_time) create_time,';
        // $field .= 'ANY_VALUE(u2.mobile) shared_user_mobile, ANY_VALUE(login.login_time) login_time,';
        // $field .= 'count(shareB.id) sharebindcount, count(shareC.id) shareallcount';
        

        // $field = 'u.id user_id ,u.mobile mobile, u.real_name name,';
        // $field .= 'u.channel_id channel_id, u.balance balance,';
        // $field .= 'u.create_time create_time,';
        // $field .= 'u2.mobile shared_user_mobile, login.login_time login_time,';
        // $field .= 'count(shareB.id) sharebindcount, count(shareC.id) shareallcount';
        
        // //绑定账号的推荐注册用户数量
        // $subQueryBind = $this->field('sharebind.id,sharebind.shared_user_id')
        //     ->table('crap_users_share_register sharebind')
        //     ->join('crap_users userbind ON sharebind.shared_user_id=userbind.id','LEFT')
        //     ->where('sharebind.register_user_status = 1')
        //     ->select(false);
        // //全部推荐注册用户数量
        // $subQueryAll = $this->field('shareall.id,shareall.shared_user_id')
        //     ->table('crap_users_share_register shareall')
        //     ->join('crap_users userall ON shareall.shared_user_id=userall.id', 'LEFT')
        //     ->select(false);

        // $list  = $this->alias('u')->field($field)
        //     ->join('crap_users_share_register share ON u.id=share.register_user_id', 'LEFT')
        //     ->join('crap_users u2 ON u2.id=share.shared_user_id', 'LEFT')
        //     ->join('crap_users_login_status login ON u.id=login.user_id','LEFT')
        //     ->join('LEFT JOIN ('.$subQueryBind.') shareB ON u.id=shareB.shared_user_id')
        //     ->join('LEFT JOIN ('.$subQueryAll.') shareC ON u.id=shareC.shared_user_id')
        //     ->group('u.id')
        //     ->order($orderBy)
        //     ->where($where)
        //     ->limit($offset, $pageSize)
        //     ->select();

        $list = $this->where($where)->order($orderBy)->limit($offset, $pageSize)->select();

        return $list;
    }

    /**
     * 获取用户总数
     * @author liuxuchao
     * @param string $page 页码
     * @param array $pageSize 页数
     * @param array $order 排序
     * @return array | boolean
     */
    public function getCount($where)
    {
        // $data = $this->where($where)->count();
        $data = $this->alias("u")
            ->join('crap_users_share_register share on u.id=share.register_user_id','LEFT')
            ->join('crap_users u2 on u2.id=share.shared_user_id','LEFT')
            ->where($where)
            ->count();
        
        return $data ? $data : 0;
    }

    /**
     * 根据用户名ID 删除操作
     * @author liuxuchao
     * @date 2016-07-27
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
     * @tips: 获取用户数据
     * @author: maliang <maliang@liuxuchaota.com>
     * @param: int   $page     分页参数
     * @param: int   $pageSize 分页参数
     * @param: str   $orderBy  排序规则
     * @param: array $where    查询条件
     * @return:array $list     查询结果
     */
	public function getUserDataList($page, $pageSize, $orderBy, $where)
	{
		$page = intval( $page );
        $pageSize = intval($pageSize);
        if ( 0 >= $page || 0>=$pageSize ) {
            return false;
        }
        if ( 0 < $page ) {
            $offset = ($page - 1) * $pageSize;
        }
		$field = "id,mobile";
        return $this->field($field) ->group('id')->order($orderBy)->where($where)->limit($offset, $pageSize)->select();
	}

    public function getUserDataCount($where){
        $count = $this->alias('u')->where($where)->count();
        return $count;
    }
    
    
    /**
     * 事务的方式更新订单和用户余额
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param int $userId 用户ID
     * @param int $orderId 订单ID
     * @param array $orderInfo 订单数据数组
     * @param int $sum 蛙币数量
     * @param int $notifyType 通知类型，0：同步通知，1：异步通知
     * @return array
     *      0：订单状态已经更新过或者找不到符合条件的订单
     *      true：更新成功
     *      false：更新失败
     */
    public function updateOrder_UserBalance_Transaction($userId, $orderId, $orderInfo, $sum, $notifyType=0)
    {
        $tranDb = new \Think\Model('', '', 'UURECOMMEND_DB');
        $tranDb->startTrans();
        
        //更新订单状态
        if ( 0 == $notifyType ) {
            $where = ['id' => $orderId, 'pay_status' => 0];
        } elseif ( 1 == $notifyType ) {
            $where = [
                'id' => $orderId, 
                'pay_status' => ['NEQ', 1]
            ];
        } else {
            $where = ['id' => $orderId, 'pay_status' => 0];
        }        
        $updateOrder = $tranDb->table('crap_order')->where($where)->save($orderInfo);
        if ( false === $updateOrder ) {
            return false;
        }
        
        //没有找到符合条件的数据，无法更新,或者支付状态不成功。
        if ( 0 === $updateOrder || 1 != $orderInfo['pay_status'] ) {
            if ( 1 == $notifyType ) { //最终的订单状态以异步通知为准
                $updateOrder = $tranDb->table('crap_order')->where(['id'=>$orderId])->save($orderInfo);
            }
            $tranDb->commit();
            return 0;
        }
        
        //更新用户蛙币余额
        $sql = "UPDATE crap_users SET balance=balance+" . $sum . ", update_time=" . $_SERVER['REQUEST_TIME'] . " WHERE id=" . $userId;
        $updateBalance = $tranDb->table('crap_users')->execute($sql);
        if ( $updateOrder && $updateBalance ) {
            $tranDb->commit();
            return true;
        } else {
            $tranDb->rollback();
            return false;
        }
    }
   
}

