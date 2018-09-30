<?php
namespace Application;

use Application\BaseController;
use Common\Service\Zshop\ProductCateService;

use Org\Util\RNCryptor;
/**
 * 客户Controller父类
 *
 * @author liuxuchao
 */
class HomeBaseController extends BaseController
{
    private $checkLogin = [
        '/Home/My/', //登录
    ];
    private $productcateService = null;
    public function __construct()
    {
        parent::__construct();
        $this->productcateService = new ProductCateService();
        $this->staticVersionNo();
        $this->NavTopCategory();
        $loginInfo = $this->getLoginInfo();
        $this->assign("loginInfo",$loginInfo);
    }
    
    /**
     * 加载静态资源版本号
     * js、css等
     * @author 刘旭超
     * @date 2016-08-17 17:11
     * @return null
     */
    private function staticVersionNo()
    {
        $cssVersion = C('CSS_VERSION');
        $jsVersion  = C('JS_VERSION');
        
        $this->assign('cssVersion', $cssVersion);
        $this->assign('jsVersion', $jsVersion);
        
        return;
    }
    
    /**
     * 检查用户登录状态
     * @return boolean
     */
    public function checkLoginStatus()
    {
        //检验当前控制器是否需要登录验证
        $controller = strtolower( __CONTROLLER__ );
        $controller = str_replace('/index.php', '', $controller);
        $controller = str_replace('.php', '', $controller);
        $sessionUserName = substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN'));
        if ( session($sessionUserName) == null ) {
            return false;
        }
        return true;
    }
    
    /**
     * 获取登陆信息
     */
    public function getLoginInfo()
    {
        //获取session 名称 
        $sessionUserName = substr(md5(C('SESSION_USER_NAME')),0,C('SESSION_NAME_LENGTN'));
        //解密session值
        $sessionUserNameValue = RNCryptor::decrypt($_SESSION[$sessionUserName], C('ENCRYPT_KEY'));
        $userId = RNCryptor::decrypt($_SESSION['user_id'], C('ENCRYPT_KEY'));
        if($sessionUserNameValue){
            return [$userId,$sessionUserNameValue];
        }
        return [];
    }


    /**
     * 前台导航 顶级导航
     */
    public function NavTopCategory()
    {
        $parent = "parent_id =0 and has_child=1";
        $parent_cate = $this->productcateService->getparentCate($parent);
        $child = "parent_id !=0 and has_child!=1";
        $child_cate = $this->productcateService->getchildCate($child);
        $this->assign('parent', $parent_cate);
        $this->assign('child', $child_cate);
    }

}
