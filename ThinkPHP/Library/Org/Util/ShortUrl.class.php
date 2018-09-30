<?php
namespace Org\Util;

vendor("Curl.vendor.autoload");

use Curl\Curl;

/**
 * 短链接
 * 50r.cn接口
 * @author 董光明 <dongguangming@qiaodazhao.com>
 * @date 2016-7-23 10:28:19
 */
class ShortUrl
{
    /**
     * 生成短链接API接口配置
     * @var array
     */
    /*private static $apiConfig = [
        'api_url' => 'http://50r.cn/urls/add.json',
        'ak' => '5792e57a293c4eac7044aa4d',
    ];
    */
   private static $apiConfig = [
        'api_url' => 'http://api.t.sina.com.cn/short_url/shorten.json',
        'source' => '1916010815',
    ];
    
    /**
     * 长链接生成短链接
     * @author 董光明 <dongguangming@qiaodazhao.com>
     * @date 2016-07-23 11:03
     * @param string $originalUrl 原始长链接
     * @return string 生成的短链接
     */
    
    public static function buildUrl($originalUrl)
    {
        $originalUrl = trim($originalUrl);
        if ( empty($originalUrl) ) {
            return '';
        }
        
        //参数
        $parameter = [];
        if ( !empty(self::$apiConfig['source']) ) {
            $parameter['source'] = self::$apiConfig['source'];
        }
        $parameter['url_long'] = $originalUrl;
        $queryStr = http_build_query($parameter);
        
        //拼接接口URL
        $apiUrl = self::$apiConfig['api_url'] . '?' . $queryStr;
        $curl = new Curl();
        //生成短连接错误重新生成重新发送
        $sendTimes=3;
        while($sendTimes>0){
            $result = $curl->get($apiUrl);
            if(strcmp($result[0]->url_short, "http://t.cn/") ===0){
                $sendTimes--;
            }else{
                break;
            }
        }
        return $result[0]->url_short;
    }

}
