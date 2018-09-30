<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义网站根目录
define('SITE_PATH', dirname(__DIR__).'/');

// 定义运行时目录
define('RUNTIME_PATH','../Runtime/');

// 定义应用目录
define('APP_PATH','../Application/');

// 引入ThinkPHP入口文件
$frameWorkDir = dirname( dirname(__FILE__) );
require $frameWorkDir . '/ThinkPHP/ThinkPHP.php';
/*
try {
    // 引入ThinkPHP入口文件
    
} catch (Exception $exc) {
    //调试模式输出错误信息
    if ( APP_DEBUG ) {
        echo $exc->getTraceAsString();
        echo $exc->getMessage();
        return;
    }    
    
    //日志内容
    $message = '['. date('Y-m-d H:i:s') ."] " .$_SERVER['REQUEST_URI'] ."\n"
            . "trace:\n" . $exc->getTraceAsString() . "\n"
            . "message: " . $exc->getMessage() . "\n\n";

    //日志目录不存在事创建目录
    $dir = rtrim(RUNTIME_PATH, '/') . '/Logs/' . MODULE_NAME . '/error/' . date('Y/m/');
    if (!file_exists($dir)) {
        mkdir($dir, 0775, true);
    }
    
    //写日志
    $destination = $dir . date('d') . '.log';
    error_log($message, 3, $destination);
    
    //返回系统错误
    echo json_encode(['error_code'=>999, 'msg'=>'系统错误', 'data'=>[]]);
    return;
}*/

// 亲^_^ 后面不需要任何代码了 就是如此简单