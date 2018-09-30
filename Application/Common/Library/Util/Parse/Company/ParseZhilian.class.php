<?php
namespace Common\Library\Util\Parse\Company;

use Common\Library\Util\Parse\Company\ParseCompany;

/**
 * 解析公司
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-13 9:45:33
 */
class ParseZhilian extends ParseCompany
{
    private $patternCompanyInfo = '/<div\s+?class="company-box">([\s\S]+?)<\/div>/i';
    private $patternName = '/<p\s*?class="company-name-t"><a\s*?rel="nofollow".+?>(.+?)<\/a><\/p>/i';
    private $patternScale = '/<li><span>公司规模：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternNature = '/<li><span>公司性质：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternIndustry = '/<li><span>公司行业：<\/span><strong><a.+?>(.+?)<\/a><\/strong><\/li>/i';
    private $patternWebsit = '/<li><span>公司主页：<\/span><strong><a.+?>(.+?)<\/a><\/strong><\/li>/i';
    private $patternAddress = '/<li>\s*?<span>公司地址：<\/span><strong>\s*?(.+?)<br>[\s\S]*?<\/strong>\s*<\/li>/i';
    private $patternIntroduce = '/<div\s*?class="tab-inner-cont"\s*?style="display:none;word-wrap:break-word;">([\s\S]+?)<\/p>\s*?<\/div>/i';
    private $patternOriginalId = '/<p\s+?class="company-name-t"><a\s+?rel="nofollow"\s+?href="http:\/\/company\.zhaopin\.com\/(.+?)\.htm"/i';
    private $patternOriginalId_0 = '/var\s*?PositionExtID\s*?=\s*?"(.+?)";/i';
    private $patternOriginalId_1 = '/<p\s+?class="company-name-t"><a\s+?rel="nofollow"\s+?href="http:\/\/company\.zhaopin\.com\/.+?_(.+?)\.htm"/i';
    private $companyHead = '';
    
    public function __construct($channelType, $companyHtml, $companyUrl)
    {
        $this->channelType = $channelType;
        $this->companyHtml = $companyHtml; //其实是职位详情页，公司信息都是从职位详情页解析出来的。
        $this->companyUrl = $companyUrl;
    }
    
    /**
     * 解析公司内容
     */
    public function parse()
    {
        $this->companyHead = $this->parseCompanyInfo();
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
     * 从职位ID中提取公司信息
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-04 11:25
     * @param string $originalJobId 原始职位ID
     * @return string
     */
    public static function buildCompanyOriginalId($originalJobId)
    {
        $originalJobId = trim($originalJobId);
        $companyId = str_replace('CC', '', $originalJobId);
        return 'CC' . substr($companyId, 0, 9);
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
        if (preg_match($this->patternOriginalId_1, $this->companyHead, $match)) {
            return $match[1];
        } else if ( preg_match($this->patternOriginalId, $this->companyHead, $match) ) {
            return $match[1];
        } else if ( preg_match($this->patternOriginalId_0, $this->companyHtml, $match) ) {
            $match[1] = trim( $match[1] );
            return self::buildCompanyOriginalId($match[1]);
        } else {
            return "";
        }
    }
    
    /**
     * 解析公司简介
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 12:50
     * @return string
     */
    private function parseCompanyIntroduce()
    {
        $companyHtml = preg_replace('/<DIV\s*?style\="FONT-SIZE:\s*?[\0-9]+?px;\s*?FONT-FAMILY:\s*?宋体">&nbsp;<\/DIV>/i', '', $this->companyHtml);
        if ( preg_match($this->patternIntroduce, $companyHtml, $match) ) {
            $desc = trim($match[1]);
            $pattern = ['/<a.+?>/i', '/<\s*?\/?\s*?a>/i', '/该公司其他职位/'];
            $desc = preg_replace($pattern, ['', '', ''], $desc);
            return $desc;
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司地址
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 12:35
     * @return string
     */
    private function parseCompanyAddress()
    {
        if ( preg_match($this->patternAddress, $this->companyHead, $match) ) {
            return strip_tags(trim($match[1]));
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司网址
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 11:52
     * @return string
     */
    private function parseCompanyWebsit()
    {
        if ( preg_match($this->patternWebsit, $this->companyHead, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司信息。
     * @return string
     */
    private function parseCompanyInfo()
    {
        if ( preg_match($this->patternCompanyInfo, $this->companyHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司名称
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 11:33
     * @return string
     */
    private function parseCompanyName()
    {
        if ( preg_match($this->patternName, $this->companyHead, $match) ) {
            return strip_tags( trim($match[1]) );
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司规模
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 11:38
     * @return string
     */
    private function parseCompanyScale()
    {
        if ( preg_match($this->patternScale, $this->companyHead, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司性质
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 11:38
     * @return string
     */
    private function parseCompanyNature()
    {
        if ( preg_match($this->patternNature, $this->companyHead, $match) ) {
            return strip_tags($match[1]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司行业
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-13 11:38
     * @return string
     */
    private function parseCompanyIndustry()
    {
        if ( preg_match($this->patternIndustry, $this->companyHead, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
   
}
