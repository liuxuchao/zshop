<?php
namespace Application;

use Think\Controller;
use Org\Util\RNCryptor;
use Org\Util\Encryption;
/**
 * Controller父类
 *
 * @author liuxuchao
 */
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->key = RNCryptor::getKey();
        $this->userId = RNCryptor::decrypt(I('post.userid', 0, 'trim'), $this->key);
        $this->userKey = $this->userId . '_' . $this->key;
    }
    
    /**
     * MD5加密明文，主要用于生成用户密文密码。
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $plaintext 原始字符串
     * @param string $additionalKey 附加的加密字符串
     * @return string
     */
    protected function md5Encrypt($plaintext, $additionalKey='')
    {
        $text = $plaintext;
        
        //如果提供了附加值，将附加值连接到原始明文后加密
        if ( !empty($additionalKey) ) {
            $text .= $additionalKey;
        }
        
        return md5($text);
    }
    
    /**
     * 生成登录密码
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $plaintext 明文密码
     * @return type
     */
    protected function buildPassword($plaintext)
    {
        $text = trim($plaintext);
        $additionalKey = C('PASSWORD_KEY');
        $password = $this->md5Encrypt($text, $additionalKey);
        return $password;
    }
     /**
     * 分页
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param int $pTotal 数据总数
     * @param int $pPage 当前页数
     * @param int $pPageSize 每页数据量
     * @param array $pParam 参数
     * @return string
     */
    public function page($pTotal, $pPage, $pPageSize, $pParam=[])
    {
        $tTotal    = intval($pTotal);
        $tPage     = intval($pPage);
        $tPageSize = intval($pPageSize);
        $tTotalPage = ceil($tTotal / $tPageSize);
        
        if ( 0 >= $tPage ) {
            $tPage = 1;
        }
        
        if ( $tPage > $tTotalPage ) {
            $tPage = $tTotalPage;
        }
        
        $tUrl     = $this->getCurrentUrl();
        $tUrlInfo = parse_url($tUrl);
        if ( isset($tUrlInfo['port']) ) {
            $tUrl = $tUrlInfo['scheme'] . '://' . $tUrlInfo['host'] . ':' . $tUrlInfo['port'] . rtrim($tUrlInfo['path'], '/') . '/';
        } else {
            $tUrl = $tUrlInfo['scheme'] . '://' . $tUrlInfo['host'] . rtrim($tUrlInfo['path'], '/') . '/';
        }        
        
        //prev page
        $tPrevPage = $tPage - 1;
        if ( $tPrevPage < 1 ) {
            $tPrevPage = 1;
        }
        
        //next page
        $tNextPage = $tPage + 1;
        if ($tNextPage+10 < $tTotalPage) {
            $tNextPage +=10;
        }elseif ( $tNextPage >= $tTotalPage ) {
            $tNextPage = $tTotalPage;
        }
        $html = '<div class="dataTables_paginate paging_bootstrap pagination" style="float:none;">'
                . '<ul>';
        if( $tPage == 1 ){
            $html .= '';
        }else{
            $html .= '<li><a href="' . $tUrl . 'page/'.($tPage - 1) . '/?' . $tUrlInfo['query'] . '">«</a></li>';
        }
        
        $pageNumber = $tTotalPage;
        if (10 < $tTotalPage) {
            if ( $tPage % 10 == 0 ) {
                $pageNumber = $tPage;
            } else {
                $pageNumber = (floor($tPage / 10) + 1) * 10;
            }
        }
        if (9 < $tTotalPage) {
            $pageStart = $pageNumber-9;
        } else {
            $pageStart = $tPage;
        }
        if ( 9 >= $tTotal ) {
            $pageStart = 1;
        }
        for ($i=$pageStart; $i<=$pageNumber; $i++) {
            $tStyle = '';
            if ($tPage == $i) {
                $tStyle = 'style="background-color: #eee;"';
            }
            if ( isset($tUrlInfo['query']) && !empty($tUrlInfo['query']) ) {
                $html .= '<li><a ' . $tStyle . ' href="' . $tUrl . 'page/' . 
                        $i  . '/?' . $tUrlInfo['query'] . '">' . $i . '</a></li>';
            } else {
                $html .= '<li><a ' . $tStyle . ' href="' . $tUrl . 'page/' . $i  . '/">' . $i . '</a></li>';
            }
        }
        
        if ( $tPage < $tTotalPage ) {
            $html .= '<li><a href="' . $tUrl . 'page/' . ($tPage+1) . '/?' . $tUrlInfo['query'] . '">»</a></li>';
        }else{
            $html .= '';
        }
        $html .= '</ul></div>';

        return $html;
    }
        
    /**
     * 获取当前URL
     * @return string
     */
    private function getCurrentUrl()
    {
        $tUrl = trim('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/') . '/';
        $tUrl = preg_replace('/page\/[0-9]+\//i', '', $tUrl);
        $tUrl = trim($tUrl, '/');

        $tUri = trim($_SERVER['REQUEST_URI'], '/');
        $tUriArray = explode('/', $tUri);
        if ( 2 == count($tUriArray) ) {
            $tUrl .= '/index';
        }

        return $tUrl;
    }

    /**
     * 空操作
     * @param type $name
     * @return type
     */
    public function _empty()
    {
        redirect("/Home/Empty/index");
        return;
    }
    
    /**
     * 接收简历ID，并将其解密。
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param string $keyName 简历ID参数key名称
     * @param string $methord 接收方法，POST\GET\REQUEST
     * @return string 解密后的简历ID
     */
    protected function receiveResumeId($keyName='resume_id', $methord='POST')
    {
        //接收发送过来的简历ID
        switch (strtoupper($methord)) {
            case 'GET':
                $ciphertextResumeId = I('get.' . $keyName, '', 'trim');
                break;
            case 'POST':
                $ciphertextResumeId = I('post.' . $keyName, '', 'trim');
                break;
            case 'REQUEST':
                $ciphertextResumeId = I('request.' . $keyName, '', 'trim');
                break;
            default:
                $ciphertextResumeId = I('request.' . $keyName, '', 'trim');
                break;
        }
        
        //解密简历ID
        return Encryption::dynamicDecrypt($ciphertextResumeId, $this->userKey);
    }
    
    /**
     * 加密简历ID
     * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
     * @param mixt $resumeId 简历ID
     */
    protected function encryptResumeId($resumeId)
    {
        if (empty($resumeId)) {
            return '';
        }
        
        return Encryption::dynamicEncrypt($resumeId, $this->userKey);
    }
}
