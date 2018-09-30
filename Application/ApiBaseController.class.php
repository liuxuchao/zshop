<?php
namespace Application;

use Application\BaseController;
use Common\Service\UURecommend\UsersLoginStatusService;
use Org\Util\RNCryptor;

/**
 * Api接口Controller父类
 *
 * @author liuxuchao
 */
class ApiBaseController extends BaseController
{
    /**
     * 加密、解密参数的key
     * @var string 
     */
    protected $key;
    
    /**
     * 用户ID，解密有的ID
     * @var int
     */
    protected $userId = null;
    
    protected $usersLoginStatusService = null;
    
    /**
     * 接口请求参数
     * @var array
     */
    protected $requestParameters = [];
    
    /**
     * 接口返回数据
     * @var array 
     */
    protected $returnData = [
        "error_code" => 0, //错误码。0：没有错误，其他错误类型根据每个接口的具体错误类型来定义。
        "msg" => "提示信息", //提示信息，没有错误时可能为空。
        "data" => [] //要返回的数据
    ];
    
    /**
     * 程序执行开始时间戳
     * @var int
     */
    private $startTimestamp = null;
    
    /**
     * 程序执行结束时间戳
     * @var int
     */
    private $endTimestamp = null;
    
    /**
     * 不需要登录验证的控制器
     * @var array 
     */
    private $noCheckLogin = [
        '/api/login/login', //登录
    ];
    
    /**
     * 用于加密用户简历ID、职位ID等参数的key
     * @var string 
     */
    protected $userKey = '';

    public function __construct()
    {
        parent::__construct();
        
        //程序执行开始时间戳
        list($usec, $sec) = explode(" ", microtime());
        $this->startTimestamp = (float)$usec + (float)$sec;
        
        //请求参数
        $this->requestParameters = $_REQUEST;
        $this->usersLoginStatusService = new UsersLoginStatusService();
        
        //检验当前控制器是否需要登录验证
        //检查用户登录状态
        $this->checkLoginStatus();
    }
    
    public function __destruct()
    {
        parent::__destruct();
    }
    
    /**
     * 检查登录状态
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-18 13:19
     * @return
     */
    protected function checkLoginStatus()
    {
        //检验当前控制器是否需要登录验证
        $controller = '/api/'.strtolower(CONTROLLER_NAME).'/'.strtolower(ACTION_NAME);
        if (in_array($controller, $this->noCheckLogin) ) {
            return;
        }
        $userId = $this->userId;
        $token  = I('post.token', '', 'trim');
        $token  = RNCryptor::decrypt($token, $this->key);

        //登录token验证
        if (empty($token)) {
            $result = ['error_code'=>'209', 'msg'=>'登录token不能为空'];
            echo json_encode($result);
            exit;
        }
        
        //获取用户登录信息
        $loginStatus = $this->usersLoginStatusService->getByPrimaryKey($userId);
        if ( empty($loginStatus) || !is_array($loginStatus) ) {
            $result = ['error_code'=>'110', 'msg'=>'未登录'];
            echo json_encode($result);
            exit;
        }
        
        if ( strcmp($token, $loginStatus['login_token']) !== 0 ) {
            $result = ['error_code'=>'209', 'msg'=>'账号已在其他地方登录'];
            echo json_encode($result);
            exit;
        }
        
        return;
    }
    /**
     * 上传文件方法
     * @author 刘徐超 <liuxuchao@liuxuchaozhao.com>
     * @date 2016-07-23 14:19
     * @param $fileName  文件名
     * @param $folderName  文件加名称
     * @return string
     */
    public function upload($fileName, $folderName)
    {
        if (empty($fileName)) {
            return false;
        }
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     C('UPLOAD_PATH'); // 设置附件上传根目录
        $upload->savePath = $folderName;
        $upload->autoSub  = true;
        $upload->subName = array('date','Y/m/d');

        // 上传单个文件 
        $info   =   $upload->uploadOne($fileName);
        if(!$info) {// 上传错误提示错误信息
             return ($this->error($upload->getError()));
        }else{// 上传成功 获取上传文件信息
            return  $info['savepath'].$info['savename'];
        }
    }
    
    /**
     * 根据性别和年龄返回不同的图片地址 
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-12-29T14:38:38+0800
     * @param  [type] $age                     [description]
     * @param  [type] $sex                     [description]
     * @param  [type] $resumeId                     [简历ID]
     * @return [type]                          [description]
     */
    public function buildDefaultIcon($age,$sex,$resumeId)
    {
        //简历id取模
        $num = intval(substr($resumeId,-1))%3+1;
        if ($sex==1 && $age <=30) {
            return "/Home/default-icon/m".$num.".png";
        }elseif ($sex==1 && $age >30) {
            return "/Home/default-icon/m".$num.".png";
        }elseif ($sex==2 && $age <=30) {
            return "/Home/default-icon/w".$num.".png";
        }elseif ($sex==2 && $age >30) {
            return "/Home/default-icon/w".$num.".png";
        }
    }
    
    /**
     * 返回json数据之前做一些操作
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-05-13 10:04
     * @return;
     */
    private function beforeReturn()
    {
        //TODO
        return;
    }
    
    /**
     * 返回json数据之后做一些操作
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-05-13 10:04
     * @return;
     */
    private function afterReturn()
    {
        //程序执行结束时间戳
        list($usec, $sec) = explode(" ", microtime());
        $this->endTimestamp = (float)$usec + (float)$sec;

        //记录notice日志
        $this->writeNoticeLog();
        
        return;
    }
    
    /**
     * 记录运行日志
     * 日志级别：info，记录参数、相应信息、请求IP、执行时间
     * 日志格式：
     * [2017-05-13 13：05] /Api/ChannelJob/getDefaultRecommendJobList
     * request_ip: 发起请求的IP
     * request_parameters: 参数
     * response: 响应信息
     * time(second): 程序执行时间
     * 
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-05-13 11:41
     * @return null;
     */
    private function writeNoticeLog()
    {
        //日志内容
        $message = '['. date('Y-m-d H:i:s') ."] " .$_SERVER['REQUEST_URI'] ."\n"
                . "request_ip: " . get_client_ip(0, true) . "\n"
                . "request_parameters: " . json_encode($this->requestParameters) . "\n"
                . "response: " . json_encode($this->returnData) . "\n"
                . "time(second): " . ($this->endTimestamp - $this->startTimestamp) . "\n\n";
        
        //日志目录不存在事创建目录
        $dir = rtrim(RUNTIME_PATH, '/') . '/Logs/' . MODULE_NAME . '/notice/' . date('Y/m/');
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
        
        //写日志
        $destination = $destination = $dir . date('d') . '.log';
        error_log($message, 3, $destination);
        return;
    }
    
    /**
     * 返回json数据，http响应。
     * 此处为请求接口的统一返回（响应）方法，所有接口依靠此方法返回信息，是接口的统一出口。
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-05-13 09:52
     * @param int $errorCode 错误码。0：没有错误，其他错误类型根据每个接口的具体错误类型来定义。
     * @param string $message 提示信息，没有错误时可能为空。
     * @param array（mixt） $data 要返回的数据
     * @return null
     * 输出http响应，相应内容为json数据。数据格式：
     * {
     *     "error": 0, //错误码。0：没有错误，其他错误类型根据每个接口的具体错误类型来定义。
     *     "msg": "提示信息", //提示信息，没有错误时可能为空。
     *     "data": [] //要返回的数据
     * }
     */
    protected function returnJson($errorCode, $message, $data=null)
    {
        //返回数据之前
        $this->beforeReturn();
        
        //数据为空的时候设置为null
        if (empty($data)) {
            $data = null;
        }
        
        //拼装数据，返回json数据响应。
        $this->returnData['error_code'] = $errorCode;
        $this->returnData['msg'] = $message;
        $this->returnData['data'] = $data;
        echo json_encode($this->returnData);
        
        //返回数据之后
        $this->afterReturn();        
        return;
    }
    
    
}

