<?php
namespace Admin\Controller;

use Application\AdminBaseController;
use Common\Service\Zshop\ArticleService;
use Common\Service\Zshop\ArticleCateService;

class ArticleController extends AdminBaseController
{

    private $articleService = null;
    private $articleCateService = null;
    public function __construct()
    {
        parent::__construct();
        $this->articleService = new ArticleService();
        $this->articleCateService = new ArticleCateService();
    }

    /**
     * 文章分类列表
     */
    public function index()
    {
        $param = parent::_handleTime(I());
        $tPage = I('page', 1, 'intval');
        $tPageSize = I('page_size', 10, 'intval');
        $where = array();
        //获取总数
        $tCount = $this->articleService->countByCondition($where);
        $show = $this->page($tCount, $tPage, $tPageSize); // 分页显示输出
        $articleList = $this->articleService->getList($where, $tPage, $tPageSize, [], 'id DESC');
        if($articleList){
            foreach($articleList as $key=>&$val){
                if($val['cate_id']==0){
                    $val['cate_name'] = '顶级分类';
                }else{
                   $parentData = $this->articleCateService->getByPrimaryKey($val['cate_id']);
                    $val['cate_name'] = $parentData['cate_name']; 
                }
            }
        }
        //获取分类下数据总数
        $this->assign('param', $param);
        $this->assign('count', $tCount);
        $this->assign('articleList', $articleList);
        $this->assign('currentPage', $tPage);
        $this->assign('page', $show);
        $this->display();
    }
    
    /**
     * 显示添加页面
     */
    public function add()
    {
        $resTree = $this->articleCateService->getTree();
        $this->assign('tree',$resTree);
        $this->display();
    }
    /**
     * ajax 检查分类名称是否存在
     */
    public function ajaxCheckCateName()
    {
        $data['cate_name'] = I('post.cate_name','','trim,strip_tags');
        $hasName = $this->articleCateService->findByName($data['cate_name']);
        if($hasName){
            exit('{"valid":false}');
        }else{
            exit('{"valid":true}');
        }
    }
    /*
     * 商品分类添加
     */
    public function doAdd () {

        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_add_parames();
        
        if(empty($data['title']) || empty($data['content'])){
            $this->error('文章标题和内容都不能为空','/Admin/Article/add',2);
            return;
        } 
        $data['create_time'] = time();
        $data['ip'] = get_client_ip();
        $addresult = $this->articleService->add($data);
        if ($addresult){
                $this->success('文章添加成功','/Admin/Article/index',2);
                return;
		}else{
			$this->error('文章添加失败','/Admin/Article/add',2);
			return;
		}
        
    }

    /*
     * 显示更新页面
     */

    public function updates()
    {
        $Id = I('id', '', 'intval,htmlspecialchars');
        $data = $this->articleService->getByPrimaryKey($Id);
        $resTree = $this->articleCateService->gettree();
        $this->assign('data', $data);
        $this->assign('tree',$resTree);
        $this->display();
    }

    /*
     * 处理更新数据
     */

    public function doUpdate()
    {
        //接收数据
        if (!IS_POST) {
            exit("非法请求");
        }
        $data = $this->receive_update_parames();
        
        if(empty($data['title']) || empty($data['content'])){
            $this->error('文章标题和内容都不能为空','/Admin/Article/updates/id/'.$data['id'],2);
            return;
        } 
        $data['update_time'] = time();
        $upResult = $this->articleService->updateByPrimaryKey($data['id'],$data);
        if(!$upResult){
            $this->error('修改失败','/Admin/Article/updates/id/'.$data['id'],2);
            return;
        }else{
            $this->success('修改成功', '/Admin/Article/index', 2);
            return;
        }
    }

    /*
     * 删除操作
     */
    public function doDelete()
    {
        $articleId = I('id', '', 'intval,htmlspecialchars');
       
        if (0 >= $articleId) {
            $result = ['error_code'=>'1','message'=>'ID错误'];
            echo json_encode($result);
            return;
        }
        //  检查有无商品 如果有不能删除  商品做完了加上
        $delResult = $this->articleService->deleteByPrimaryKey($articleId);
        if ($delResult) {
            $result = ['error_code'=>'0','message'=>'删除成功'];
            echo json_encode($result);
            return;
        }
        $result = ['error_code'=>'1','message'=>'删除失败'];
        echo json_encode($result);
        return;
    }

    /*
    *  接收添加分类post参数
    * 
    */
    private function receive_add_parames(){
        $data = [];
        $data['title'] = I('post.title','','strip_tags');
        $data['content'] = I('post.content','','trim');
        $data['cate_id'] = I('post.cate_id','','intval');
        return $data;
    }
    
    /*
    *  接收修改分类post参数
    * 
    */
    private function receive_update_parames(){
        $data = [];
        $data['id'] = I('post.id','','strip_tags');
        $data['title'] = I('post.title','','htmlspecialchars');
        $data['content'] = I('post.content','','trim');
        $data['cate_id'] = I('post.cate_id','','intval');
        return $data;
    }
}
