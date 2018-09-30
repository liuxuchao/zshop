<?php

namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\SourceService;
class SourceController extends AdminBaseController
{

    private $sourceService = null;

    public function __construct()
    {
        parent::__construct();
        $this->sourceService = new SourceService();
    }

    public function index()
    {
        
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 30, 'intval');
        //获取总数
        $tCount = $this->sourceService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $sourceList = $this->sourceService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        

        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('sourceList', $sourceList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);

        $this->display();
    }
    


    










}
