<?php
namespace Common\Library\Util\Parse\Job;

use Common\Library\Util\Parse\Job\ParseJob;

/**
 * Description of ParseLiepin
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2017-1-18 18:12:30
 */
class ParseLiepin extends ParseJob
{
    private $jobHead = '';
    
    private $patternJobHead = '/<div\s+?class\="job\-item">([\s\S]+?)<div\s+?class\="job\-item\s+?main\-message">/i';
    private $patternWel = '/<div\s*?class="tag-list">([\s\S]+?)<\/div>/i';
    private $patternJobName = '/<div\s*?class="title-info">[\s\S]+?<h1\s*?title=".+?">(.+?)<\/h1>/i';
    private $patternCompanyId = '/<div\s+?class="title-info">[\s\S]+?<h3>\s*?<a\s+?href="https:\/\/www\.liepin\.com\/company\/(.+?)\/".+?>.+?<\/a>\s*?<\/h3>/i';
    private $patternCompanyName = '/<div\s+?class="title-info">[\s\S]+?<h3>\s*?<a.+?>(.+?)<\/a>\s*?<\/h3>/i';
    private $patternSalary = '/<p\s+?class=\"job-item-title\">(\d+?)-(\d+?)万/i';
    private $patternWorkplace = '/<p\s+?class="basic-infor">[\s\S]+?<a.+?>(.+?)<\/a>/i';
    private $patternPublishDate = '/<span>\s*?<i\s+?class="icons24\s+?icons24-time"><\/i>(.+?)\s*?<\/span>/i';
    private $patternJobDes = '/<h3\s+?class="job-title">职位描述：<\/h3>\s*?<div\s+?class="content content-word">([\s\S]+?)<\/div>/i';
    private $patternOriginalId = '/<li><a\s+?href="https:\/\/www\.liepin\.com\/job\/(.+?)\.shtml">.+?<\/a><\/li>/i';
    private $patternOriginUrl = '/<li><a\s+?href="(https:\/\/www\.liepin\.com\/job\/.+?\.shtml)">.+?<\/a><\/li>/i';
    private $patternCompanyDesc = '/<div\s+class=\"job-item main-message noborder\"\s+.*?>[\s\S]+?<h3\s+class=\"job-title\">企业介绍：<\/h3>[\s\S]+?(.*?)[\s\S]+?<\/div>/i';

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
     * 解析职位信息
     */
    public function parse()
    {
        //职位头部信息，包括职位名称，公司名称，工作地点，薪资待遇。
        $this->jobHead = $this->parseJobHead();
        if ( empty($this->jobHead) ) {
            return [];
        }
        
        $this->jobInfo['name'] = $this->parseStr($this->patternJobName, $this->jobHtml, ['trim'], 1);
        if ( empty($this->jobInfo['name']) ) {
            return [];
        }
        $this->jobInfo['companyid'] = $this->parseStr($this->patternCompanyId, $this->jobHtml, ['trim'], 1);
        $this->jobInfo['companyname'] = $this->parseStr($this->patternCompanyName, $this->jobHtml);
        $this->jobInfo['salary'] = $this->parseSalay();
        $this->jobInfo['workplace'] = $this->parseStr($this->patternWorkplace, $this->jobHead);
        $this->jobInfo['publishdate'] = $this->parseStr($this->patternPublishDate, $this->jobHead);
        $this->jobInfo['workproperty'] = '';
        $this->jobInfo['experience'] = $this->parseExperience();
        $this->jobInfo['education'] = $this->parseEducation();
//        $this->jobInfo['qty'] = $this->parseStr($this->patternNumber, $this->jobWelfare);
//        $this->jobInfo['category'] = $this->parseJobCategory();
        $this->jobInfo['descrip'] = $this->parseStr($this->patternJobDes, $this->jobHtml, ['trim']);
        $this->jobInfo['welfare'] = $this->parseStr($this->patternWel, $this->jobHead, ['trim']);
        $this->jobInfo['age'] = $this->parseAge();
        $this->jobInfo['languge'] = $this->parseLanguge();
        $this->jobInfo['jobUrl'] = $this->jobUrl;
        $this->jobInfo['stage'] = $this->parseStr($this->patternCompanyDesc, $this->jobHtml, ['strip_tags', 'trim']);
        $this->jobInfo['originurl'] = $this->parseStr($this->patternOriginUrl, $this->jobHtml);
        $this->jobInfo['originid'] = $this->parseStr($this->patternOriginalId, $this->jobHtml);
        return $this->jobInfo;
    }
    
    /**
     * 解析职位要求
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 22:38
     * @return string
     */
    private function parseJobRrequirements()
    {
        if ( preg_match('/<div\s+?class="job-qualifications">([\s\S]+?)<\/div>/i', $this->jobHead, $requirements) ) {
            return $requirements[1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析年龄
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 23:02
     * @return string
     */
    private function parseAge()
    {
        $jobRequirements = trim( $this->parseJobRrequirements() );
        if ( !$jobRequirements ) {
            return '';
        }
        
        if ( preg_match_all('/<span>(.+?)<\/span>/i', $jobRequirements, $match) ) {
            return $match[1][3];
        } else {
            return '';
        }
    }
    
    /**
     * 解析语言要求
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 22:55
     * @return string
     */
    private function parseLanguge()
    {
        $jobRequirements = trim( $this->parseJobRrequirements() );
        if ( !$jobRequirements ) {
            return '';
        }
        
        if ( preg_match_all('/<span>(.+?)<\/span>/i', $jobRequirements, $match) ) {
            return $match[1][2];
        } else {
            return '';
        }
    }
    
    /**
     * 解析学历要求
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 22:55
     * @return ''
     */
    private function parseEducation()
    {
        $jobRequirements = trim( $this->parseJobRrequirements() );
        if ( !$jobRequirements ) {
            return '';
        }
        
        if ( preg_match_all('/<span>(.+?)<\/span>/i', $jobRequirements, $match) ) {
            return $match[1][0];
        } else {
            return '';
        }
    }
    
    /**
     * 解析工作经验
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 22:34
     * @return string
     */
    private function parseExperience()
    {
        $jobRequirements = trim( $this->parseJobRrequirements() );
        if ( !$jobRequirements ) {
            return '';
        }
        
        if ( preg_match_all('/<span>(.+?)<\/span>/i', $jobRequirements, $match) ) {
            return $match[1][1];
        } else {
            return '';
        }
    }
    
    /**
     * 解析职位详情页头部信息
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-18 18:22
     * @return null
     */
    private function parseJobHead()
    {
        if ( preg_match($this->patternJobHead, $this->jobHtml, $match) ) {
            return $match[1];
        } else {
            return '';
        }
    }
    /*
     * 解析薪资
     * @author 刘旭超 zhengziqiang@liuxuchaota.com
     * @data 2017年3月22日19:23:52
     * @return null 
     */
    public function parseSalay(){

        preg_match($this->patternSalary, $this->jobHtml,$match);
        $salayRangeData = array_unique(array_slice($match,1));
        if ( 2 == count($salayRangeData)) {
            $salayFrom = intval((( current($salayRangeData)*10000 )/12)/1000);
            $salayTo = intval((( end($salayRangeData)*10000 )/12)/1000);
            $salay = $salayFrom.'-'.$salayTo.'K/月' ;
            return $salay;
        }else if( 1 >= count($salayRangeData) || !empty(current($salayRangeData))){
            $salayRangeData = intval((( current($salayRangeData)*10000 )/12)/1000);
            return $salayRangeData.'以上';
        }else if( 0 >= count($salayRangeData) || empty(current($salayRangeData)) || current($salayRangeData)==0){
            return '面议' ;
        }
        foreach ($salayRangeData as $key => $value) {
            if ( 0 == $key%2) {
                $salayRangeData = intval(((( $salayRangeData*10000 )/12)/1000));
                if ( 0 < $salayRangeData){
                    $salay[] = intval($salayRangeData);
                }else{
                    $salay[] = ceil($salayRangeData);
                }
            }else{
                $salay[] = ceil($salayRangeData);
            }
        }
        return implode('-', $salay).'K/月' ;
        
    }
    
}
