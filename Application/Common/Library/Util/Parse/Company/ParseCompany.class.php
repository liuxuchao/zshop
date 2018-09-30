<?php
namespace Common\Library\Util\Parse\Company;

/**
 * 解析公司内容
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-13 9:42:33
 */
class ParseCompany extends \Common\Library\Util\Parse\Parse
{
    /**
     * 公司页面HTML
     * @var string
     */
    protected $companyHtml;
    
    /**
     * 渠道类型ID，1：智联；2：51job
     * @var int 
     */
    protected $channelType;
    
    /**
     * 职位原网址
     * @var type 
     */
    protected $companyUrl;
    
    protected $companyInfo = [
        "channel" => "",
        "name" => '',
        "size" => '',
        "nature" => '',
        "industry" => '',
        "website" => '',
        "address" => '', 
        "introduce" => '',
        "originurl" => '',
        "originid" => '',
    ];
}
