<?php
namespace Common\Library\Util\Parse\Job;

/**
 * Description of ParseJob
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-6 15:30:44
 */
abstract class ParseJob extends \Common\Library\Util\Parse\Parse
{
    /**
     * 渠道类型ID，1：智联；2：51job
     * @var int 
     */
    protected $channelType;
    
    /**
     * 采集到的职位页面HTML
     * @var string
     */
    protected $jobHtml;
    
    /**
     * 职位原网址
     * @var type 
     */
    protected $jobUrl;
    
    /**
     * 原职位ID
     * @var string 
     */
    protected $originalId;
    
    /**
     * 解析好职位数组
     * @var array
     */
    protected $jobInfo = [
        "companyid" => '', //公司原ID
        "name" => "",
        "companyname" => "",
        "salary" => "",
        "workplace" => "",
        "publishdate" => "",
        "workproperty" => "",
        "experience" => "",
        "education" => "",
        "qty" => 0, //招聘人数
        "category" => "",
        "descrip" => "",
        "welfare" => "",
        "age" => "",
        "languge" => "",
        "jobUrl" => "",
        "stage" => "",
        "department" => "",
        "professional" => "",
        "reportto" => "",
        "member" => 0,
        "originurl" => "",
        "originid" => "" //职位原ID
    ];
    
    public abstract function parse();
    
    
}
