<?php
namespace Org\Util\Sms;

vendor("Curl.vendor.autoload");

use Curl\Curl;

/**
 * Huoni短信通道
 *
 * @author qiaoda
 */
class Huoni
{
    
    /**
     * 火尼接口发送短信
     * @author 董光明
     * @date 2016-07-13 15:04
     * @param string $apiConfigName 短信配置名称，根据这个名称读取短信通道账号密码等配置信息。
     * @param string $content 发送内容
     * @param string $sendtime 短信发送的时间戳，如果想立即发送就传递空字符串。
     * @param array $phoneList 接受短信的手机列表
     * @return array
     */
    public static function sendMessage($apiConfigName, $content, $sendtime, $phoneList)
    {
        if ( empty($apiConfigName) || empty($content) || empty($phoneList) ) {
            return ['status'=>false, 'error_code'=>99, 'message'=>'参数错误', 'send_response'=>''];
        }
        
        //读取配置文件
        $apiConfig = C($apiConfigName);
        if ( empty($apiConfig) ) {
            return ['status'=>false, 'error_code'=>97, 'message'=>'配置文件错误', 'send_response'=>''];
        }
        
        //手机号码用逗号连接成字符串
        $phone = implode(',', $phoneList);
        
        //组装接口URL，和接口参数
        $parameters = [
            'account' => $apiConfig['ACCOUNT'],
            'password' => $apiConfig['PASSWORD'],
            'content' => $content,
            'sendtime' => $sendtime,
            'phonelist' => $phone,
            'taskId' => $apiConfig['ACCOUNT'] . '_' . date('YmdHis') . '_' . 'http' . '_' . rand(100000, 1000000) //taskId 接口参数之一
        ];
        $queryPrameters = http_build_query($parameters);
        $apiUrl = $apiConfig['API_URL'] . '?' . $queryPrameters;

        $result = (new Curl())->get($apiUrl);
        $matchCode = [];
        $codePattern = '/[0-9]+?/i';
        if ( preg_match($codePattern, $result, $matchCode) ) {
            $code = intval($matchCode[0]);
            if (0 === $code) {
                return ['status'=>true, 'error_code'=>0, 'message'=>'发送成功', 'send_response'=>$result];
            } else {
                return ['status'=>false, 'error_code'=>$code, 'message'=>'发送失败', 'send_response'=>$result];
            }
        } else {
            return ['status'=>false, 'error_code'=>98, 'message'=>'请求出错', 'send_response'=>$result];
        }
    }
    
}
