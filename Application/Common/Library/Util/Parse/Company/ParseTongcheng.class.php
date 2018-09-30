<?php
namespace Common\Library\Util\Parse\Company;

use Common\Library\Util\Parse\Company\ParseCompany;

/**
 * Description of ParseQiancheng
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-13 13:11:42
 */
class ParseTongcheng extends ParseCompany
{
    private $patternCompanyName = '/<a.*?href=".*?".*?tongji_tag="\m_detail_job_full_qyml\">(.*?)<\/a>/i';
    private $patternCompanName_2= '/<a.*?tongji_tag=\"m_detail_job_parttime_qyml\">(.*?)<\/a>/i';
    private $patternCompanName_3= '/<span.*?class=\"company_name\">[\s\S]+?(.*?)[\s\S]+?<style.*?>/i';
    private $patternCompanyProperty = '/<li><span.*?class=\"attrName\">.*?规模：<\/span><span.*?class=\"attrValue\">(.*?)<\/span><\/li>/i';
    private $patternCompanyNature = '/<li><span.*?class=\"attrName\">性质：<\/span><span.*?class=\"attrValue\">(.*?)<\/span><\/li>/i';
    private $patternCompanyTrade = '/<span\s+class=\"attrValue\">[\s\S]+?<a.*?target=\"_blank\"\s+>(.*?)<\/a>[\s\S]+?<\/span>/i';
    private $patternCompanyWebsite = '/<h2.*?class=\"c_tit\">[\s\S]+?<a.*?href=\"(.*?)\".*?tongji_tag=\"m_detail_job_full_qyml\">.*?<\/a>[\s\S]+?<\/h2>/i';
    private $patternCompanyAddress = '/<li><span.*?class=\"attrName\">地址：<\/span>[\s\S]+?(.*?)[\s\S]+?<\/li>/i';
    private $patternCompanyIntroduce = '/<div.*?class=\"company_con\s+btOnepx\">[\s\S]+?<p>(.*?)<\/p>[\s\S]+?<\/div>/i';
    private $patternCompanyOriginalId = '/http\:\/\/qy\.m\.58\.com\/m_detail\/(.*?)\//i';
    
    public function __construct($channelType, $companyHtml, $companyUrl)
    {
        #echo $companyHtml;
        #exit();
        $this->channelType = 5;
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
        $this->companyInfo['name'] = $this->parseCompanyName();
        if ( empty($this->companyInfo['name']) ) {
            return [];
        }
        
        
        $this->companyInfo['channel'] = $this->channelType;
        $this->companyInfo['size'] = $this->parseCompanyScale();
        $this->companyInfo['nature'] = $this->parseCompanyNature();
        $this->companyInfo['industry'] = $this->parseCompanyIndustry();
        $this->companyInfo['website'] = $this->parseCompanyWebsit();
        $this->companyInfo['address'] = $this->parseCompanyAddress();
        $this->companyInfo['introduce'] = $this->parseCompanyIntroduce();
        $this->companyInfo['originurl'] = $this->parseCompanyWebsit();
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
            return trim($match[1]);
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
            return trim(str_replace('地址：','',strip_tags($match[0])));
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
        if ( preg_match($this->patternCompanyTrade, $this->companyHtml, $match) ) {
            return $match[1];
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
        if ( preg_match($this->patternCompanyNature, $this->companyHtml, $match) ) {
            return trim($match[1]);
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
        if ( preg_match($this->patternCompanyProperty, $this->companyHtml, $match) ) {
            return $match[1];
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
        if ( preg_match($this->patternCompanyName,$this->companyHtml, $match) ) {
            return strip_tags($match[1]);
        }
        if (preg_match($this->patternCompanName_2, $this->companyHtml,$match)) {
            return $match[1];
        }
        if ( preg_match($this->patternCompanName_3,$this->companyHtml, $match) ) {
            return trim(strip_tags($match[0]));
        }
        return '';
    }    
    
}
