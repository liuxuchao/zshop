<?php
namespace Common\Library\Util\Parse\Job;

use Common\Library\Util\Parse\Job\ParseJob;

/**
 * 解析智联招聘职位信息
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-6 15:29:53
 */
class ParseTongcheng extends ParseJob
{
    private $patternJobName = '/<span\s+id=\"d_title\"\s+class=\"d_title\">(.*?)<\/span>/i';
    private $patternCompanyId = '/<script>[\s\S]+?var\s+_companyUserId\s+\=\s+(\d+).*?[\s\S]+?<\/script>/i';
    private $patternCompanyIdBackup = '';
    private $patternCompanyName = '/<a\s+href=\".*?\"\s+tongji_tag=\"m_detail_job_full_qyml\">(.*?)<\/a>/i';
    private $patternJobReq = '/<div\s+?class="terminalpage-left">\s*?<ul\s+?class="terminal-ul\s+?clearfix">([\s\S]+?)<\/ul>/i';
    private $patternSalary = '/<div\s+class=\"price\">[\s\S]+?(.*?)[\s\S]+?<\/div>/i';
    private $patternWorkPlace = '/<a\s+href=\"http\:\/\/m\.58\.com\/.*?\">(.*?)<\/a>/i';
    private $patternPublishDate = '/<div\s+class=\"pub_date\"><span>发布：<\/span><span>(.*?)<\/span><\/div>/i';
    private $patternExperience = '/<li\s+class=\"req\">[\s\S]+?<span\s+class=\"attrValue\">[\s\S]+?(.*?)[\s\S]+?<\/span>[\s\S]+?<\/li>/i';
    private $patternJobCategory = '/<span\s+class=\"attrValue\"><a\s+href=\"http\:\/\/m\.58\.com\/zz\/.*?\"\s+target=\"_blank\">(.*?)<\/a>[\s\S]+?<\/span>/i';
    private $patternJobDes = '/<div\s+class=\"dis_con\"+.*?>[\s\S]+?(.*?)[\s\S]+?<\/div>/i';
    private $patternCompanyDesc = '/<div\s+class=\"company_con\s+btOnepx\">[\s\S]+?<p>(.*?)<\/p>[\s\S]+?<\/div>/i';
    private $patternWelfare = '/<div\s+class=\"fulivalue attrValue\">[\s\S]+?(.*?)[\s\S]+?<\/div>/i';
    private $patternCompanyUrl = '/<h2\s+class=\"c_tit\">[\s\S]+?<a\s+href=\"(.*?)\"\s+.*?>.*?<\/a>[\s\S]+?<\/h2>/i';
    
    private $jobRequirements = ''; //职位要求
    
    public function __construct($channelType, $jobHtml, $jobUrl, $originalId)
    {
        $this->channelType = $channelType;
        $this->jobHtml = $jobHtml;
        $this->jobUrl = $jobUrl;
        $this->originalId = $originalId;
    }
        
    /**
     * 解析职位
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 09:10
     * @return array
     */
    public function parse()
    {
        $this->jobInfo['name'] = $this->parseJobName();
        if ( empty($this->jobInfo['name']) ) {
            return [];
        }
        $this->jobInfo['companyid'] = $this->parseCompanyId();
        $this->jobInfo['companyname'] = $this->parseCompanyName();
        $this->jobInfo['salary'] = $this->parseSalary();
        $this->jobInfo['workplace'] = $this->parseWorkplace();
        $this->jobInfo['publishdate'] = $this->parsePublishDate();
        $this->jobInfo['experience'] = $this->parseExperience();
        $this->jobInfo['education'] = $this->parseEducation();
        $this->jobInfo['qty'] = $this->parseNumber();
        $this->jobInfo['category'] = $this->parseJobCategory();
        $this->jobInfo['descrip'] = $this->parseJobDesc();
        $this->jobInfo['welfare']  = $this->parseWelfare();
        $this->jobInfo['age'] = '';
        $this->jobInfo['languge'] = '';
        $this->jobInfo['jobUrl'] = $this->jobUrl;
        $this->jobInfo['stage'] = $this->parseCompanyDesc();
        $this->jobInfo['department'] = '';
        $this->jobInfo['professional'] = '';
        $this->jobInfo['reportto'] = '';
        $this->jobInfo['member'] = '';
        $this->jobInfo['originurl'] = $this->parseCompanyUrl();
        $this->jobInfo['originid'] = $this->originalId;
        return $this->jobInfo;
    }
    
    /**
     * 解析公司ID
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 16:50
     * @return string
     */
    private function parseCompanyId()
    {
        if ( preg_match($this->patternCompanyId, $this->jobHtml, $match) ) {
           
             return (int)$match[1];
        }
    }
    
    /**
     * 解析职位名称
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 16:02
     * @return string
     */
    private function parseJobName()
    {
        if ( preg_match($this->patternJobName, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司名称
     * @author 刘旭超 <liuxuchao126@126.com>
     * @return date 2016-09-06 16:21
     * @return string
     */
    private function parseCompanyName()
    {
        if ( preg_match($this->patternCompanyName, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析职位要求信息
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 17:14
     * @return string
     */
    private function parseJobRequirements()
    {
        if ( preg_match($this->patternJobReq, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 匹配薪资待遇
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 17:14
     * @return string
     */
    private function parseSalary()
    {
        //解析薪资
        if ( preg_match($this->patternSalary, $this->jobHtml, $match) ) {
            return trim(strip_tags($match[0]));
        } else {
            return '';
        }
    }
    
    /**
     * 解析工作地
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2-16-09-06 17:14
     * @return string
     */
    private function parseWorkplace()
    {
        //解析工作地点
        if ( preg_match_all($this->patternWorkPlace, $this->jobHtml, $match) ) {
            return implode('-',array($match[1][1],$match[1][2]));
        } else {
            return '';
        }
    }
    
    /**
     * 解析发布日志
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 17:40
     * @return string
     */
    private function parsePublishDate()
    {
        //解析发布时间
        if ( preg_match($this->patternPublishDate, $this->jobHtml, $match) ) {
            return strtotime($match[1]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析工作经验要求
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-06 17:49
     * @return string
     */
    private function parseExperience()
    {
        //解析工作经验要求
        if ( preg_match($this->patternExperience, $this->jobHtml, $match) ) {
            $publishDate = preg_replace(['/要求：/i','/\s+/i'],' ',strip_tags($match[0]));
            return end(explode('/', $publishDate));
        } else {
            return '';
        }
    }
    
    /**
     * 解析学历要求
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-06 17:49
     * @return string
     */
    private function parseEducation()
    {
        //解析学历邀请
        if ( preg_match($this->patternExperience, $this->jobHtml, $match) ) {
            $publishDate = explode('/', preg_replace(['/要求：/i','/\s+/i'],' ',strip_tags($match[0])));
            if(strstr($publishDate[1],'不限')){
                return '不限';
            }
            return $publishDate[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析招聘人数
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-06 17:49
     * @return string
     */
    private function parseNumber()
    {
        //解析学历邀请
        if ( preg_match($this->patternExperience, $this->jobHtml, $match) ) {
            $publishDate = explode('/', preg_replace(['/要求：/i','/\s+/i'],' ',strip_tags($match[0])));
            return $publishDate[0];
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
        //解析职位类别
        if ( preg_match($this->patternJobCategory, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析工作描述
     * @author 刘旭超 <liuxuchao126@126.com>
     * @return string
     */
    private function parseJobDesc()
    {
        if ( preg_match($this->patternJobDes, $this->jobHtml, $match) ) {
            return $this->replaceSpace($match[0]);
        } else {
            return '';
        }
        
    }
    
    /**
     * 解析福利待遇
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-07 10:44
     * @return string
     */
    private function parseWelfare()
    {
         preg_match($this->patternWelfare, $this->jobHtml, $match);
        if ( preg_match($this->patternWelfare, $this->jobHtml, $match) ) {
            return preg_replace('/\s+/', '', $match[0]);
        } else {
            return '';
        }
    }
    
    /**
     * 解析公司简介
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-07 11:27
     * @return string
     */
    private function parseCompanyDesc()
    {
        if ( preg_match($this->patternCompanyDesc, $this->jobHtml, $match) ) {
            $companyDesc = $match[1];
            $companyDesc = $this->replaceSpace($companyDesc);
            return trim($companyDesc);
        } else {
            return '';
        }
    }
    
    /**
     * 过滤空行，无用的空白
     * @param string $str
     * @return string
     */
    private function replaceSpace($str)
    {
        $pattern = ['/<\!\-\-.+?\-\->/i', '/^\s*?(?:\r\n|\n|\r)/mi', '/\r\n|\n|\r/i', '/>\s+?</i'];
        $replacement = ['', '', '', '><'];
        $str = preg_replace($pattern, $replacement, $str);
        return trim($str);
    }
    
    /**
     * 解析公司网址
     * @author 刘旭超 <liuxuchao126@126.com>
     * @2016-09-07 11:56
     * @return string
     */
    private function parseCompanyUrl()
    {
        if ( preg_match($this->patternCompanyUrl, $this->jobHtml, $match) ) {
            return $match[1];
        }
    }
    
}
