<?php
namespace Api\Controller;

vendor('MobileDetect.Detection.MobileDetect');

use Application\ApiBaseController;
use Common\Service\UURecommend\UsersService;


use Org\Util\RNCryptor;
use Org\Util\RegExp;

/**
 * Description of LoginController
 *
 * @author liuxuchao
 */
class LoginController extends ApiBaseController
{
    private $usersService = null;
    private $loginType = 1; //1:账号密码登录；2:手机号验证码登录；3:首次注册登录
    private $inviteUserId = 0; //邀请者用户ID
    
    public function __construct()
    {
        parent::__construct();
        
        $this->usersService = new UsersService();

        $this->channelJobsService = new ChannelJobsService();

    }
    
    /**
     * 账号密码登录
     * @author 刘旭超
     * @return null
     */
    public function login()
    {        
        $mobile   = I('post.user_account', '', 'trim'); 
        $password = I('post.password', '', 'trim');
        $deviceId = I('post.device_id', '', 'trim');
        $appVersion = I('post.app_version', '', 'trim');
        $deviceType = I('post.device_type', '', 'trim');
        $deviceVersion = I('post.device_version', '', 'trim');
        $sysType = I("post.sys_type", 0, "intval");
        $packType = I("post.pack_type", 0, "intval");
        $mobile   = RNCryptor::decrypt($mobile, $this->key);
        $password = RNCryptor::decrypt($password, $this->key);
        
        //返回数据
        $returnData = ['userid'=>'0', 'token'=>'', 'in_recommend_job_num'=>'0', 'channel_num'=>'0', 'is_finish'=>'0', 'log_id'=>'0'];

        if ( empty($mobile) || empty($password) ) {
            goto ACCOUNT_PASSWORD_ERROR;
            return;
        }
        //根据手机号码查找用户信息
        $user = $this->usersService->getByMobile($mobile);
        if ( empty($user) ) {
            goto ACCOUNT_PASSWORD_ERROR;
            return;
        }
        if (empty($user['password'])) {
            $errorCode = '111';
            $message = '未设置密码,请使用验证码登录并设置密码';
            $this->returnJson($errorCode, $message, $returnData);
            return;
        }
        //系统类型错误
        if ( !in_array($sysType, [1,2]) ) {
            $errorCode = '2';
            $message = '系统类型错误，1：安卓；2:IOS';
            $this->returnJson($errorCode, $message, $returnData);
            return;
        }
        //生成加密后的密码,并对比是否正确
        $ciphertext = $this->buildPassword($password);

        if ( strcmp($ciphertext, $user['password']) === 0 ){
            //登录成功 存储登录状态
            $loginToken = $loginTime = $_SERVER['REQUEST_TIME'];
            $saveLoginStatus = $this->saveLoginStatus($user['id'], $loginToken, $loginTime, $sysType, $deviceId, $appVersion, $deviceType, $deviceVersion, $packType);
            if ($saveLoginStatus) { //存储成功
                $afterLogin = $this->afterLogin($user, $deviceId, $appVersion, $deviceType, $deviceVersion);
                if (!empty($deviceId)){
                    $afterLogin = '';
                }
                $token = RNCryptor::encrypt($loginToken, C('ENCRYPT_KEY'));
                //获取有效的渠道
                $channelInfo = (new ChannelService)->getChannelByUserId($user['id']);
                $recommendNum = 0;
                if(!empty($channelInfo)){
                    $channelIdArr = array_column($channelInfo,'id');
                    //获取推荐中的职位数量
                    $recommendWhere = array(
                        'user_id' => $user['id'],
                        'channel_id' => array('in',$channelIdArr),
                        'original_publish_status' => 1,
                    );
                    $recommendNum = $this->channelJobsService->getJobCount($recommendWhere);
                }
                $channelNum = $this->getChannelNum($user['id']);
                $isFinish = '1';
                if (empty($user['icon_url']) || empty($user['real_name']) || 0 == $user['gender'] || empty($user['job']) || empty($user['company_trade']) ) {
                    $isFinish = '2';
                }
                $errorCode = '0';
                $message = '登录成功';
                $returnData = [
                    'userid' => RNCryptor::encrypt($user['id'], $this->key),
                    'token' => $token,
                    'in_recommend_job_num' => $recommendNum,
                    'channel_num'=>$channelNum,
                    'is_finish' => $isFinish,
                ];
                $this->returnJson($errorCode, $message, $returnData);
                return;
            } else { //存储失败
                $errorCode = '1';
                $message = '登录失败';
                $this->returnJson($errorCode, $message, $returnData);
                return;
            }
        } else { //登录失败
            goto ACCOUNT_PASSWORD_ERROR;
            return;
        }        
        return;
        
        ACCOUNT_PASSWORD_ERROR:
            $errorCode = '202';
            $message = '账号或密码不正确';
            $this->returnJson($errorCode, $message, $returnData);
            return;
    }
    
    
}
