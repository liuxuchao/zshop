<?php
namespace Application;
 
//import("Org.Util.RNCryptor");

use Application\BaseController;

use Org\Util\RNCryptor;
/**
 * 管理后台Controller基类
 *
 * @author liuxuchao
 */
class AdminBaseController extends BaseController
{
    protected $key;
    protected $nickname;
    protected $adminUserId;
    protected $displayType=1;   //显示模式  1：宽屏   2：窄屏

    private $noCheckLogin = [
        '/admin/login', //登录
    ];
    public function __construct()
    {
        parent::__construct();
		
        $this->key = RNCryptor::getKey();
        $this->checkLoginStatus();
        $this->setDisplayType(1);   //显示模式 
        $this->assign('displayType',cookie('setDisplayType'));
        //当前位置
        $this->assign('controllerName', CONTROLLER_NAME);
        $this->assign('actionName', ACTION_NAME);
    }

    public function checkLoginStatus()
    {
        //检验当前控制器是否需要登录验证
        $controller = strtolower( __CONTROLLER__ );
        $controller = str_replace('/index.php', '', $controller);
        $controller = str_replace('.php', '', $controller);


        $tmpInArray = in_array($controller, $this->noCheckLogin );
        if ( $tmpInArray !=1 &&  session('admin_user') == null ) {
            $this->error('请登录','/Admin/Login/login',2);
            return;
        }
        return;
    }

    public function setDisplayType($typeId=null)
    {
        $gettypeId     = I('typeId', '', 'intval,htmlspecialchars');
        if (empty($typeId)  && !empty($gettypeId )) {
            $typeId = $gettypeId;
        }
        cookie('setDisplayType',$typeId);
    }

    /**
     * 根据参数返回相应的时间戳
     * @param  [array] $param [description]
     * @return [array]        [description]
     */
    public function _handleTime($param)
    {
        if ($param && isset($param['date']))
        {
            switch ($param['date']) {
                case 'today':
                    $param['srtime'] = strtotime(date('Y-m-d 00:00:00'));
                    $param['ertime'] = time();
                    break;
                case 'yesterday':
                    $param['srtime'] = strtotime(date('Y-m-d 00:00:00',strtotime('-1 day')));
                    $param['ertime'] = strtotime(date('Y-m-d 23:59:59',strtotime('-1 day')));
                    break;
                case 'week':
                    $mondayTime = strtotime( '+'. 1-date('w') .' days' );
                    $param['srtime']=strtotime(date('Y-m-d',$mondayTime));
                    $param['ertime'] = time();
                    break;
                case 'month':
                    $param['srtime'] = strtotime(date('Y-m-01 00:00:00',time()));
                    $param['ertime'] = time();
                    break;
                case 'all':
                    $param['srtime'] = strtotime(date('Y-m-01 00:00:00',0));
                    $param['ertime'] = time();
                    break;
                default:
                    break;
            }
        } elseif (!isset($param['srtime'])){
            $param['date'] = 'today';
            $param['srtime'] = strtotime(date('Y-m-d 00:00:00'));
            $param['ertime'] = time();
        } else {
            $param['srtime'] = strtotime($param['srtime']);
            $param['ertime'] = isset($param['ertime'])? strtotime($param['ertime']) : time();
        }
        return $param;
    }
    
    /**
     *  后台图片上传
     * @param  [array] $param [description]
     * @return [array]        [description]
     */
    
    
}
