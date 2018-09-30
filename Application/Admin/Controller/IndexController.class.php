<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\UserService;

use Common\Service\Zshop\UsersLoginStatusService;



class IndexController extends AdminBaseController {
    
    private $userService                = null;
    
    public function __construct () {
        parent::__construct();
        $this->userService = new UserService();
    }
    
    public function index () {
        $param = I( '' );
        $param = parent::_handleTime( $param );
        $day = $this->getDay( $param );
        //宏观统计
        $subRegCount = 0;
        $where = array ( 'between' , array ( $param[ 'srtime' ] , $param[ 'ertime' ] ) );
        
        //使用统计
        $openCount = 0;
        $avgOpenCount = 0;
        $avgUseTime = 0;
        
        // $countInfo['hgtj'][] 	= ['label'=>'下载页面访问量', 'value'=>$userCount];
        // $countInfo['hgtj'][] 	= ['label'=>'下载量', 'value'=>$userCount];
        $countInfo[ 'hgtj' ][] = [ 'label' => '提交注册用户' , 'value' => $subRegCount ];
        $countInfo[ 'hgtj' ][] = [ 'label' => '成功注册用户' , 'value' => $userCount ];
        $countInfo[ 'hgtj' ][] = [ 'label' => '渠道账号' , 'value' => $channelCount ];
        
        //使用统计
        $countInfo[ 'sytj' ][] = [ 'label' => '打开量' , 'value' => $openCount ];
        $countInfo[ 'sytj' ][] = [ 'label' => '登录用户' , 'value' => $loginCount ];
        $countInfo[ 'sytj' ][] = [ 'label' => '平均打开次数' , 'value' => $avgOpenCount ];
        $countInfo[ 'sytj' ][] = [ 'label' => '平均使用时长' , 'value' => $avgUseTime ];
        
        //推荐功能统计
        $countInfo[ 'tjgntj' ][] = [ 'label' => '推荐职位数' , 'value' => $recommendJobCount ];
        $countInfo[ 'tjgntj' ][] = [ 'label' => '推荐简历数' , 'value' => $recommendResumeCount ];
        $countInfo[ 'tjgntj' ][] = [ 'label' => '短信邀请量' , 'value' => $invitBySmsCount ];
        $countInfo[ 'tjgntj' ][] = [ 'label' => '接受量' , 'value' => $receiveCount ];
        $countInfo[ 'tjgntj' ][] = [ 'label' => '自动接受量' , 'value' => $autoReceiveCount ];
        $countInfo[ 'tjgntj' ][] = [ 'label' => '拒绝量' , 'value' => $rejectCount ];
        
        $this->assign( 'date' , $param[ 'date' ] );
        $this->assign( 'today', date("Y-m-d",time()));
        $this->assign( 'day' , $day );
        $this->assign( 'srtime' , $param[ 'srtime' ] );
        $this->assign( 'ertime' , $param[ 'ertime' ] );
        $this->assign( 'countinfo' , $countInfo );
        $this->display();
    }
    
    private function getDay ( $param ) {
        if ( $param && isset( $param[ 'date' ] ) ) {
            switch ( $param[ 'date' ] ) {
                case 'today':
                    $param[ 'day' ] = date( 'Y年m月d日' );
                    break;
                case 'yesterday':
                    $param[ 'day' ] = date( 'Y年m月d日' , strtotime( '-1 day' ) );
                    break;
                case 'week':
                    $mondayTime = strtotime( '+' . 1 - date( 'w' ) . ' days' );
                    $param[ 'day' ] = date( 'Y年m月d日' , $mondayTime ) . "-" . date( 'Y年m月d日' , time() );
                    break;
                case 'month':
                    $param[ 'day' ] = date( 'Y年m月d日' , $param[ 'srtime' ] ) . "-" . date( 'Y年m月d日' , time() );
                    break;
                case 'all':
                    $param[ 'day' ] = '全部';
                    break;
                default:
                    break;
            }
        } elseif ( ! isset( $param[ 'srtime' ] ) ) {
            $param[ 'date' ] = 'today';
            $param[ 'day' ] = date( 'Y年m月d日' );
        } else {
            $param[ 'day' ] = date( 'Y年m月d日' , $param[ 'srtime' ] ) . "-" . date( 'Y年m月d日' , $param[ 'ertime' ] );
        }
        
        //var_dump($param);die;
        return $param;
    }
    
    
}