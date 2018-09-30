<?php
namespace Home\Controller;

use Application\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $this->assign('title','首页');
        $this->display();
    }
    
}