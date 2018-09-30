<?php
namespace Org\Util;

use Org\Util\AES;

/**
 * AES加密、解密封装
 *
 * @author qiaoda
 */
class RNCryptor
{
    /**
     * 根据指定的KEY加密明文
     * @author 董光明
     * @date 2016-07-13
     * @param string $plaintext 加密之前的明文
     * @param string $key 加密明文用的KEY
     * @return string 加密后的字符串
     */
    public static function encrypt($plaintext, $key)
    {
        $aes = new AES($key);
        $tBase64Encrypted = $aes->encrypt($plaintext);
        return $tBase64Encrypted;
    }
    
    /**
     * 根据指定的KEY对密文解密
     * @author 董光明
     * @date 2016-07-13
     * @param string $encrypted 加密后的密文
     * @param string $key 解密密文用的KEY，必须和加密时用的KEY一致。
     * @return string 解密后的明文
     */
    public static function decrypt($encrypted, $key)
    {
        $aes = new AES($key);
        $tPlaintext = $aes->decrypt($encrypted);
        return $tPlaintext;
    }
    
    /**
     * 获取加密用的KEY
     * @author 董光明 <dongguangming@qiaodazhao.com>
     * @date 2016-07-18 10:12
     * @return string
     */
    public static function getKey()
    {
        return C('ENCRYPT_KEY');
    }
    
}
