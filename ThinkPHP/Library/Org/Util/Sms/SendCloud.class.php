<?php

namespace Org\Util\Sms;

vendor("Curl.vendor.autoload");

use Curl\Curl;

/**
 * Description of SendCloud
 *
 * @author 董光明 <dongguangming@qiaodata.com>
 * @date 2016-11-9 14:27:26
 */
class SendCloud {

    /**
     * 邀请短信模板ID
     * @var type 
     */
    private static $inviteTemplateId = 4880;

    /**
     * 验证码短息模板ID
     * @var type
     */
    private static $smsCodeTemplateId = 4364;

    /**
     * 发送警报模板ID
     * @var type
     */
    private static $smaAlertTemplateId = 4832;

    /**
     * 查看简历联系方式的短信模板ID
     * @var type 
     */
    private static $seeResumePhoneId = 5808;

    /**
     * 数米接口发送短信
     * @author 董光明
     * @date 2016-11-09 14:36
     * @param string $apiConfigName 短信配置名称，根据这个名称读取短信通道账号密码等配置信息。
     * @param array $parameters 内容中的变量数组
     *      //邀请短信模板变量
     *      [
     *          "jobHunterName" => "董笑鸣", //求职者姓名
     *          "companyName" => "巧达",  //发送邀请短信的企业名称
     *          "hrJob" => "人事主管", //发送邀请短信的人的职务
     *          "jobName" => "高级JAVA开发工程师", //职位名称
     *          "jobUrl" => "http://dwz.cn/women" //职位详情URL短链接
     *      ]
     *      
     *      //验证码短信模板变量
     *      [
     *          "%auth_code%"=>$parameters["auth_code"], //验证码
     *          "%minute%" => $parameters["minute"],    //有效时长，单位：分钟。
     *       ]
     * @param string $sendtime 短信发送的时间戳，如果想立即发送就传递空字符串。
     * @param array $phoneList 接收短信的手机列表，目前此通道只支持单个手机号码。
     * @param int $templateId 模板ID
     * @return array
     * 
     * 接口返回结果格式：
     * array(4) {
     *   ["info"] => array(2) {
     *     ["successCount"] => int(1)
     *     ["smsIds"] => array(1) {
     *       [0] => string(47) "1478687107273_42703_581_3142_lkeuk5$13641154657"
     *     }
     *   }
     *   ["statusCode"] => int(200)
     *   ["message"] => string(12) "请求成功"
     *   ["result"] => bool(true)
     * }
     */
    public static function sendMessage($apiConfigName, $parameters, $sendtime, $phoneList, $templateId = 3142) {
        if (empty($apiConfigName) || empty($parameters) || empty($phoneList)) {
            return ['status' => false, 'error_code' => 99, 'message' => '参数错误', 'send_response' => ''];
        }

        //读取配置文件
        $apiConfig = C($apiConfigName);
        if (empty($apiConfig)) {
            return ['status' => false, 'error_code' => 97, 'message' => '配置文件错误', 'send_response' => ''];
        }

        $phone = $phoneList[0];

        //参数数组
        $vars = self::buildTemplateVariables($parameters, $templateId);
        $varsJson = json_encode($vars);
        $param = array(
            'smsUser' => $apiConfig["ACCOUNT"],
            'templateId' => $templateId,
            'msgType' => '0',
            'phone' => $phone, //18515576080
            'vars' => $varsJson
        );
        $signature = self::createSignature($param, $apiConfig["SMS_KEY"]);
        $param['signature'] = $signature;

        //请求接口发送短信
        $curl = new Curl();
        $curl->setJsonDecoder(function($response) {
            $json_obj = json_decode($response, true);
            if (!($json_obj === null)) {
                $response = $json_obj;
            }
            return $response;
        });
        $result = $curl->post($apiConfig["API_URL"], $param);

        //发送结果
        return ['status' => $result["result"], 'error_code' => $result["statusCode"], 'message' => $result["message"], 'send_response' => $result];
    }

    /**
     * 组织短信模板参数
     * @param type $parameters
     * @param type $tmplateId
     */
    private static function buildTemplateVariables($parameters, $templateId) {
        $variables = null;
        //邀请短信模板变量设置
        if ($templateId == self::$inviteTemplateId) {
            $variables = [
                "%Name%" => $parameters["Name"],
                "%Company%" => $parameters["Company"],
                "%PositioName%" => $parameters["PositionName"],
                "%JobName%" => $parameters["JobName"],
                "%HrName%" => $parameters["HrName"],
                "%Url%" => $parameters["Url"],
                "%Salary%" => $parameters["Salary"],
                "%WorkAddress%" => $parameters["WorkAddress"]
            ];
            return $variables;
        }

        //验证码短信模板变量设置
        if ($templateId == self::$smsCodeTemplateId) {
            $variables = [
                "%auth_code%" => $parameters["auth_code"],
                "%minute%" => $parameters["minute"],
            ];
            return $variables;
        }
        //报警设置变量设置
        if ($templateId == self::$smaAlertTemplateId) {
            $variables = [
                "%ip%" => $parameters["ip"],
                "%send_date%" => $parameters["send_date"],
                "%message%" => $parameters["message"],
            ];
            return $variables;
        }

        //报警设置变量设置
        if ($templateId == self::$seeResumePhoneId) {
            $variables = [
                "%Name%" => $parameters["Name"],
                "%Company%" => $parameters["Company"],
                "%JobName%" => $parameters["JobName"],
                "%Salary%" => $parameters["Salary"],
                "%Url%" => $parameters["Url"],
            ];
            return $variables;
        }

        return $variables;
    }

    /**
     * 生成签名字符串
     * @author 董光明 <dongguangming@qiaodata.com>
     * @date 2016-11-09 15:53
     * @param array $param 短信接口参数
     * @return string
     */
    private static function createSignature($param, $smsKey) {
        $sParamStr = "";
        ksort($param);
        foreach ($param as $sKey => $sValue) {
            $sParamStr .= $sKey . '=' . $sValue . '&';
        }

        $sParamStr = trim($sParamStr, '&');
        $sSignature = md5($smsKey . "&" . $sParamStr . "&" . $smsKey);
        return $sSignature;
    }

}
