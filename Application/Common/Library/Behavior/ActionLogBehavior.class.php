<?php
namespace Common\Library\Behavior;

use Behavior\CheckActionRouteBehavior;
use Common\Service\UURecommend\UsersActionLogService;

class ActionLogBehavior extends CheckActionRouteBehavior{
    // 行为参数定义
    protected $options   =  array(
        'TEST_PARAM'        => false,   //  行为参数 会转换成TEST_PARAM配置参数
    );
    // 行为扩展的执行入口必须是run
//    public function run(&$params){
//    	$userId = $_SESSION['userid']?$_SESSION['userid']:0;
//    	$usersActionLogService = new UsersActionLogService();
//		$requesturl = strtolower($_SERVER['REQUEST_URI']);
//		//如果是API请求, 记录日志
//		if(strpos($requesturl,'/api') === 0 ){
//			$logData['userid'] 		= $userId;
//			$logData['action'] 		= $requesturl;
//			$logData['ip'] 			= $_SERVER['REMOTE_ADDR'];
//			$logData['user_agent'] 	= $_SERVER['HTTP_USER_AGENT'];
//			$logData['create_time'] = $_SERVER['REQUEST_TIME'];
//			
//			$usersActionLogService->add($logData);
//		}
//    }
}