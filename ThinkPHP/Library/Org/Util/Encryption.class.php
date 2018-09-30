<?php
namespace Org\Util;

/**
 * 加密算法
 * @author 董光明 <dongguangming@qiaodata.com>
 * @date 2017-5-31 15:17:04
 */
class Encryption
{

    /**
     * 通过随机字符串的MD5值和字符串的异或运算对字符串进行初步加密再通过密钥对初步加密过的字符串进一步通过异或运算加密
     * @param string $txt 待加密的字符串
     * @param string $key 密钥
     * @return string 加密后的字符串
     */
    public static function dynamicEncrypt($txt, $key)
    {
        srand((double) microtime() * 1000000); //播下随机种子
        $encryptKey = md5(rand(0, 32000)); //生成随机数,并取得随机数的MD5值,做加密运算用.
        $ctr = 0;  //计数器
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encryptKey) ? 0 : $ctr; //当计数器的值等于$encrypt_key的长度时,将计数器$ctr的长度设置为0;
            $tmp .= $encryptKey[$ctr] . ($txt[$i] ^ $encryptKey[$ctr++]); //将$encrypt_key与字符串的每个字符进行异或运算
        }
        return base64_encode(self::passportKey($tmp, $key));
    }

    /**
     * 通过给定的密钥对加密的字符串解密
     * 解密dynamicEncrypt加密生成的字符串
     * @param string $txt 待解密的字符串
     * @param string $key 密钥
     * @param string 解密后的字符串
     */
    public static function dynamicDecrypt($txt, $key)
    {
        //根据密钥对加密字符串进行初步解密
        $txt = self::passportKey(base64_decode($txt), $key);
        $tmp = '';
        
        //把字符串中的随机数的MD5值中的每个字符取出来与加密字符串做异或运算进行解密
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }
    
    /**
     * 通过字符串和密钥异或运算的方式对字符串进行加密、解密
     * @param string $txt 等待加密、或者解密的字符串
     * @param string $encryptKey 密钥
     * @return string 返回加密、或解密过的字符串
     */
    private static function passportKey($txt, $encryptKey)
    {
        $encryptKey = md5($encryptKey); //密钥md5加密
        $ctr = 0; //计数器
        $tmp = '';
        for ($i = 0; $i < strlen($txt); $i++) {
           $ctr = $ctr == strlen($encryptKey) ? 0 : $ctr; //计数器等于密钥md5值的长度时重新将计数器置为0
           $tmp .= $txt[$i] ^ $encryptKey[$ctr++];
        }
        return $tmp;
    }

}
