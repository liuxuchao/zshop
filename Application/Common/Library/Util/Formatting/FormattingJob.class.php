<?php
namespace Common\Library\Util\Formatting;

/**
 * 格式化 职位信息
 *
 */
class FormattingJob
{

    /**
     * 学历字典
     * @var array
     */
    private static $degreeDict = ['不限', '初中', '高中', '中技', '中专', '大专', '本科', 'MBA&EMBA', '硕士', '博士', '其他'];

    /**
     * 渠道字典
     * @var array
     */
    private static $channelDict = [1=>'智联', 2=>'51JOB', 3=>'猎聘', 4=>'中华英才', 5=>'58', 6=>'赶集', 7=>'百姓', 8=>'拉勾'];


    /**
     * 根据学历ID 返回学历汉字
     * @param $degreeId
     * @return String
     */
    public static function formatDegree($degreeId)
    {
        $degreeCn = self::$degreeDict[$degreeId];
        if (empty($degreeCn)) {
            return self::$degreeDict[0];
        } else {
            return $degreeCn;
        }
    }

    /**
     * 格式化薪资，将薪资格式化为以‘元’为单位的薪资范围和以K为单位的字符串。
     * 薪资类型分为：时薪、日薪、月薪、年薪
     * @param array $salary 薪资，需要格式化的薪资数据：
     * [
     *      'from' => '1000', //薪资范围起点，单位根据$unit确定
     *      'to' => '1500', //薪资范围结束点，单位根据$unit确定
     *      'unit' => 0, //薪资单位 0:/月 1:/月  2：/日（天） 3：/年  4：/时
     * ]
     * @return  array 格式化以后的数组：
     * [
     *      'salary_from' => 0, //薪资范围起点，单位：‘元’
     *      'salary_to' => 0, //薪资范围结束点，单位：‘元’
     *      'salary' => '' //薪资字符串，例：1-2K
     * ]
     */
    public static function formatSalary($salary)
    {
        if (empty($salary) && !is_array($salary)) {
            return ['salary_from'=>0, 'salary_to'=>0, 'salary'=>''];
        }
        $data = [];
        //月薪
        if( $salary['unit'] == 0 || $salary['unit'] == 1 ){
            if ( $salary['from'] == $salary['to'] && $salary['to']>0) {
                $data['salary'] = intval($salary['from']/1000).'K';
            } elseif ( $salary['from'] < $salary['to'] && $salary['from']>0) {
                $data['salary'] = floor($salary['from']/1000).'-'.ceil($salary['to']/1000).'K';
            }elseif ( $salary['to'] == 0 && $salary['from']>0) {
                $data['salary'] = intval($salary['from']/1000).'K以上';
            }elseif ( $salary['to'] >0 && $salary['from'] == 0) {
                $data['salary'] = intval($salary['to']/1000).'K以下';
            }
            $data['salary_from'] = $salary['from'];
            $data['salary_to'] = $salary['to'];
            return $data;
        } elseif ( $salary['unit'] == 2) { //日薪
            if ( $salary['from'] == $salary['to'] && $salary['to']>0) {
                $data['salary'] = intval($salary['from']*22/1000).'K';
            } elseif ( $salary['from'] < $salary['to'] && $salary['from']>0) {
                $data['salary'] = floor($salary['from']*22/1000).'-'.ceil($salary['to']*22/1000).'K';
            }elseif ( $salary['to'] == 0 && $salary['from']>0) {
                $data['salary'] = intval($salary['from']*22/1000).'K以上';
            }elseif ( $salary['to'] >0 && $salary['from'] == 0) {
                $data['salary'] = intval($salary['to']*22/1000).'K以下';
            }
            $data['salary_from'] = $salary['from']*22;
            $data['salary_to'] = $salary['to']*22;
            return $data;
        } elseif ( $salary['unit'] == 3) { //年薪
            if ( $salary['from'] == $salary['to'] && $salary['to']>0) {
                $data['salary'] = intval($salary['from']/12000).'K';
            } elseif ( $salary['from'] < $salary['to'] && $salary['from']>0) {
                $data['salary'] = floor($salary['from']/12000).'-'.ceil($salary['to']/12000).'K';
            }elseif ( $salary['to'] == 0 && $salary['from']>0) {
                $data['salary'] = intval($salary['from']/12000).'K以上';
            }elseif ( $salary['to'] >0 && $salary['from'] == 0) {
                $data['salary'] = intval($salary['to']/12000).'K以下';
            }
            $data['salary_from'] = intval($salary['from']/12);
            $data['salary_to'] = intval($salary['to']/12);
            return $data;
        } elseif ($salary['unit'] == 4) { //时薪
            if ( $salary['from'] == $salary['to'] && $salary['to']>0) {
                $data['salary'] = intval($salary['from']*176/1000).'K';
            } elseif ( $salary['from'] < $salary['to'] && $salary['from']>0) {
                $data['salary'] = floor($salary['from']*176/1000).'-'.ceil($salary['to']*176/1000).'K';
            }elseif ( $salary['to'] == 0 && $salary['from']>0) {
                $data['salary'] = intval($salary['from']*176/1000).'K以上';
            }elseif ( $salary['to'] >0 && $salary['from'] == 0) {
                $data['salary'] = intval($salary['to']*176/1000).'K以下';
            }
            $data['salary_from'] = intval($salary['from']*176);
            $data['salary_to'] = intval($salary['to']*176);
            return $data;
        }
        return ['salary_from'=>0, 'salary_to'=>0, 'salary'=>''];
    }

    private static function formatMonthlySalary()
    {

    }

    /**
     * 格式化 工作经验 单位的字符串。
     * @param $experience
     * @return  array 格式化以后的数组：
     * [
     *      'work_from' => 0, //工作经验起点，单位：‘年’
     *      'work_to' => 0, //工作经验点，单位：‘年’
     *      'work_years' => '' //工作经验字符串，例：3-5年
     * ]
     */
    public static function formatExperience($experience)
    {
        if (empty($experience) && !is_array ($experience)) {
            return ['work_from' => 0, 'work_to' => 0, 'work_years' => '' ];
        }
        if ($experience['from'] == $experience['to'] && $experience['to'] > 0) {
            $data['work_years'] = intval($experience['from']).'年以上';
        } elseif ($experience['from'] < $experience['to'] && $experience['from'] > 0) {
            $data['work_years'] = intval($experience['from']).'-'.intval($experience['to']).'年';
        } elseif ($experience['to'] == 0 && $experience['from'] > 0) {
            $data['work_years'] = intval($experience['from']).'年以上';
        } elseif ($experience['to'] >0 && $experience['from'] == 0) {
            $data['work_years'] = intval($experience['from']).'年以下';
        } else {
            $data['work_years'] = '';
        }
        $data['work_from'] = $experience['from'];
        $data['work_to']  = $experience['to'];
        return $data;
    }


    /**
     * 格式化薪资。将薪资范围起点和最高点格式化为K。
     * 先格式化 $salary  再使用 $salaryFrom, $salaryTo
     * @author: maliang <maliang@liuxuchaota.com>
     * @date: 2017年5月5日20:09:20
     * @param int $salaryFrom 薪资范围起点
     * @param string $salary 完整薪资字段
     * @return string
     */
    public static function formatSalaryFromToInt($salaryFrom, $salaryTo, $salary = '')
    {
        if (!empty($salary) && $salary != '面议') {

            if (strpos($salary, '元/月')) {
                preg_match_all('/\d+/i', $salary, $match);
                return ['salary_from' => intval(current($match)[0] / 1000), 'salary_to' => ceil(current($match)[1] / 1000)];
            }
            if (strpos($salary, '元')) {
                preg_match_all('/\d+/i', $salary, $match);
                if (current($match)[0] >= 1000 || current($match)[1] >= 1000) {
                    return ['salary_from' => intval(current($match)[0] / 1000), 'salary_to' => ceil(current($match)[1] / 1000)];
                }
            }
            if (strpos($salary, 'K/月')) {
                preg_match_all('/[\d.]+/i', $salary, $match);
                return ['salary_from' => current($match)[0], 'salary_to' => current($match)[1]];
            }
            if (strpos($salary, '万/月')) {
                preg_match_all('/[\d.]+/i', $salary, $match);
                return ['salary_from' => current($match)[0] * 10, 'salary_to' => current($match)[1] * 10];
            }

            if (strpos($salary, '千')) {
                preg_match_all('/[\d.]+/i', $salary, $match);
                return ['salary_from' => intval(current($match)[0]), 'salary_to' => ceil(end($match[0]))];
            }
            if (strpos($salary, '/月')) {
                preg_match_all('/\d+/i', $salary, $match);
                return ['salary_from' => intval(current($match)[0] / 1000), 'salary_to' => ceil(current($match)[1] / 1000)];
            }


            if (strpos($salary, '万')) {
                preg_match_all('/[\d.]+/i', $salary, $match);
                return ['salary_from' => intval((current($match)[0] / 12) * 10), 'salary_to' => ceil((current($match)[1] / 12) * 10)];
            }
            if (strpos($salary, '小时')) {
                preg_match_all('/[\d.]+/i', $salary, $match);
                if (count($match) == 1) {
                    $salaryFrom = intval((current($match)[0] * 176) / 1000);
                    return ['salary_from' => $salaryFrom, 'salary_to' => $salaryFrom];
                }
                return ['salary_from' => $match[0], 'salary_to' => $match[1]];
            }
        } else {
            if ($salaryFrom > 1000 || $salaryTo > 1000) {
                return ['salary_from' => intval($salaryFrom / 1000), 'salary_to' => ceil(intval($salaryTo / 1000))];
            }
            if (($salaryFrom < 1000 && $salaryFrom >= 100) || ($salaryFrom < 1000 && $salaryFrom >= 100)) {
                return ['salary_from' => intval($salaryFrom / 100), 'salary_to' => ceil(intval($salaryTo / 100))];
            }
            if ($salaryFrom < 100 || $salaryTo < 100) {
                return ['salary_from' => intval($salaryFrom), 'salary_to' => ceil(intval($salaryTo))];
            }
        }
        return ['salary_from' => 0, 'salary_to' => 0];
    }

}
