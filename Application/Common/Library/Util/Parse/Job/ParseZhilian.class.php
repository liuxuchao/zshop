<?php
namespace Common\Library\Util\Parse\Job;

use Common\Library\Util\Parse\Job\ParseJob;

/**
 * 解析智联招聘职位信息
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-9-6 15:29:53
 */
class ParseZhilian extends ParseJob
{
    private $patternJobName = '/<div\s+?class="inner-left\s+?fl">\s*?<h1>(.+?)<\/h1>/i';
    private $patternCompanyId = '/<div\s+?class="inner-left\s+?fl">\s*?<h1>.+?<\/h1>\s*?<h2><a\s+?onclick="recordOutboundLink\(.+?\);"\s+?href="http:\/\/special\.zhaopin\.com\/pagepublish\/(.+?)\/index\.html".+?>/i';
    private $patternCompanyIdBackup = '';
    private $patternCompanyName = '/<div\s+?class="inner-left\s+?fl">\s*?<h1>.+?<\/h1>\s*?<h2><a\s+?onclick="recordOutboundLink\(.+?\);".+?>(.+?)<img.+?><\/a><\/h2>/i';
    private $patternJobReq = '/<div\s+?class="terminalpage-left">\s*?<ul\s+?class="terminal-ul\s+?clearfix">([\s\S]+?)<\/ul>/i';
    private $patternSalary = '/<\s*li\s*><\s*span\s*>\s*职位月薪：\s*<\s*\/span\s*>\s*<\s*strong\s*>(.*?)<\s*\/\s*strong\s*>\s*<\s*\/li\s*>/i';
    private $patternWorkPlace = '/<li><span>工作地点：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternPublishDate = '/<li><span>发布日期：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternJobNature = '/<li><span>工作性质：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternExperience = '/<li><span>工作经验：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternEducation = '/<li><span>最低学历：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternNumber = '/<li><span>招聘人数：<\/span><strong>(.+?)<\/strong><\/li>/i';
    private $patternJobCategory = '/<li><span>职位类别：<\/span><strong>(.+?)<\/strong><\/li>/i';
//    private $patternJobDes = '/<div\s+?class="terminalpage-main\s+?clearfix">([\s\S]+?)<\/div>/i';
    private $patternJobDes = '/<div\s+?class\="tab-inner-cont">([\s\S]+?)<\/div>/i';
    private $patternCompanyDesc = '/<div\s+?class="terminalpage-main\s+?clearfix">\s*?<ul.+?>[\s\S]+?<\/ul>\s*?<p.+?>.+?<\/p>\s*?<div\s+?class="tab-cont-box">\s*?<div\s+?class="tab-inner-cont">[\s\S]+?<\/div>\s*?<div\s+?class="tab-inner-cont".+?>\s*<h5>.+<\/h5>([\s\S]+?)<\/div>\s*?<\/div>\s*<\/div>/i';
    private $patternWelfare = '/<div.+?class="welfare-tab-box">(.+?)<\/div>/i';
    private $patternCompanyUrl = '/<div\s+?class="inner-left\s+?fl">\s*?<h1>.+?<\/h1>\s*?<h2><a\s+?onclick="recordOutboundLink\(.+?\);"\s+?href="(.+?)".+?>.+?(?:<img.+?>)?<\/a><\/h2>/i';
    private $patternCompanyUrl_0 = '/<span><a.+?href=\"(.*?)\".+?target=\"_blank\".+?rel=\"nofollow\">(.*?)<\/a><\/span>/i';
    
    private $jobRequirements = ''; //职位要求
    
    public function __construct($channelType, $jobHtml, $jobUrl, $originalId)
    {
        $this->channelType = $channelType;
        $this->jobHtml = $jobHtml;
        $this->jobUrl = $jobUrl;
        $this->originalId = $originalId;
    }
    
    /**
     * 格式化智联职位ID
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-09-07 11:37
     * @param string $jobId 职位ID
     * @return string
     */
    public static function formatZhilianJobId( $jobId )
    {
        $id = str_replace(['CC', 'J90'], ['', ''], $jobId); //{CC}211036813{J90}250222{000}
        $id = substr_replace($id, '', -3, 3);
        return $id;
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
             return 'CC' . $match[1];
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析薪资
        if ( preg_match($this->patternSalary, $this->jobRequirements, $match) ) {
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析工作地点
        if ( preg_match($this->patternWorkPlace, $this->jobHtml, $match) ) {
            $workplace = strip_tags($match[1]);
            return $workplace;
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析发布时间
        if ( preg_match($this->patternPublishDate, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return $publishDate;
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析工作性质
        if ( preg_match($this->patternJobNature, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return $publishDate;
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析工作经验要求
        if ( preg_match($this->patternExperience, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return $publishDate;
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析学历邀请
        if ( preg_match($this->patternEducation, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return $publishDate;
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析学历邀请
        if ( preg_match($this->patternNumber, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return trim($publishDate);
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
        //解析出职位要求内容
        if ( empty($this->jobRequirements) ) {
            $this->jobRequirements = $this->parseJobRequirements();
            if ( empty($this->jobRequirements) ) {
                return '';
            }
        }
        
        //解析职位类别
        if ( preg_match($this->patternJobCategory, $this->jobRequirements, $match) ) {
            $publishDate =  strip_tags( $match[1] );
            return trim($publishDate);
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
            $filterPattern = [
                '/<b>工作地址：<\/b>\s*?<h2>[\s\S]+?<\/h2>/i',
                '/<p>\s*?<button\s+?id="applyVacButton1".+?><\/button>\s*?<\/p>/i'
            ];
            $jobDesc = preg_replace($filterPattern, ['',''], $match[1]);
            return $jobDesc;
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
            return trim($match[1]);
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

        if ( preg_match($this->patternCompanyUrl_0, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    
}
