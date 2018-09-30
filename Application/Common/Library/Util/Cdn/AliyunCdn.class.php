<?php
namespace Common\Library\Util\Cdn;

vendor('aliyun-oss-php-sdk.vendor.autoload');
use OSS\OssClient;

/**
 * 上传到CDN
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2017-2-23 11:56:28
 */
class AliyunCdn
{
    private $ossClient;
    
    private $bucket;
    
    private $options = [OssClient::OSS_CHECK_MD5 => true];
    
    public function __construct()
    {
        $config = C('ALIYUN_CDN');
        if ( empty($config) ) {
            throw new \Exception("请配置阿里云CDN");
        }
        $isCName = false;
        $this->ossClient = new OssClient($config['accessKeyId'], $config['accessKeySecret'], $config['endpoint'], $isCName);
        $this->bucket = $config['bucket'];
    }
    
    /**
     * 设置选项
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-02-23 16:42
     * @param array $options 配置选项
     * @return null
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return;
    }
    
    /**
     * 上传本地文件
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-02-23 16:43
     * @param string $object 目标文件名称
     * @param string $file 本地文件全路径
     * @return string 上传后的文件路径，如果上传失败返回空字符串。
     */
    public function uploadFile($object, $file)
    {
        if ( empty($object) || empty($file) ) {
            return '';
        }
        
        try {
            $result = $this->ossClient->uploadFile($this->bucket, $object, $file, $this->options);
            return $result['oss-request-url'];
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return '';
        }
    }
    
}
