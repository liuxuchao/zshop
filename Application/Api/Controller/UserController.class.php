<?php
namespace Api\Controller;

import("Org.Util.ShortUrl");
use Application\ApiBaseController;
use Common\Service\UURecommend\AuthCodeService;
use Common\Service\UURecommend\UsersService;
use Common\Service\UURecommend\ChannelService;
use Common\Service\UURecommend\InviteService;
use Common\Service\UURecommend\UsersBalanceLogService;
use Common\Service\UURecommend\UsersModifyCompanyLogService;
use Common\Service\UURecommend\UsersPushConfigService;
use Common\Service\UURecommend\UsersShareLogService;
use Common\Service\UURecommend\UsersPriceConfigService;
use Common\Service\UURecommend\UsersShareRegisterService;
use Common\Service\UURecommend\ChannelJobsService;
use Common\Service\UURecommend\UsersMessagesLogService;
use Common\Service\UURecommend\VersionService;
use Common\Service\RecommendResume\RecommendService;

use Org\Util\RNCryptor;
use Org\Util\RegExp;
use Org\Util\ShortUrl;
/**
 * Description of UserController
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 */
class UserController extends ApiBaseController
{
    private $usersService;

    public function __construct()
    {
        parent::__construct();
        
        $this->usersService = new UsersService();
    }
    
    /**
     * 重置密码
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-18 09:40
     * @return null
     */
    public function resetPassword()
    {
        $userId   = $this->userId;
        $code     = I('post.authen_code', '', 'trim');
        $password = I('post.password', '', 'trim');
        
        //解密
        $rnCryptor = new RNCryptor();
        $key      = $rnCryptor::getKey();
        $code     = $rnCryptor::decrypt($code, $key);
        $password = $rnCryptor::decrypt($password, $key);
        
        //验证账号是否存在
        $user = $this->usersService->getByPrimaryKey($userId);
        if ( empty($user) || !is_array($user) ) {
            $result = ['error_code'=>'1', 'msg'=>'用户不存在'];
            echo json_encode($result);
            return;
        }
        
        //验证码
        $authCodeService = new AuthCodeService();
        $hashKey = $authCodeService::buildAuthCodeRedisHashKey($user['mobile']);
        $authCode = $authCodeService->getAuthCode($hashKey);
        $expiry = $authCodeService::getAuthCodeExpiry();
        if ( empty($authCode) || $_SERVER['REQUEST_TIME']-$authCode['send_time'] >= $expiry ) {
            $result = ['error_code'=>'210', 'msg'=>'验证码过期'];
            echo json_encode($result);
            return;
        }
        if ( $code != $authCode['code'] ) { //验证码错误 登录失败
            $result = ['error_code'=>'105', 'msg'=>'验证码错误'];
            echo json_encode($result);
            return;
        }
        
        //密码
        if ( is_int($password) ) {
            $result = ['error_code'=>'1', 'msg'=>'密码不能全部是数字'];
            echo json_encode($result);
            return;
        }
        $length = mb_strlen($password,'utf8');
        if (C('PASSWORD_MAX_LENGTH') < $length || $length < C('PASSWORD_MIN_LENGTH')) {
            $result = ['error_code'=>'1', 'msg'=>'密码长度6-16个字'];
            echo json_encode($result);
            return;
        }
        
        //更新密码
        $data = [
            'password' => $this->buildPassword($password),
            'update_time' => $_SERVER['REQUEST_TIME']
        ];
        $updateResult = $this->usersService->updateByPrimaryKey($userId, $data);
        if ( $updateResult ) {
            //删除验证码
            $authCodeService->deleteAuthCode($hashKey);
            $result = ['error_code'=>'0', 'msg'=>'修改成功'];
            echo json_encode($result);
            return;
        } else {
            $result = ['error_code'=>'1', 'msg'=>'修改失败'];
            echo json_encode($result);
            return;
        }
    }
    
    
    /**
     * 检测用户是否设置了密码
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-19 16:42
     * @return null
     */
    public function passwordExists()
    {
        $user = $this->usersService->getByPrimaryKey($this->userId);
        if ( empty($user) ) {
            return $this->returnJson('1', '用户不存在', ['set_status'=>-1]);
        }
        
        if ( empty($user['password']) ) {
            return $this->returnJson('0', '没有设置密码', ['set_status'=>0]);
        } else {
            return $this->returnJson('0', '已经设置了密码', ['set_status'=>1]);
        }
    }
    
    /**
     * 设置密码
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-19 16:53
     * @return null
     */
    public function setPassword()
    {
        $setStatus   = I('post.set_status', -1, 'intval');
        $oldPassword = I('post.old_password', '', 'trim');
        $newPassword = I('post.new_password', '', 'trim');
        
        if ( 0 != $setStatus && 1 != $setStatus ) {
            return $this->returnJson(1, 'set_status只能是0或1');
        }
        
        //更新密码
        $updatePassword = function($password) {
            $data = [
                'password' => $this->buildPassword($password),
                'update_time' => $_SERVER['REQUEST_TIME']
            ];
            return $this->usersService->updateByPrimaryKey($this->userId, $data);
        };
        $rnCryptor = new RNCryptor();
        $newPassword = $rnCryptor::decrypt($newPassword, $this->key);
        
        //没有设置密码
        if ( 0 == $setStatus ) {
            //检验密码是否合法
            $verifyPassword = $this->usersService->verifyPassword($newPassword);
            if ( !$verifyPassword ) {
                return $this->returnJson('1', '密码不合法');
            }
            
            //更新密码 存入数据库
            $updateResult = $updatePassword($newPassword);
            if ( $updateResult ) {
                goto SUCCESS;
                return;
            } else {
                goto ERROR;
                return;
            }
        }
        
        //设置过密码
        if ( 1 == $setStatus ) {
            $user = $this->usersService->getByPrimaryKey($this->userId);
            if ( empty($user) ) {
                goto ERROR;
                return;
            }
            
            //对比旧密码是否相同
            $oldPassword = $rnCryptor::decrypt($oldPassword, $this->key);
            $encryptedOldPassword = $this->buildPassword($oldPassword);
            if ( strcmp($encryptedOldPassword, $user['password']) !== 0 ) {
                return $this->returnJson('1', '旧密码错误');
            }
            
            //更新密码 存入数据库
            $updateResult = $updatePassword($newPassword);
            if ( $updateResult ) {
                goto SUCCESS;
                return;
            } else {
                goto ERROR;
                return;
            }
        }
        
        ERROR:
            return $this->returnJson('1', '设置失败');
            
        SUCCESS:
            return $this->returnJson('0', '设置成功');
    }
    

    /**
     * @获取 “我的” 信息 
     * @author 刘旭超 zhengziqiang@liuxuchaota.com
     * @DateTime  2016-12-21T12:44:02+0800
     * @return    [type]                   [description]
     */
    public  function  myInfo()
    {
        $sysType = I('post.sys_type',0,'intval');
        $appVersion = I('post.app_version','','trim');
        $userInfo = $this->usersService->myInfo($this->userId);
        if ( empty($userInfo) ) {
            return $this->returnJson(1, '失败');
        }
        $postVersion = intval(str_replace('.','',$appVersion));
        $isPublish = 1;
        $versionInfo = (new VersionService())->getLatestVersionInfo($isPublish,$sysType);
        if($postVersion > intval($versionInfo['version_code']) && $sysType==2){
            $isIap = (string)C('IS_IAP');
        }else{
            $isIap = '1';
        }
        $channelService = new ChannelService();
        $channelList = $channelService->getListByUserId($this->userId,1,0,1);
        $channelId = array_column($channelList,'id');
        if (!empty($channelId)) {
            $where['channel_id'] = array('in',$channelId);
            $where['user_id'] = $this->userId;
            $where['is_recommend'] = 1;
            $channelJobsService = new ChannelJobsService();
            $channelJobsCount = $channelJobsService->getJobCount($where);
        }else{
            $channelJobsCount = 0;
        }
        $inviteService = new InviteService();
        $receiveNum = $inviteService->getInviteNum($this->userId,1);
        $usersMessagesLogService = new UsersMessagesLogService();
        $hasMessage = $usersMessagesLogService->getNotReadListByUserId($this->userId);
        $parameters = array(
            'startTime' =>strtotime(date("Y-m-d",strtotime("-2 day"))),
            'from' =>1,
            'size'=>1
        );
        $recommendService = new RecommendService();
        $searchData = $recommendService->getResumeListFromApi($parameters,2);
        $isSharedCount = $searchData['totalSize'] ? $searchData['totalSize'] : 0;
        $returnData = array(
            'balance'=>$userInfo['balance'],
            'job'=>$userInfo['job'],
            'mobile'=>$userInfo['mobile'],
            'real_name'=>$userInfo['real_name'],
            'all_job_num'=>5,
            'in_recommend_job_num'=>$channelJobsCount,
            'icon_url'=>$userInfo['icon_url'],
            'resume_num'=>$isSharedCount,
            'msg_status'=> $hasMessage ? 1 : 2,
            'receive_num'=>intval($receiveNum),
            'is_iap'=> $isIap
            );
        return $this->returnJson(0, '', $returnData);
    }

    /*
    *修改手机号
    * @author liuxuchao
    * @date 2016-7-20
    * @param userId 用户ID
    * @param $mobile 新的手机号
    * @param  $code   旧的手机号接收的验证码
    * @return null
     */
    public  function  changeMobileNo()
    {
        $userId = $this->userId;  //UserId
        $mobile = I("post.user_phone", 0, 'trim');    //mobile
        $code = I("post.msg_code", 0, 'trim');    //code

        if( 0 >= intval($userId) ){
            return $this->returnJson('1', '参数错误');
        }
        //验证手机号码、验证码格式是否正确
        $verifyMobile = RegExp::isMobile($mobile);
        if ( !$verifyMobile) {
            return $this->returnJson('106', '手机号码格式不正确');
        }
        //获取手机号是否已经被注册
        $isRegister = $this->usersService->getByMobile($mobile);
        if ($isRegister) {
            return $this->returnJson('101', '手机号码已经被使用');
        }
        //判断验证码
        if (intval($code)==0) {
            return $this->returnJson('105', '验证码错误');
        }
        $data = $this->usersService->getUserInfo($userId);

        //从redis中读取验证码
        $authCodeService = new AuthCodeService();
        $hashKey = $authCodeService::buildAuthCodeRedisHashKey($mobile);
        $authCode = $authCodeService->getAuthCode($hashKey);
        
        if (!is_array($authCode) || $authCode['code'] != $code || empty($authCode['code'])) {
           return $this->returnJson('105', '验证码错误');
        }

        $data = $this->usersService->changeMobileNo($userId,$mobile);
        if ($data) {
            return $this->returnJson('0', '修改成功');
        }else{
            return $this->returnJson('1', '修改失败');
        }
    }

    /**获取用户信息
    *@author liuxuchao
    *@date 2016-8-03
    *@param  @userId 用户ID
    *@param  @channel 账号id
    *@return null
     */
    public function getUserInfo()
    {
        $userId = $this->userId;  //UserId
        $channelId = I("post.channel_id", '', 'trim');    //channelId 账号 ID

        if ( 0 >= $userId ) {
            $result = ['error_code'=>'1', 'msg'=>"用户ID错误"];
            echo json_encode($result);
            return;
        }
        
        $channelService = new ChannelService();
        $data = $this->usersService->getUserInfo($userId);
        if ($data['channel_id'] ==0 && $channelId =='') {
            $channelValidNum = $channelService->getChannelNum($userId,1);      //获取账号数量                       
            if ($channelValidNum ==1) {
                 $cdata = $channelService->getChannelListByUserId($userId);
                 $data['company_name'] = $cdata[0]['company_name'];
                 $data['company_trade'] = $cdata[0]['company_trade'];
                 $data['company_nature'] = $cdata[0]['company_nature'];
                 $data['company_size'] = $cdata[0]['company_size'];
                 $data['company_address'] = $cdata[0]['company_address'];
                 $data['channel_id'] = $cdata[0]['id'];
            }else{
                $result = ['error_code'=>'0', 'msg'=>'成功', 'data'=>null]; 
                echo json_encode($result);
                return;
            }
        }elseif($data['channel_id'] ==0 && $channelId >0){
            $cdata = $channelService->getInfoById($channelId);
            $data['company_name'] = $cdata['company_name'];
            $data['company_trade'] = $cdata['company_trade'];
            $data['company_nature'] = $cdata['company_nature'];
            $data['company_size'] = $cdata['company_size'];
            $data['company_address'] = $cdata['company_address'];
            $data['channel_id'] = $cdata['id'];
        }

        if ( $data) {
            $data['user_name'] = $data['real_name'];
            $data['user_job_title'] = $data['job'];
            unset($data['id']);
            unset($data['gender']);
            unset($data['real_name']);
            unset($data['job']);
            $result = ['error_code'=>'0', 'msg'=>'成功', 'data'=>$data]; 
            echo json_encode($result);
            return;
        }else{
            $result = ['error_code'=>'1', 'msg'=>"未获取到内容", 'data'=>[]];
            echo json_encode($result);
            return;
        }
    }

    /**修改用户信息
    *@author liuxuchao
    *@date 2016-7-20
    *@param  @userId 用户ID
    *@param  @corporationName 企业名称
    *@param  @username  用户名称
    *@param  @user_job_title  职位
    *@return null
     */
    public function updateUserInfo()
    {
        $userId = $this->userId;  //UserId
        $channelId = I("post.channel_id", '', 'trim');    //channelId 账号 ID
        $corporationName = I("post.corporation_name", '', 'trim');    //corporationName 公司名称
        $userName = I("post.user_name", '', 'trim');    //userName名称
        $jobTitle = I("post.user_job_title", '', 'trim');    //jobTitle职位
        $headUrl = I("post.head_url", '', 'trim');    //headUrl头像
        $shortName = I("post.shortname", '', 'trim');    //简称
        $companySize = I("post.company_size", '', 'trim');    //企业规模
        $companyNature = I("post.company_nature", '', 'trim');    //企业性质
        $companyTrade = I("post.company_trade", '', 'trim');    //所属行业
        $companyAddress = I("post.company_address", '', 'trim');    //企业地址
        if ($_FILES['head_url']) {
            $headUrl= substr(C('UPLOAD_PATH'),1).$this->upload($_FILES["head_url"], 'users/');
        }

        if ( 0 >= $userId) {
            $result = ['error_code'=>'1', 'msg'=>"用户ID错误"];
            echo json_encode($result);
            return;
        }
//        if ( $Arr['mobile'] ) {
//            $data['mobile'] = $Arr['mobile'];
//        }
        if(!empty($corporationName)){
             $data['company_name']= $corporationName;
        }
         if(!empty($userName)){
            $data['real_name'] = $userName;
        }
        if(!empty($jobTitle)){
            $data['job'] = $jobTitle;
        }
        if(!empty($shortName)){
            $data['shortname'] = $shortName;
        }
        if(!empty($companySize)){
            $data['company_size'] = $companySize;
        }
        if(!empty($companyNature)){
            $data['company_nature'] = $companyNature;
        }
        if(!empty($companyTrade)){
            $data['company_trade'] = $companyTrade;
        }
        if(!empty($companyAddress)){
            $data['company_address'] = $companyAddress;
        }
        if(!empty($channelId)){
            $data['channel_id'] = $channelId;
        }
        if ( !empty($headUrl) ) {
            $data['icon_url']= $headUrl.'?apiversion='.C('API_VERSSSION');
        }

        $results = $this->usersService->updateUserInfo($userId,$data);
        if (!empty($data['corporation_name'])) {
            $mData=array();
            $mData['company_name'] = $data['corporation_name'];
            $mData['user_id'] = $userId;
            $mData['channel_id'] = $channelId;
            $mData['create_time'] = time();
            $mData = $this->addModifiyLog($userId, $mData);
        }
       
        if ( $results) {
            $result = ['error_code'=>'0', 'msg'=>"修改成功"]; 
            echo json_encode($result);
            return;
        }else{
            $result = ['error_code'=>'1', 'msg'=>"修改失败"];
            echo json_encode($result);
            return;
        }
    }
    
    /**获取账号名称是否被修改过
     * author liuxuchao
     * @param $userId
     * @param $channelId
     * @return null
     */
     public function getIsModified(){
         $userId = $this->userId;  //UserId
         $channelId = I("post.channel_id", '', 'trim');    //channelId

         if (0 >= intval($channelId)) {
             $result = ['error_code'=>'1', 'msg'=>"账号ID不能为空"];
             echo json_encode($result);
             return;
         }
         $usersModifyCompanyLogService = new UsersModifyCompanyLogService();
         $data = $usersModifyCompanyLogService->getIsModified( $userId, $channelId);
         if ($data) {
             $result = ['error_code'=>'0','msg'=>"成功", 'data'=>true];
             echo json_encode($result);
             return;
         }else{
             $result = ['error_code'=>'0','msg'=>"成功", 'data'=>false];
             echo json_encode($result);
             return;
         }
     }

     /**获取账号名称是否被修改过
     * author liuxuchao
     * @param $userId
     * @param $channelId
     * @return bool
     */
     private function addModifiyLog($userId, $data){
        $userId = intval($userId);  //UserId

        if (0 >= intval($userId)) {
            return false;
        }
        if (empty($data) || !is_array($data)) {
            return false;    
        }
        $usersModifyCompanyLogService = new UsersModifyCompanyLogService();
        $data = $usersModifyCompanyLogService->addModifiyLog( $data );
        return $data;
     }

    /**获取收支明细日志
     * author liuxuchao
     * @param $userId
     * @return array | bool
     */
    public  function  getBalanceLogByUserId()
    {
        $type       = I("post.type", 1, 'intval');
        $page       = I('post.page', 1, 'intval');
        $pageSize   = I('post.page_size', 10, 'intval');
        
        $usersBalanceLogService = new UsersBalanceLogService();
        $data = $usersBalanceLogService->getListByAction($this->userId, $type,  $page,  $pageSize);
        $count = $data['count'];
        unset($data['count']);
        if ($count ==0) {
            return $this->returnJson('0', '暂无记录', ['count'=>0, 'logs'=>null]);
        }
        $tmpdata = array();
        if ($type==1) {//修改未读状态
            $usersBalanceLogService->updateBalanceLogStatus($this->userId);
        }
        //组装数据
        $usersPriceConfigService = new UsersPriceConfigService();
        foreach ($data as $key => $value) {
            $tmp=array();
            $tmp['description'] = $value['action_name'];
            if ( in_array($value['action'], $usersPriceConfigService::$addAction) ) {
                $tmp['number'] = '+' . $value['sum'];
            } else {
                $tmp['number'] = '-' . $value['sum'];
            }
            $tmp['event_time'] = $value['create_time'];
            $tmp['balance'] = $value['balance'];
            array_push($tmpdata, $tmp);
        }
        $data=$tmpdata;
        if ( $data) {
            return $this->returnJson('0', '成功', ['count'=>$count, 'logs'=>$data]);
        }else{
            return $this->returnJson('1', '获取失败', ['count'=>null, 'logs'=>0]);
        }
    }


    /**
     * 获取用户的提醒设置设置
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-12-29T15:02:16+0800
     * @return [type] [description]
     */
    public function getPushConfig()
    {
        $usersPushConfigService = new UsersPushConfigService();
        $data= $usersPushConfigService->findByUserId($this->userId);
        if ($data) {
            unset($data['id']);
            unset($data['create_time']);
            unset($data['update_time']);
            unset($data['user_id']);
            unset($data['is_preview_sms']);
            return $this->returnJson(0, '', $data);
        }else{
            return $this->returnJson(1, '失败');
        }

    }
    /**
     * [提醒设置修改]
     * 
     * @author 刘旭超   liuxuchao@liuxuchaozhao.com
     * @param   $userid  用户ID
     * @version   $data   修改的数据
     */
    public function setPushConfig()
    {
        $userId = $this->userId;  //UserId
        $bell = I("post.is_bell_vibration", null, 'trim');    //是否震动
        $invite = I("post.is_invite",  null, 'trim');    // 是否邀请
        $agreed = I("post.has_agreed_message",  null, 'trim');    //是否有人同意推送通知
        $refused = I("post.has_refused_message", null, 'trim');   //是否有人拒绝推送通知 
        $boot = I("post.is_push_boot_message",  null, 'trim');     //是否接受uu机器人推送消息
        $data =[];
        if ($bell !=null) {
            $data['is_bell_vibration'] =  intval($bell) ;
        }
       if ($invite !=null) {
            $data['is_invite'] =  intval($invite) ;
        }
       if ($agreed !=null){
            $data['has_agreed_message'] =  intval($agreed) ;
        }
       if ($refused!=null) {
            $data['has_refused_message'] =  intval($refused) ;
        }
        if ($boot !=null) {
            $data['is_push_boot_message'] =  intval($boot);
        }
        $usersPushConfigService = new UsersPushConfigService();
        $result = $usersPushConfigService->updateById($userId,$data);
         if ( $result) {
            return $this->returnJson('0', '修改成功');
        }else{
            return $this->returnJson('1', '修改失败');
        }
    }


    /**
     * 用户分享前的调用，获取短链接    分享类型 1：微信  2：qq   3 :朋友圈   4：qq空间
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data 2016-08-18
     * @param  int
     * @return [type] [description]
     */
    public function getUserShareUrl()
    {
        $type = I("post.type",  0, 'intval');    // 通过什么分享的  1：微信  2：qq   3 :朋友圈   4：qq空间
        if( 0>= $type){
            return $this->returnJson('1', '类型错误', ['share_url'=>'','log_id'=>'']);
        }
        $usersShareLogService = new UsersShareLogService();
        $data = $usersShareLogService->AddShareLog($this->userId, $type);
        if( $data ){
            $rnCryptor = new RNCryptor();
            $key      = $rnCryptor::getKey();
            $userId     = $rnCryptor::encrypt($this->userId, $key);
            $encrypteduserId = urlsafe_b64encode($rnCryptor::encrypt($this->userId, $key));
            $baseUrl = C('ENVIROMENT')==1?'https://' . C('API_HOST'):'http://' .C('TEST_HOST');
            $originalUrl = $baseUrl."/Home/Html/join.html?apiversion=".C('API_VERSSSION')."&type={$type}&log_id={$data}&share_id={$encrypteduserId}";
            $shareUrl = ShortUrl::buildUrl($originalUrl);
            return $this->returnJson('0', '', ['share_url'=>$shareUrl,'log_id'=>$data]);
        }else{
            return $this->returnJson('', '生成分享短链接失败', ['share_url'=>'','log_id'=>'']);
        }
    }

    /**
     * 获取调用分享后的 分享状态
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-08-10
     * @param  int
     * @return [type] [description]
     */
    public  function  updateShareStatus()
    {
        $status = I("post.status",  0, 'intval');    //log status的状态
        $logId = I("post.log_id",  0, 'intval');    //分享时生成的ID

        if ( 0>= $logId) {
            return $this->returnJson('1', '分享记录的ID错误');
        }
        //修改users_share_log 表的status状态
        $usersShareLogService = new UsersShareLogService();
        $data = $usersShareLogService->updateShareStatus($logId, $status);
        if ($data) {
            return $this->returnJson('0', '修改成功');
        }else{
            return $this->returnJson('1', '修改失败');
        }
    }

    /**
     * 获取用户余额
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-08-31
     * @param  int
     * @return [type] [description]
     */
    public function getBalanceSumByUserId()
    {
        $data = $this->usersService->getByPrimaryKey($this->userId);
        if ($data) {
            return $this->returnJson('0', '', ['balance'=>intval($data['balance'])]);
        }else{
            return $this->returnJson('2', '获取信息失败', ['balance'=>0]);
        }
    }


    /**
     * 获取用户的注册类型
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-09-27T11:08:34+0800
     * @return null
     */
    public function getRegisterType()
    {
        $shareRegister = new UsersShareRegisterService();
        $data = $shareRegister->getByRegisterUserId($this->userId);
        if ($data) {
            $result = ['error_code'=>'0', 'msg'=>"分享注册用户",'type'=>1];
            echo json_encode($result);
            return; 
        }else{
            $result = ['error_code'=>'0', 'msg'=>"普通注册用户",'type'=>2];
            echo json_encode($result);
            return;
        }
    }
    
    /**
     * @获取修改个人信息
     * @author 刘旭超 zhengziqiang@liuxuchaota.com
     * @DateTime  2016-12-21T12:44:45+0800
     * @return    [type]                   [description]
     */
    public function editUserInfo()
    {
        $appVersion = I("post.app_version", "", "trim");
        $appVersionNum = intval(str_replace(".","",$appVersion));

        $userInfo = $this->usersService->myInfo($this->userId);
        if ( empty($userInfo) ) {
            return $this->returnJson(1, '失败');
        }
        $dictTradesService =  new \Common\Service\UURecommend\DictTradesService();
        $tradeDict = $dictTradesService->getDictTradeList(0);
        $trade = '' ;
        $tradeParentId = '0';
        foreach ($tradeDict as $key => $value) {
            if ($userInfo['company_trade'] == $value['id']) {
                $trade = $value['name'];
                $tradeParentId = $value['parent_id'];
                continue ;
            }
        }
        $returnData = array(
            'icon_url'=>$userInfo['icon_url'],
            'sex'=>$userInfo['gender'],
            'user_job_title'=>$userInfo['job'],
            'user_name'=>$userInfo['real_name'],
            'trade_id'=> $appVersionNum >=200 ?$userInfo['company_trade_v2'] : $userInfo['company_trade'],
            'trade'=>$trade,
            'trade_parent_id'=>$tradeParentId,
        );
        return $this->returnJson(0, '', $returnData);
    }
    
    /**
     * @保存用户数据修改
     * @author 刘旭超 zhengziqiang@liuxuchaota.com
     * @DateTime  2016-12-21T12:51:50+0800
     * @return    [type]                   [description]
     */
    public function saveUserInfo()
    {
        $sex = I('sex', 0, 'intval');
        $userJobTitle = I('user_job_title', '', 'trim');
        $userName = I('user_name', '', 'trim');
        $tradeId = I('trade_id',0,'trim');
        $userInfo = $this->usersService->myInfo($this->userId); 
        if ( empty($userInfo['gender']) && 0 == $sex ) {
            return $this->returnJson(1, '参数错误');
        }else{
            $userEditData['gender'] = $sex ;
        }
        if ( empty($userInfo['job']) && empty($userJobTitle) ) {
            return $this->returnJson(1, '参数错误');
        }else{
            $userEditData['job'] = $userJobTitle ;
        }
        if ( empty($userInfo['real_name']) && empty($userName)  ) {
            return $this->returnJson(1, '参数错误');
        }else{
            $userEditData['real_name'] = $userName ;
        }
        if ( empty($userInfo['company_trade']) &&  0 == $tradeId ) {
            return $this->returnJson(1, '参数错误');
        }else{
            $userEditData['company_trade'] = $tradeId ;
        }
        
        //上传头像
        if ($_FILES['icon_url']) {
            $iconUrl = substr(C('UPLOAD_PATH'),1).$this->upload($_FILES["icon_url"], 'users/');
            $userEditData['icon_url'] = $iconUrl.'?apiversion='.C('API_VERSSSION');
        }
        
        //更新
        $result = $this->usersService->updateByPrimaryKey($this->userId,$userEditData);

        if ( false !== $result ) {
            return $this->returnJson(0, '修改成功');
        } else {
            return $this->returnJson(1, '修改失败');
        }

    }
}
