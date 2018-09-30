<?php
namespace Common\Service\Zshop;

use Application\BaseService;
use Common\Model\Zshop\ArticleModel;

/**
 * ti_article
 *
 * @author liuxuchao
 */
class ArticleService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 设置当前service默认model
     * @author 刘旭超
     * @date 2016-07-13 19:01
     * @param obj $model Mysql Model对象
     * @return null
     */
    public function setModel($model=null)
    {
        if ( !empty($model) && is_object($model) ) {
            $this->model = $model;
        } else {
            $this->model = new ArticleModel();
        }
        return;
    }
    

    /**根据UserId 渠道id 获取 用户信息
     * @author liuxuchao
     * @param  $userId 用户ID
     * @param  $channelId 渠道ID
     * return array | false
     */
    public function getUserInfo($userId)
    {
        $userId = intval($userId);
        if( $userId==0 ){
            return false;
        }
        
        $result = $this->model->getByUserId($userId);
        return $result;
    }

}
