<?php
namespace Org\Util\Sms;

vendor("Curl.vendor.autoload");

use Curl\Curl;
/**
 * Description of Shumi
 *
 * @author 董光明 <dongguangming@qiaodata.com>
 * @date 2016-9-26 11:49:48
 */
class Shumi
{
    /**
     * 错误码及描述
     * @var array
     */
    private static $errorCode = [
        '-101' => '用户不存在',
        '-102' => '密码不正确',
        '-103' => '余额不足',
        '-104' => '参数格式有误',
        '-105' => '扩展码权限错误',
        '-106' => '内容超长(500字)',
        '-107' => '用户状态异常',
        '-108' => 'Ip鉴权失败',
        '-109' => '内容解析异常',
        '-990' => '未知异常',
    ];
    
    /**
     * 数米接口发送短信
     * @author 董光明
     * @date 2016-09-26 15:04
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
            'userid' => $apiConfig['ACCOUNT'],
            'timespan' => date("YmdHis"),
            'pwd' => '',
            'mobile' => $phone,
            'msgfmt' => 'UTF-8',
            'content' => base64_encode($content),
        ];
        $parameters['pwd'] = strtoupper( md5($apiConfig['PASSWORD'].$parameters['timespan']) ); //密码
        if ($sendtime) { //发送时间
            $parameters['attime'] = date("Y-m-d H:i:s", $sendtime);
        }
        $queryPrameters = http_build_query($parameters);
        $apiUrl = $apiConfig['API_URL'] . '?' . $queryPrameters;
        
        //请求接口发送短信
        $result = (new Curl())->get($apiUrl);
        if ( 0 < $result ) {
            return ['status'=>true, 'error_code'=>0, 'message'=>'发送成功', 'send_response'=>$result];
        } else {
            return ['status'=>false, 'error_code'=>$result, 'message'=>self::$errorCode[$result], 'send_response'=>$result];
        }
        
    }
}
