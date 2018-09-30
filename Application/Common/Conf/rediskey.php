<?php
/* 
 * Redis key 设置
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return [
    'USER_LOGIN_STATUS_KEY' => 'uu_recommend:user_login_status', //登录后的数据
    'AUTH_CODE_KEY'         => 'uu_recommend:auth_code', //验证码
    'RESUME_KEY'            => 'uu_recommend:resume', //简历
    
    'USER_PRICE_CONFIG_KEY'  => 'uu_recommend:user_price_config', //给求职者发送职位邀请的单价配置key
    'SMS_LOG_KEY'           => 'uu_recommend:sms_log', //短信发送日志
    'DCIT_KEY'=>'uu_recommend:lxc_dict',
//    "JOB_INDEX_TASK_KEY" => "uu_recommend:job_index_task", //用户绑定职位时需要把采集过来的职位信息放到索引中。这个KEY存放的是生成索引的任务队列。添加生成职位索引的任务。添加到Redis队列中。
    "LEXICON_DESCRIPTION_LAST_SAVE_NAME"=>'uu_recommend:lexicon_description_last_save_name', //职位描述 词库 最后一次保存的名称 
    "LEXICON_DESCRIPTION_LAST_SAVE_TIME"  =>'uu_recommend:lexicon_description_last_save_time',   //职位描述 词库 最后一次保存的时间 （字符串格式时间）
    "LEXICON_CORE_DATA" =>'uu_recommend:lexicon_core_data',   //职位核心词库（包括核心词，修饰词，副词） 所有使用中的词
    "LEXICON_DESCRIPTION_DATA"  =>'uu_recommend:lexicon_description_data',   //职位描述 词库 所有使用中的词
    'REASONS_REJECTION'=>'uu_recommend:reasons_rejection',//拒绝理由缓存
    'RESUME_NUM_THREE_DAY'=>'uu_recommend:resume_num_three_day',//最近三天的数据更新的数据量 缓存
    'DICT_TRADES'=>'uu_recommend:dict_trades',//行业字典
    'DICT_AREA'=>'uu_recommend:dict_areas',//地区字典
    'DICT_AREA_ES'=>'uu_recommend:dict_areas_es',//169地区字典
    'DICT_AREA_ES_API'=>'uu_recommend:dict_areas_es_api',//接口转字典  6.169 的字典
    'DICT_AREA_CN_KEY'=>'uu_recommend:dict_areas_cn_key',//接口转字典  6.169 的字典 二级城市的字典 汉字为键 
    'FILTER_RESUME_ID_LIST_OF_JOB_ID_KEY'=>'uu_recommend:filter_resume_id_list_of_jobs_id_key',// 职位下的需要过滤的 推荐过得 的简历id的缓存。 
    'FILTER_RESUME_ID_LIST_OF_GLOBAL_KEY'=>'uu_recommend:filter_resume_global_id_key',// 全局需要过滤的 推荐过得 的简历id的缓存
    'JOB_ORIGIN_LIST'=>'uu_recommend:job_origin_list',
    'INDEX_BANNER_LIST' => 'uu_recommend:index_banner_list', //首页banner缓存数据
    'DICT_CITY_ALL_DATA' => 'uu_recommend:dict_city_all_data',   //城市字典缓存数据
];

