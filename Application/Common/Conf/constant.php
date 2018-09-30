<?php
return array(
    'DEGREEDICT' => array (
        '不限' ,
        '初中' ,
        '高中' ,
        '中技' ,
        '中专' ,
        '大专' ,
        '本科' ,
        'MBA&EMBA' ,
        '硕士' ,
        '博士' ,
        '其他'
    ) ,

    'RESUME_UPDATE_DAY' => array (
        '14' => [ 'id' => 14 , 'name' => '最近两周' ] ,
        '7' => [ 'id' => 7 , 'name' => '最近一周' ] ,
        '3' => [ 'id' => 3 , 'name' => '最近三天' ] ,
        '1' => [ 'id' => 1 , 'name' => '今天' ] ,
    ) ,

    'EMAILCONFIG' => array (
        1 => array (
            'charset' => 'UTF-8' ,// 设置邮件的字符编码
            'host' => 'smtpcloud.sohu.com' , // 您的企业邮局服务器
            'port' => 25 , // 设置端口
            'username' => 'hr.rencaiwa.com' , // 邮局用户名(请填写完整的email地址)
            'password' => "io5BxGiQ2Hwj2NPD" , // 邮局密码
            'from' =>array(
                0 => 'duantianya@vip.sina.com',
                1 => 'lvpengfei@vip.qq.com',
                2 => 'hr@vip.163.com',
                3 => 'maliangliang@outlook.com',
                4 => 'jane_zhang@126.com',
                5 => 'mina@zhaopin.com',
                6 => 'hr@zhaopin.com',
            ), //邮件发送者email地址
            'fromname' => '你的好朋友' ,
            ) ,
//        1 => array (
//            'charset' => 'UTF-8' ,// 设置邮件的字符编码
//            'host' => 'smtp.vip.sina.com' , // 您的企业邮局服务器
//            'port' => 25 , // 设置端口
//            'username' => 'duantianya@vip.sina.com' , // 邮局用户名(请填写完整的email地址)
//            'password' => "yuxuan1129" , // 邮局密码
//            'from' => 'duantianya@vip.sina.com' , //邮件发送者email地址
//            'fromname' => '你的HR好友' ,
//            ) ,
//        2 => array (
//            'charset' => 'UTF-8' ,// 设置邮件的字符编码
//            'host' => 'smtp.vip.sina.com' , // 您的企业邮局服务器
//            'port' => 25 , // 设置端口
//            'username' => 'wanghongchen@vip.sina.com' , // 邮局用户名(请填写完整的email地址)
//            'password' => "yuxuan1129" , // 邮局密码
//            'from' => 'wanghongchen@vip.sina.com' , //邮件发送者email地址
//            'fromname' => '你的好朋友' ,
//            ) ,
//        3 => array (
//            'charset' => 'UTF-8' ,// 设置邮件的字符编码
//            'host' => 'smtp.vip.sina.com' , // 您的企业邮局服务器
//            'port' => 25 , // 设置端口
//            'username' => 'rencaituijian@vip.sina.com' , // 邮局用户名(请填写完整的email地址)
//            'password' => "yuxuan1129" , // 邮局密码
//            'from' => 'rencaituijian@vip.sina.com' , //邮件发送者email地址
//            'fromname' => '你的好友' ,
//            )
    ) ,

    'EMAILTITLE' => array (
        'resumedetail' => 'Hi~{hrname}，{fromname}为你推荐了一位{jobname}--{resumename}' ,
        'resumetitle' => 'Hi~{hrname}，{fromname}为你推荐了一波{jobname}' ,
        //'advert' => 'Hi~{hrname}，你的好友向你推荐了一款免费招聘的App' ,
        'advert' => 'HI~{hrname}，送你一款免费招聘App，我觉得还不错' ,
    ) ,

    //后台测试发送的电子邮件
    'TESTEMAIL' => array (
        'maliang@lxcta.com' ,
        'zhongyucheng@lxcta.com' ,
        'lpnxtl@sina.com' ,
        '75938084@qq.com' ,
        '812176460@qq.com' ,
        'liuxuchao@lxcta.com' ,
     ) ,

    //人才蛙APP->我的->招聘邮箱
    //1.智联，2.前程 3.猎聘 4.拉钩(暂时不做)
    'RESUMEEMAIL' => array (
        array (
            'tag_id' => 1 ,
            'tag' => 'b\d.service@zhaopinmail.com',
            'tag_title' => '^智联求职者.*?',
            'tag_subject' => '^\(Zhaopin.com\) 应聘.*?',
        ) ,
        array (
            'tag_id' => 2 ,
            'tag' => 'resume@quickmail.51job.com',
            'tag_title' => '^前程无忧\[51job\].*?',
            'tag_subject' => '^\(51job.com\)申请.*?',
        ) ,
        array (
            'tag_id' => 3 ,
            'tag' => 'service@mail\d.lietou-edm.com',
            'tag_title' => '',
            'tag_subject' => '.*?来自猎聘网的候选人.*?',
        ) ,
        //array('tag_id'=>4,'tag'=>'service@mail30.lagoujobs.com'),
    ) ,

    'EMAIL_THRESHOLD' => 500 ,
    //0:qq邮箱 1:163邮箱 2:sina邮箱 3：126邮箱 4：139邮箱 5：hotmail邮箱 6：阿里企业云 7：腾讯企业云 8：网易企业云 9：其它邮箱
    'EMAIL_TYPE' => array ( 0 , 1 , 2 , 3 , 4 , 5 , 6 , 7 , 8 , 9 ) ,

    //企业邮箱列表
    'ENTERPRISE_EMAIL_LIST' =>array(
        array(
            'email_icon' => '/Api/emaillogo/ali.png',   //企业邮箱logo
            'email_name' => '阿里云企业邮箱',           //企业邮箱名称
            'email_pops' => array(                      //企业邮箱pops
                0 => 'pop3.mxhichina.com'
            ),
            'email_type' => 6,                          //阿里企业云
            'pop_url'    => '',                         //开启pop3的H5页面
            'pwd_type'   => 1,                          // 1密码  2授权码
        ),
        array(
            'email_icon' => '/Api/emaillogo/tencent.png',
            'email_name' => '腾讯企业邮箱',
            'email_pops' => array(
                0 =>'pop.exmail.qq.com'
            ),
            'email_type' => 7,
            'pop_url'    => '',
            'pwd_type'   => 1,
        ),
        array(
            'email_icon' => '/Api/emaillogo/net.png',
            'email_name' => '网易企业邮箱',
            'email_pops' => array(
                0 =>'pop.qiye.163.com'
            ),
            'email_type' => 8,
            'pop_url'    => '',
            'pwd_type'   => 1,
        ),
    ),
    //个人邮箱列表
    'PERSONAL_EMAIL_LIST' =>array(
        array(
            'email_address' =>array(
                array(
                  'email_add'=>'@qq.com',               //邮箱后缀
                  'email_pop'=>'pop.qq.com',            //邮箱pop3
                ),
                array(
                    'email_add'=>'@foxmail.com',
                    'email_pop'=>'pop.qq.com',
                ),
                array(
                    'email_add'=>'@vip.qq.com',
                    'email_pop'=>'pop.vip.qq.com',
                ),
            ),
            'email_icon' => '/Api/emaillogo/qq.png',    //企业邮箱logo
            'email_name' => 'QQ/Foxmail',               //企业邮箱名称
            'email_type' => 0,                          //阿里企业云
            'pop_url'    => '/Home/Html/pop3/qq.html',  //开启pop3的H5页面
            'pwd_type'   => 2,                          // 1密码  2授权码
        ),
        array(
            'email_address' =>array(
                array(
                    'email_add'=>'@163.com',
                    'email_pop'=>'pop.163.com',
                ),
                array(
                    'email_add'=>'@vip.163.com',
                    'email_pop'=>'pop.vip.163.com',
                ),
            ),
            'email_icon' => '/Api/emaillogo/163.png',
            'email_name' => '163邮箱',
            'email_type' => 1,
            'pop_url'    => '/Home/Html/pop3/163.html',
            'pwd_type'   => 2,
        ),
        array(
            'email_address' =>array(
                array(
                    'email_add'=>'@126.com',
                    'email_pop'=>'pop.126.com',
                ),
                array(
                    'email_add'=>'@vip.126.com',
                    'email_pop'=>'pop.vip.126.com',
                ),
            ),
            'email_icon' => '/Api/emaillogo/126.png',
            'email_name' => '126邮箱',
            'email_type' => 3,
            'pop_url'    => '/Home/Html/pop3/126.html',
            'pwd_type'   => 2,
        ),
        array(
            'email_address' =>array(
                array(
                    'email_add'=>'@sina.com',
                    'email_pop'=>'pop.sina.com',
                ),
                array(
                    'email_add'=>'@vip.sina.com',
                    'email_pop'=>'pop.vip.sina.com',
                ),
                array(
                    'email_add'=>'@sina.cn',
                    'email_pop'=>'pop.sina.cn',
                ),
            ),
            'email_icon' => '/Api/emaillogo/sina.png',
            'email_name' => '新浪邮箱',
            'email_type' => 2,
            'pop_url'    => '/Home/Html/pop3/sina.html',
            'pwd_type'   => 1,
        ),
        array(
            'email_address' =>array(
                array(
                    'email_add'=>'@hotmail.com',
                    'email_pop'=>'pop-mail.outlook.com',
                ),
                array(
                    'email_add'=>'@outlook.com',
                    'email_pop'=>'pop-mail.outlook.com',
                ),
            ),
            'email_icon' => '/Api/emaillogo/outlook.png',
            'email_name' => 'Outlook/Hotmail',
            'email_type' => 5,
            'pop_url'    => '/Home/Html/pop3/outlook.html',
            'pwd_type'   => 1,
        ),
        array(
            'email_address' =>array(
                array(
                    'email_add'=>'@139.com',
                    'email_pop'=>'pop.139.com',
                ),
            ),
            'email_icon' => '/Api/emaillogo/139.png',
            'email_name' => '139邮箱',
            'email_type' => 4,
            'pop_url'    => '/Home/Html/pop3/139.html',
            'pwd_type'   => 1,
        ),
    ),
    //其他邮箱pop池
    'OTHERS_POP_LIST' => array(
        0 => 'pop.bnet.cn',
        1 => 'pop.euchost.com',
        2 => 'pop.qiye.163.com',
        3 => 'pop3.net269.cn',
        4 => 'pop.139.com',
        5 => 'mail.sohu.net',
        6 => 'mx650.now.net.cn',
        7 => 'pop3.mxhichina.com',
        8 => 'pop.exmail.qq.com',
        9 => 'pop.qq.com',
        10 => 'pop.163.com',
        11 => 'pop.126.com',
        12 => 'pop.sina.com',
        13 => 'pop-mail.outlook.com',
    ),
        
    //发送邀请邮件的 发送者的邮箱
    'SEND_INVITE_EMAIL_FROM_LIST' => [
        'duantianya@vip.sina.com',
        'lvpengfei@vip.qq.com',
        'hr@vip.163.com',
        'maliangliang@outlook.com',
        'jane_zhang@126.com',
        'mina@zhaopin.com',
        'hr@zhaopin.com',
        'zhongyi@126.com'
    ],
    //发送邀请邮件的 测试环境的接收者的邮箱
    'SEND_INVITE_EMAIL_TEST_TO_LIST' => 'finallodges@126.com',
    //邮件打开调用地址标记邮件已经被打开
    'OPEN_EMAIL_REWUEST_API' => '/Api/LoadInvite/changeEmailReadStatus',





























);