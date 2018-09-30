<?php
namespace Common\Library\Util\Formatting;

/**
 * 格式化 简历信息
 *
 */
class FormattingResume
{

    
    /**
     *  格式化薪资 为 K
     * @param type $salary
     * @param type $salaryFrom
     * @param type $salaryTo
     * @return string
     */
    public static function formatSalaryToK($salary, $salaryFrom, $salaryTo)
    {
        if (1000 <= $salaryFrom && 1000 <= $salaryTo) {
            $strSalary = floor($salaryFrom / 1000) . '-' . ceil($salaryTo / 1000) . 'K/月';
        } elseif (strpos($salary, '万') && intval($salaryFrom) > 0 && intval($salaryTo) > 0) {
            $strSalary = floor(($salaryFrom * 10) / 12) . '-' . ceil(($salaryTo * 10) / 12) . 'K/月';
        } elseif ((intval($salaryFrom) > 0 || intval($salaryTo) > 0) && strpos($salary, '万')) {
            $strSalary = floor((current(explode('-', $salary)) * 10) / 12) . '-' . ceil((end(explode('-', $salary)) * 10) / 12) . 'K/月';
        } else {
            $strSalary = '';
        }
        return $strSalary;
    }

    /**
     * 格式化 证书
     * @param type $certification
     * @return type
     */
    public static function formatCertification($certification)
    {
        foreach ($certification as $key => &$val) {
            $val['cer_name'] = html_entity_decode($val['cer_name']);
            if (is_int($val['issued'])) {
                $val['issued'] = date("Y.m", $val['issued']);
            }
            if (isset($val['cer_name']) && empty($val['cer_name']))
                continue;
            $val['issued'] = str_replace("/", ".", $val['issued']);
            if (strstr($val['issued'], "."))
                continue;
        }
        return $certification;
    }

    /**
     * 格式化 教育经历
     * @param type $degree
     * @return array
     */
    public static function formatEducation($degree)
    {
        $educations = [];
        foreach ($degree as $key => $val) {
            if (empty($value['school']) && isset($value['school'])) {
                continue;
            }
            $tmp['degree'] = $val['backgd_cnt'];
            $tmp['school'] = html_entity_decode($val['school']);
            $tmp['speciality'] = html_entity_decode($val['speciality']);
            $tmp['description'] = htmlspecialchars_decode(html_entity_decode($val['description']));
            if (intval($val['stime']) == 0 || intval($val['etime']) == 0) {
                $val['time_cnt'] = str_replace('--', '-', $val['time_cnt']);
                $timesArray = explode('-', $val['time_cnt']);
                $tmp['stime'] = str_replace('/', '.', $timesArray[0]);
                $tmp['etime'] = str_replace('/', '.', $timesArray[1]);
            } else {
                $tmp['stime'] = date("Y.m", $val['stime']);
                $tmp['etime'] = date("Y.m", $val['etime']);
            }
            array_push($educations, $tmp);
        }
        return $educations;
    }

    /**
     * 格式化 求职意向
     * @param type $jobIntension
     * @return type
     */
    public static function formatJobIntension($jobIntension)
    {
        $intension['state'] = $jobIntension['state_cnt'];
        $intension['Job_nature'] = $jobIntension['job_nature_cnt'];
        $intension['expected_position'] = trim(implode($jobIntension['job_cnt'], ','), ',');
        $intension['expected_industry'] = trim(implode($jobIntension['trade_cnt'], ','), ',');
        $intension['expected_work_place'] = trim(implode($jobIntension['city_cnt'], ','), ',');
        return $intension;
    }

    /**
     * 格式化语言
     * @param type $language
     * @return array
     */
    public static function formatLanguage($language)
    {
        if (empty($language))
            return [];
        $data = [];
        foreach ($language as $k => $val) {
            $languageTmp['language'] = $val['lang_cnt'];
            $languageTmp['verbal'] = $val['verbal_cnt'];
            $languageTmp['literacy'] = $val['literacy_cnt'];
            array_push($data, $languageTmp);
        }
        return $data;
    }

    /**
     * 格式化 技能
     * @param type $skills
     * @return array
     */
    public static function formatSkills($skills)
    {
        if (empty($skills)) {
            return [];
        }
        $data = [];
        foreach ($skills as $k => $val) {
            if (empty($val['level_cnt']))
                continue;
            $skillTmp['skill'] = $val['skill'];
            $skillTmp['level'] = $val['level_cnt'];
            $skillTmp['how_long'] = $val['how_long_month'];
            array_push($data, $skillTmp);
        }
        return $data;
    }

    /**
     * 格式化工作经历
     * @param type $work
     * @return array
     */
    public static function formatWorkexperience($work)
    {
        $data = [];
        foreach ($work as $k => $val) {
            if (empty($val['job'])) {
                continue;
            }
            $val['work_time'] =  self::formatWrokLong($val['stime'], $val['etime']);;
            if ($val['stime'] > 0 && $val['etime'] == 0){
                $val['etime'] = $_SERVER['REQUEST_TIME'];
            }else{
                $val['stime'] = date("Y.m", $val['stime']);
                $val['etime'] = date("Y.m", $val['etime']);
            }
            $val['immediate_subordinate'] = $val['im_subordinate'];
            $val['performance'] = $val['achievements'];
            $val['job'] = html_entity_decode($val['job']);
            $val['department'] = html_entity_decode($val['department']);
            $val['achievements'] = html_entity_decode($val['achievements']);
            $val['job_description'] = htmlspecialchars_decode(html_entity_decode($val['job_description']));
            unset($val['location']);
            unset($val['company_type']);
            unset($val['company_type_cnt']);
            unset($val['time_cnt']);
            unset($val['company_disc']);
            $val['trade'] = $val['trade_cnt'];
            unset($val['trade_cnt']);
            unset($val['achievements']);
            unset($val['position_type']);
            unset($val['im_subordinate']);
            unset($val['salary_cnt']);
            unset($val['duty']);
            unset($val['achievements']);
            array_push($data, $val);
        }
        return $data;
    }

    /**
     * 格式化 工作时间
     * @param type $stime
     * @param type $eTime
     * @return string
     */
    public static function formatWrokLong($stime, $eTime)
    {
        if ($stime == 0 ) {
            return '';
        }
        //兼容至今 2017年5月16日11:25:46 刘旭超
        if ($eTime == 0) {
            $eTime = time();
        }
        $mouths = ceil(($eTime - $stime) / 2592000);
        if ($mouths > 12) {
            $years = intval($mouths / 12);
            $mouth = $mouths % 12;
            if ($mouth == 0) {
                return $years . '年';
            } else {
                return $years . '年' . $mouth . '个月';
            }
        } else {
            if ($mouths == 0) {
                return '1个月内';
            }
            return $mouths . '个月';
        }
    }
    
    /**
     * 格式化培训经历
     * @param type $training
     * @return array
     */
    public static function formatTraining($training)
    {
        $data = [];
        foreach ($training as $k => $val) {
            if (empty($val['agency']))
                continue;
            $val['stime'] = date("Y.d", $val['stime']);
            $val['etime'] = date("Y.d", $val['etime']);
            unset($val['time_cnt']);
            array_push($data, $val);
        }
        return $data;
    }

    /**
     * 格式化教育经历
     * @param type $project
     * @return array
     */
    public static function formatProject($project)
    {
        if (empty($project))
            return [];
        $projectData = [];
        foreach ($project as $val) {
            if (empty($val['project_name']))
                continue;
            $tmp['description'] = $val['description'];
            $tmp['duty'] = $val['duty'];
            $tmp['entry_name'] = html_entity_decode($val['project_name']);
            if (intval($val['stime']) > 0 && intval($val['etime']) > 0) {
                $longTimeStr = self::formatWrokLong($val['stime'], $val['etime']);
            } elseif (intval($val['stime']) > 0 && (intval($val['etime']) == 0)) {
                $longTimeStr = self::formatWrokLong($val['stime'], $_SERVER['REQUEST_TIME']);
            } else {
                $longTimeStr = '';
            }
            $tmp['work_time'] = str_replace('/', '.', $val['time_cnt']) . '(' . $longTimeStr . ')';
            array_push($projectData, $tmp);
        }
        return $projectData;
    }

    /** 根据教育经历获取 最高学历和专业
     * @param $education 教育经历
     * @return array
     */
    public static function getTopSchoolName($education)
    {
        if (empty($education))
            return ['school' => '', 'speciality' => ''];
        $lastEtime = $education[0]['etime'];
        foreach ($education as $key => $val) {
            if ($val['etime'] <= $lastEtime) {
                return ['school' => $val['school'], 'speciality' => $val['speciality']];
            }
        }
        return ['school' => $education[0]['school'], 'speciality' => $education[0]['speciality']];
    }

    /**
     * 根据 最后工作的离职时间 判断工作状态
     * 当文本为 目前正在找工作 返回2
     * 其他情况 使用原有的数据中的工作状态
     * @param $status 当中工作状态
     * @param $statusCn 当中工作状态文本
     * @param $recentJob  最近工作的数据数组
     */
    public static function formatWorkStatus($status,$statusCn, $recentJob=null)
    {
        if($statusCn =='目前正在找工作'&& intval($recentJob['etime'])==0) {
            return 2;
        }else{
            return $status;
        }
    }
    
     /**
     * 根据年龄性别身材默认图片
     * @author liuxuchao<liuxuhcao@liuxuchaota.com>
     * @DateTime 2017-01-06T01:08:05+0800
     * @param    [type]                   $age [description]
     * @param    [type]                   $sex [description]
     * @return   [type]                        [description]
     */
    public static function buildDefaultIcon($age, $sex, $resumeId)
    {
        //简历id取模
        $num = intval(substr($resumeId, -1)) % 3 + 1;
        if ($sex == 1 && $age <= 30) {
            return "/Home/default-icon/m" . $num . ".png";
        } elseif ($sex == 1 && $age > 30) {
            return "/Home/default-icon/m" . $num . ".png";
        } elseif ($sex == 2 && $age <= 30) {
            return "/Home/default-icon/w" . $num . ".png";
        } elseif ($sex == 2 && $age > 30) {
            return "/Home/default-icon/w" . $num . ".png";
        }
    }
}
