<?php
namespace Common\Library\Util\Parse\Company;

use Common\Library\Util\Parse\Company\ParseCompany;

/**
 * Description of ParseQiancheng
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-13 13:11:42
 */
class ParseGanji extends ParseCompany
{
    private $patternCompanyName = '/<a\s+href=\".*?gongsi_\d+.*?\">(.*?)<\/a>/i';
    private $patternCompanyProperty = '/<tr>[\s\S]+?<th\s+.*?>规.*?模<\/th><td>(.*?)<\/td>[\s\S]+?<\/tr>/i';
    private $patternCompanyNature = '/<tr>[\s\S]+<th>类.*?型<\/th><td><a\s+href=\".*?\">(.*?)<\/a><\/td>[\s\S]+?<\/tr>/i';
    private $patternCompanyTrade = '/<tr>[\s\S]+<th>行.*?业<\/th><td><a\s+href=\".*?\">(.*?)<\/a><\/td>[\s\S]+?<\/tr>/i';
    private $patternCompanyWebsite = '/<div\s+class=\"com-name\"><a\s+href="(.*?)">.*?<\/a>[\s\S]+?<\/div>/i';
    private $patternCompanyAddress = '/<th>地.*?址<\/th><td>(.*?)<\/td>/i';
    private $patternCompanyIntroduce = '/<td.*?colspan=\"\d\">[\s\S]+?<span.*?class=\"comp-intro\".*?>介.*?绍<\/span>[\s\S]+?(.*?)<\/td>/i';
    private $patternCompanyOriginalId = '/<a\s+href=\".*?gongsi_(\d+).*?\">/i';
    private $patternOriginurl = '/<p\s+class=\"details-btn\"><a\s+href=\"(.*?)\"\s+.*?>立即完善<\/a><\/p>/i';
    
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
        $this->companyInfo['originurl'] = $this->parseJobWebsit();
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
            $match = preg_replace(['/<span.*?class=\"comp-intro\".*?>介.*?绍<\/span>/i','/<td.*?colspan=\"2\">/i','/<\/td>/i'], '', $match[0]);
            return trim($match);
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
            return trim($match[1]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司官网
     * @return string
     */
    private function parseJobWebsit()
    {
        if ( preg_match($this->patternOriginurl, $this->companyHtml, $match) ) {
            return trim($match[1]);
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
            if(strstr($match[1], 'http://3g.ganji.com')){
                return $match[1] ;
            }
            return 'http://3g.ganji.com'.trim($match[1]);
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
            return trim($match[1]);
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
            return trim($match[1]);
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
            return trim($match[1]);
        } else {
            return '';
        }
    }    
    
}
