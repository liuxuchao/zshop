<?php
namespace Common\Library\Util\Parse\Company;

use Common\Library\Util\Parse\Company\ParseCompany;

/**
 * 解析猎聘公司信息
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2017-1-19 10:22:51
 */
class ParseLiepin extends ParseCompany
{
    private $patternCompanyInfo = '/<div\s+?class="company-infor">([\s\S]+?)<\/div>/i'; //右侧公司信息
    private $patternCompanyName = '/<h4>\s*?<a[\s\S]+?>(.+?)<\/a>[\s\S]+?<\/h4>/i'; //公司名称
    private $patternCompanyScale = '/<ul>\s*?<li>[\s\S]+?<\/li>\s*?<li>(.+?)<\/li>\s*?<li>.+?<\/li>\s*?<\/ul>/i'; //公司规模
    private $patternCompanyProperty = '/<ul>\s*?<li>[\s\S]+?<\/li>\s*?<li>.+?<\/li>\s*?<li>(.+?)<\/li>\s*?<\/ul>/i'; //公司性质，国企私企等。
    private $patternCompanyIndustry = '/<ul>\s*?<li>\s*?<a.+?>(.+?)<\/a>\s*?<\/li>\s*?<li>.+?<\/li>\s*?<li>.+?<\/li>\s*?<\/ul>/i'; //公司行业
    private $patternCompanyIntroduce = '/<h3\s+?class="job-title">企业介绍：<\/h3>\s*?<div.+?>([\s\S]+?)<\/div>/i'; //公司介绍
    private $patternCompanyAddress = '/<p>\s*?<i\s+?class="icons16\s+?icons16-position"><\/i>(.+?)<\/p>/i'; //公司地址
    private $patternCompanyOriginalId = '/<h4>\s*?<a[\s\S]+?href="https:\/\/www\.liepin\.com\/company\/(.+?)\/"[\s\S]+?>.+?<\/a>[\s\S]+?<\/h4>/i'; //公司ID
    
    public function __construct($channelType, $companyHtml, $companyUrl)
    {
        $this->channelType = $channelType;
        $this->companyHtml = $companyHtml;
        $this->companyUrl = $companyUrl;
        
        $encoding = mb_detect_encoding($this->companyHtml, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5') );
        $this->companyHtml = mb_convert_encoding($this->companyHtml, "UTF-8", $encoding);
    }
    
    /**
     * 解析
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-1-19 10:22:51
     * @return array 解析结果数组
     */
    public function parse()
    {
        if (!preg_match($this->patternCompanyInfo, $this->companyHtml, $companyInfo)) {
            return [];
        }
        
        $this->companyInfo['channel'] = $this->channelType;
        $this->companyInfo['name'] = $this->parseStr($this->patternCompanyName, $companyInfo[1]);
        $this->companyInfo['size'] = $this->parseStr($this->patternCompanyScale, $companyInfo[1]);
        $this->companyInfo['nature'] = $this->parseStr($this->patternCompanyProperty, $companyInfo[1]);
        $this->companyInfo['industry'] = $this->parseStr($this->patternCompanyIndustry, $companyInfo[1]);
//        $this->companyInfo['website'] = $this->parseCompanyWebsit();
        $this->companyInfo['address'] = $this->parseStr($this->patternCompanyAddress, $companyInfo[1]);
        $this->companyInfo['introduce'] = $this->parseStr($this->patternCompanyIntroduce, $this->companyHtml, ['trim']);
        $this->companyInfo['originurl'] = $this->companyUrl;
        $this->companyInfo['originid'] = $this->parseStr($this->patternCompanyOriginalId, $this->companyHtml, ['trim']);
        return $this->companyInfo;
    }
}
