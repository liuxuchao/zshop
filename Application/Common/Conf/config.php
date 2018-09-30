<?php

return array(
    //配置模块
    'MODULE_ALLOW_LIST' => array('Home','Admin','Api'),
    'DEFAULT_MODULE'    => 'Home', //默认模块
    
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	'URL_MODEL' =>  1,
    
    //注册新的命名空间
    'AUTOLOAD_NAMESPACE' => array(
        'Application'    => APP_PATH,
    ),
    'APP_HOST' => 'www.zshop.me',
    'API_HOST' => 'api.zshop.me',
    'UPLOAD_PATH' => './Upload/',
    'ENVIROMENT' => 1, //1为开发环境  2：为测试环境
    
    //静态文件版本号码
    'CSS_VERSION' => 1,
    'JS_VERSION'  => 1,
    
    //模板标签配置
    'TMPL_L_DELIM' => '<{',
    'TMPL_R_DELIM' => '}>',
    
    'SESSION_USER_NAME'=>'just_of_name',
    'SESSION_NAME_LENGTN'=>'12',
    'SESSION_KEEP_TIME'=>'3600',
    //加密用的KEY
    'ENCRYPT_KEY'       => 'cSaZ8ZEJAnvZmfae5sKSf1g3CPsEeeq0Iw==',
    'ENCRYPT_PROMOTE_KEY' => '526a39f8c9001b15903d43253fec7129', //推广使用的生成密码用的KEY，追加到明文密码后生成MD5
    'PASSWORD_KEY'      => 'cSaZ8ZEJAnvZmfae5sKSf1g3CPsEeeq0Iw==', //生成密码用的KEY，追加到明文密码后生成MD5
    'SEND_MSM_TOKEN'    => '0xbefd1c9b00050f02', //发送短信的token明文
    'AUTH_CODE_LENGTH'  => 6, //验证码长度
    'COLLECT_TOKEN'     => 'KeepMoving![root@localhost', //和采集通讯时用到的标识，明文。
    
    //登录状态数据在Redis中存储的有效期，单位：秒。不代表登录有效期。
    'LOGIN_STATUS_DATA_TTL' => 600,
    
    //密码长度配置
    'PASSWORD_MAX_LENGTH' => 16,
    'PASSWORD_MIN_LENGTH' => 6,
    
   

    //加载配置文件
    'LOAD_EXT_CONFIG' => 'zshop_db,redis,rediskey',
);