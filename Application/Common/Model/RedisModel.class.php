<?php
namespace Common\Model;

/**
 * Redis数据操作
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 */
class RedisModel
{
    private static $instance = null;
    private $redis;
    
    public function __construct($redisConnection='REDIS')
    {
        //Redis数据库连接配置
        $config = C($redisConnection);
        $this->redis = new \Redis();
        $this->redis->connect($config['HOST'], $config['PORT']);
        $this->redis->auth();
    }
    
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->redis,$name),$arguments);
    }
    
    /**
     * 取得redis实力
     * @param type $redisConnection
     * @return type
     */
    public static function getInstance($redisConnection='REDIS')
    {
        if ( !empty(self::$instance) ) {
             return self::$instance;
        }
        
        //Redis数据库连接配置
        $config = C($redisConnection);
        
        $redis = new \Redis();
        $connect = $redis->connect($config['HOST'], $config['PORT']);
        $auth = true;
        if ( !empty($config['AUTH']) ) {
            $auth = $redis->auth();
        }
        
        if ( $connect && $auth ) {
            self::$instance = $redis;
        }
        
        return self::$instance;
    }
}
