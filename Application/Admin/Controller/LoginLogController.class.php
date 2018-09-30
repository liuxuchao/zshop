<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\UsersLoginLogService;

/**
 * UU推荐用户登录日志
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 * @date 2016-8-15 18:33:27
 */
class LoginLogController extends AdminBaseController
{
    private $usersLoginLog = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->usersLoginLog = new UsersLoginLogService();
    }
    
    public function index()
    {
        $logList;
        
        $this->display();
    }
}
