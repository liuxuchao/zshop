<?php
namespace Common\Library\Util\Parse\Job;

use Common\Library\Util\Parse\Job\ParseJob;

/**
 * 解析前程无忧的职位信息
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-7 16:00:54
 */
class ParseQiancheng extends ParseJob
{
    
    private $patternJobName = '/<h1.+?>(.+?)<\/h1>/i';
    private $patternCompanyId = '/<p\s+?class="cname">\s*?<a\s+?href="http:\/\/jobs\.51job\.com\/all\/(.+?)\.html".+?>.+?<\/a>\s*<\/p>/i';
    private $patternCompanyName = '/<p\s+?class="cname">\s*?<a.+?>(.+?)<\/a>\s*?<\/p>/i';
    private $patternJobHead = '/<div\s+?class="cn">([\s\S]+?)<\/div>/';
    private $patternSalary = '/<strong>(.+?)<\/strong>/i';
    private $patternWorkplace = '/<span\s+?class="lname">(.+?)<\/span>/';
    private $patternWelfare = '/<div\s+?class="t1">([\s\S]+?)<\/p>\s*?<\/div>/i';
    private $patternPublishDate = '/<span\s+?class="sp4"><em\s+?class="i4"><\/em>(.+?)<\/span>/i';
    private $patternExperience = '/<span\s+?class="sp4"><em\s+?class="i1"><\/em>(.+?)<\/span>/i';
    private $patternEducation = '/<span\s+?class="sp4"><em\s+?class="i2"><\/em>(.+?)<\/span>/i';
    private $patternNumber = '/<span\s+?class="sp4"><em\s+?class="i3"><\/em>(.+?)<\/span>/i';
    private $patternCompanyInfo = '/<span\s+?class\="label">职能类别：<\/span>\s*?<span.+?>(.+?)<\/span>/i';
    private $patternJobDes = '/<span\s+?class="label">职位描述：<\/span>([\s\S]+?)<\/div>/i';
    private $patternWel = '/<p\s+?class="t2">([\s\S]+?)$/i';
    private $patternLanguge = '/<span\s+?class="sp2".+?><em\s+?class="i5"><\/em>(.+?)<\/span>/i';
    private $patternCompanyDesc = '/<h2>\s*<span\s+?class="bname">公司信息<\/span>\s*?<\/h2>\s*?	<div\s+?class="tmsg\s+?inbox">([\s\S]+?)<\/div>/i';
    private $patternCompanyUrl = '/<p\s+?class="cname">\s*?<a\s+?href="(.+?)".+?>.+?<\/a>\s*<\/p>/i';
    
    private $jobHead = '';
    private $jobWelfare = '';
    
    public function __construct($channelType, $jobHtml, $jobUrl, $originalId)
    {
        $this->channelType = $channelType;
        $this->jobHtml = $jobHtml;
        $this->jobUrl = $jobUrl;
        $this->originalId = $originalId;
        $encoding = mb_detect_encoding($this->jobHtml, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5') );
        $this->jobHtml = mb_convert_encoding($this->jobHtml, "UTF-8", $encoding);
    }
    
    /**
     * 解析职位
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-07 16:10
     * @return array
     */
    public function parse()
    {
        //职位头部信息，包括职位名称，公司名称，工作地点，薪资待遇。
        $this->jobHead = $this->parseJobHead();
        if ( empty($this->jobHead) ) {
            return [];
        }
        
        //职位福利待遇，工作年限
        $this->jobWelfare = $this->parseStr($this->patternWelfare, $this->jobHtml, []);
        
        $this->jobInfo['name'] = $this->parseJobName();
        if ( empty($this->jobInfo['name']) ) {
            return [];
        }
        $this->jobInfo['companyid'] = $this->parseCompanyId();
        $this->jobInfo['companyname'] = $this->parseStr($this->patternCompanyName, $this->jobHead);
        $this->jobInfo['salary'] = $this->parseStr($this->patternSalary, $this->jobHead);
        $this->jobInfo['workplace'] = $this->parseStr($this->patternWorkplace, $this->jobHead);
        $this->jobInfo['publishdate'] = $this->parseStr($this->patternPublishDate, $this->jobWelfare);
        $this->jobInfo['workproperty'] = '';
        $this->jobInfo['experience'] = $this->parseStr($this->patternExperience, $this->jobWelfare);
        $this->jobInfo['education'] = $this->parseStr($this->patternEducation, $this->jobWelfare);
        $this->jobInfo['qty'] = $this->parseStr($this->patternNumber, $this->jobWelfare);
        $this->jobInfo['category'] = $this->parseJobCategory();
        $this->jobInfo['descrip'] = $this->parseStr($this->patternJobDes, $this->jobHtml, ['trim']);
        $this->jobInfo['welfare'] = $this->parseStr($this->patternWel, $this->jobWelfare, ['trim']);
        $this->jobInfo['age'] = '';
        $this->jobInfo['languge'] = $this->parseStr($this->patternLanguge, $this->jobWelfare);
        $this->jobInfo['jobUrl'] = $this->jobUrl;
        $this->jobInfo['stage'] = $this->parseStr($this->patternCompanyDesc, $this->jobHtml, ['strip_tags', 'trim']);
        $this->jobInfo['originurl'] = $this->parseStr($this->patternCompanyUrl, $this->jobHead);
        $this->jobInfo['originid'] = $this->originalId;
        return $this->jobInfo;
    }
    
    /**
     * 解析职位头部信息
     * @author 刘旭超 <liuxuchao126@126.com>
     * @return string
     */
    private function parseJobHead()
    {
        if ( preg_match($this->patternJobHead, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析职位名称
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-08 09:20
     * @return string
     */
    private function parseJobName()
    {
        if ( preg_match($this->patternJobName, $this->jobHead, $match) ) {
            $jobName = $match[1];
            return strip_tags($jobName);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司ID
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-08 09:48
     * @return string
     */
    private function parseCompanyId()
    {
        if ( preg_match($this->patternCompanyId, $this->jobHtml, $match) ) {
            $companyName = strip_tags($match[1]);
            return $companyName;
        } else {
            return '';
        }
    }
    
    /**
     * 解析职位类别
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-06 17:49
     * @return string
     */
    private function parseJobCategory()
    {
        if ( preg_match($this->patternCompanyInfo, $this->jobHtml, $match) ) {
            return trim($match[1]);
        } else {
            return '';
        }
    }
}
