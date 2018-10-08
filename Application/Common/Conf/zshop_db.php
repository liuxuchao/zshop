<?php
/**
 * crap数据库连接配置
 */
return [
    'ZSHOP_DB' => [
        //数据库配置信息
        //'DB_DEPLOY_TYPE'=> 1, // 设置分布式数据库支持,1 可以采用分布式数据库支持。
        'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => '127.0.0.1', // 服务器地址
        'DB_NAME'   => 'zshop', // 数据库名
        'DB_USER'   => 'root', // 用户名
        'DB_PWD'    => 'root', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => '', // 数据库表前缀 
        'DB_CHARSET'=> 'utf8', // 字符集
        'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
        //'DB_RW_SEPARATE'=>true,//读写分离
    ],    


];
