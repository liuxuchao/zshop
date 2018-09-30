<?php
namespace Common\Library\Util\Parse;
/**
 * 解析
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2017-1-19 10:41:53
 */
class Parse
{
    /**
     * 解析
     * @param type $pattern
     * @param type $originalString
     * @param type $filterFunction
     * @param type $group
     * @return string
     */
    protected function parseStr( $pattern, $originalString, $filterFunction=['strip_tags'], $group=1 )
    {
        if ( preg_match($pattern, $originalString, $match) ) {
            $result = $match[$group];
            if ( !empty($filterFunction) ) {
                foreach ( $filterFunction as $func ) {
                    $result = $func($result);
                }
            }            
            return $result;
        } else {
            return '';
        }
    }
}
