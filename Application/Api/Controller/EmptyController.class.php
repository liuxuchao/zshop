<?php
namespace Api\Controller;

/**
 * 空操作处理
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 */
class EmptyController extends \Application\BaseController
{
    public function index()
    {
        redirect("/Home/Empty/index");
        return;
    }
    
}
