<?php
namespace Common\Library\Util\Parse\Job;

use Common\Library\Util\Parse\Job\ParseJob;

/**
 * 解析智联招聘职位信息
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-6 15:29:53
 */
class ParseGanji extends ParseJob
{
    private $patternJobName = '/<h1\s+class=\"title\">(.*?)<\/h1>/i';
    private $patternCompanyId = '/<a\s+href=\".*?gongsi_(\d+).*?\">/i';
    private $patternCompanyName = '/<a\s+href=\".*?gongsi_\d+.*?\">(.*?)<\/a>/i';
    private $patternJobReq = '/<div\s+?class="terminalpage-left">\s*?<ul\s+?class="terminal-ul\s+?clearfix">([\s\S]+?)<\/ul>/i';
    private $patternSalary = '/<div\s+class=\"fl\s+fc-red\">(.*?)<\/div>/i';
    private $patternWorkPlace = '/<meta\s+name=\"location\"\s+content=\"province=(.*?)\;city=(.*?)\;coord=.*?\">/i';
    private $patternPublishDate = '/<span\s+class=\"fc8d\s+f12\">(.*?)<\/span>/i';
    private $patternJobNature = '';
    private $patternExperience = '/<tr>[\s\S]+?<th>要求<\/th>[\s\S]+?<td>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)\s+<\/td>[\s\S]+?<\/tr>/i';
    private $patternEducation = '/<tr>[\s\S]+?<th>要求<\/th>[\s\S]+?<td>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)<\/td>[\s\S]+?<\/tr>/i';
    private $patternNumber = '/<tr>[\s\S]+?<th>要求<\/th>[\s\S]+?<td>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)<span\s+class=\"s\"><\/span>[\s\S]+?(.*?)<\/td>[\s\S]+?<\/tr>/i';
    private $patternJobCategory = '/<tr>[\s\S]+?<th>职位<\/th><td>(.*?)<\/td>[\s\S]+?<\/tr>/i';
    private $patternJobDes = '/<p\s+class=\"comm-info\s+limitLine10\">(.*?)<\/p>/i';
    private $patternCompanyDesc = '/<td.*?colspan=\"\d\">[\s\S]+?<span.*?class=\"comp-intro\".*?>介.*?绍<\/span>[\s\S]+?(.*?)<\/td>/i';
    private $patternWelfare = '/<div\s+class=\"tags-box\">[\s\S]+?(.*?)<\/div>/i';
    private $patternCompanyUrl = '/<div\s+class=\"com-name\"><a\s+href="(.*?)">.*?<\/a>[\s\S]+?<\/div>/i';
    private $patternJobUrl = '/<link\s+rel=\"canonical\"\s+href=\"(.*?)\"\/>/i';
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
        $this->jobInfo['workproperty'] = $this->parseJobNature();
        $this->jobInfo['experience'] = $this->parseExperience();
        $this->jobInfo['education'] = $this->parseEducation();
        $this->jobInfo['qty'] = $this->parseNumber();
        $this->jobInfo['category'] = $this->parseJobCategory();
        $this->jobInfo['descrip'] = $this->parseJobDesc();
        $this->jobInfo['welfare']  = $this->parseWelfare();
        $this->jobInfo['age'] = '';
        $this->jobInfo['languge'] = '';
        $this->jobInfo['jobUrl'] = $this->parseJobUrl();
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
             return  $match[1];
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
            return trim($match[1]);
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
            return trim(str_replace('&nbsp;', '', strip_tags($match[1])));
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
        if ( preg_match($this->patternWorkPlace, $this->jobHtml, $match) ) {
            return trim(end($match));
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
    {        //解析发布时间
        if ( preg_match($this->patternPublishDate, $this->jobHtml, $match) ) {
            if (strtotime(date('Y').'-'.$match[1])) {
                $time = strtotime(date('Y').'-'.$match[1]);
            }else{
                $time = strtotime($match[1]);
            }
            return $time;
        } else {
            return '';
        }
    }
    
    /**
     * 解析工作性质，全职、兼职
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-06 17:40
     * @return string
     */
    private function parseJobNature()
    {
        //解析工作性质
        if ( preg_match($this->patternJobNature, $this->jobHtml, $match) ) {
            return $match[1];
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
            return trim(end($match));
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
        if ( preg_match($this->patternEducation, $this->jobHtml, $match) ) {
            return trim($match[2]);
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
        if ( preg_match($this->patternNumber, $this->jobHtml, $match) ) {
            return trim($match[1]);
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
            return trim($match[1]);
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
            return str_replace('岗位职责:<br>', '', $match[1]);
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
        if ( preg_match($this->patternWelfare, $this->jobHtml, $match) ) {
            return $this->replaceSpace($match[1]);
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
            $introduce = preg_replace(['/<span.*?class=\"comp-intro\".*?>介.*?绍<\/span>/i','/\s|\n/i'], '', $match[0]);
            return $this->replaceSpace($introduce);
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
            if(false == strstr($match[1],'http://3g.ganji.com')){
                $url = 'http://3g.ganji.com'.$match[1] ;
            }else{
                $url = $match[1] ;
            }
            return $url;
        }else{
            return '';
        }
        
    }
    
    public function parseJobUrl()
    {
        if(preg_match($this->patternJobUrl, $this->jobHtml,$match)){
            return $match[1];
        }else{
            return '';
        }
        
    }
    
}
