<?php
namespace Common\Library\Util\Parse\Company;

use Common\Library\Util\Parse\Company\ParseCompany;

/**
 * Description of ParseQiancheng
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-13 13:11:42
 */
class ParseQiancheng extends ParseCompany
{
    private $patternCompanyHead = '/<div\s*?class="cn">([\s\S]+?)<\/div>/i';
    private $patternCompanyName = '/<p\s*?class="cname">\s*?<a.+?>(.+?)<em\s*?.+?><\/em><\/a>\s*?<\/p>/i';
    private $patternCompanyProperty = '/<p.*?class=\"msg\s+ltype\">[\s\S]+?(.*?)<\/p>/i';
    private $patternCompanyWebsite = '/<a.*?class=\"icon_b\s+i_house\".*?href="(.*?)".*?target=\"_blank\">该公司所有职位<\/a>/i';
    private $patternCompanyAddress = '/<span.*?class=\"label\">上班地址：<\/span>(.*?)<\/p>/i';
    private $patternCompanyIntroduce = '/<h2>\s*?<span\s*?class="bname">公司信息<\/span>\s*?<\/h2>\s*?<div\s*?class="tmsg\s*?inbox">([\s\S]+?)<\/div>/i';
    private $patternCompanyOriginalId = '/<p\s*?class="cname">\s*?<a\s*?href="http:\/\/jobs\.51job\.com\/all\/(.+?)\.html".+?>/i';
    
    private $companyHead = '';
    
    public function __construct($channelType, $companyHtml, $companyUrl)
    {
        $this->channelType = $channelType;
        $this->companyHtml = $companyHtml;
        $this->companyUrl = $companyUrl;
        
        $encoding = mb_detect_encoding($this->companyHtml, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5') );
        $this->companyHtml = mb_convert_encoding($this->companyHtml, "UTF-8", $encoding);
    }
    
    /**
     * 解析公司内容
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 13:43
     * @return array
     */
    public function parse()
    {
        
        $this->companyHead = $this->parseCompanyHead();
        if ( empty($this->companyHead) ) {
            return [];
        }
        
        $this->companyInfo['channel'] = $this->channelType;
        $this->companyInfo['name'] = $this->parseCompanyName();
        $this->companyInfo['size'] = $this->parseCompanyScale();
        $this->companyInfo['nature'] = $this->parseCompanyNature();
        $this->companyInfo['industry'] = $this->parseCompanyIndustry();
        $this->companyInfo['website'] = $this->parseCompanyWebsit();
        $this->companyInfo['address'] = $this->parseCompanyAddress();
        $this->companyInfo['introduce'] = $this->parseCompanyIntroduce();
        $this->companyInfo['originurl'] = $this->companyUrl;
        $this->companyInfo['originid'] = $this->parseCompanyOriginid();
        return $this->companyInfo;
    }
    
    /**
     * 解析公司原id
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 13:06
     * @return string
     */
    private function parseCompanyOriginid()
    {
//        $pathinfo = pathinfo($this->companyUrl);
//        return $pathinfo['filename'];
        if ( preg_match($this->patternCompanyOriginalId, $this->companyHtml, $match) ) {
            return $match[1];
        } else {
            return "";
        }
    }
    
    /**
     * 解析公司简介
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 15:43
     * @return string
     */
    private function parseCompanyIntroduce()
    {
        if ( preg_match($this->patternCompanyIntroduce, $this->companyHtml, $match) ) {
            return strip_tags($match[1]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司地址
     * @return string
     */
    private function parseCompanyAddress()
    {
        if ( preg_match($this->patternCompanyAddress, $this->companyHtml, $match) ) {
            $address = $match[1];
            $address = str_replace(['	', ' '], '', $address);
            $address = strip_tags(trim($address));
            return $address;
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司官网
     * @return string
     */
    private function parseCompanyWebsit()
    {
        if ( preg_match($this->patternCompanyWebsite, $this->companyHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 公司行业
     * @return string
     */
    private function parseCompanyIndustry()
    {
        if ( preg_match($this->patternCompanyProperty, $this->companyHead, $match) ) {
            $property = trim($match[1]);
            $propertyArray = explode('|', $property);
            $companyIndustry = trim($propertyArray[2]);
            $companyIndustry = str_replace('&nbsp;', '', $companyIndustry);
            return $companyIndustry;
        } else {
            return '';
        }
    }
    
    /**
     * 公司类型
     * @return string
     */
    private function parseCompanyNature()
    {
        if ( preg_match($this->patternCompanyProperty, $this->companyHead, $match) ) {
            $property = trim($match[1]);
            $propertyArray = explode('|', $property);
            $companyNature = trim($propertyArray[0]);
            $companyNature = str_replace('&nbsp;', '', $companyNature);
            return trim($companyNature);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司规模
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 15:20
     * @return string
     */
    private function parseCompanyScale()
    {
        if ( preg_match($this->patternCompanyProperty, $this->companyHead, $match) ) {
            $property = trim($match[1]);
            $propertyArray = explode('|', $property);
            $companySize = trim($propertyArray[1]);
            $companySize = str_replace('&nbsp;', '', $companySize);
            return trim($companySize);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司名称
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 15:13
     * @return string
     */
    private function parseCompanyName()
    {
        if ( preg_match($this->patternCompanyName, $this->companyHead, $match) ) {
            return strip_tags($match[1]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司信息头部信息
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 14:42
     * @return string
     */
    private function parseCompanyHead()
    {
        if ( preg_match($this->patternCompanyHead, $this->companyHtml, $match) ) {
            return trim($match[1]);
        } else {
            return '';
        }
    }
    
    
}
