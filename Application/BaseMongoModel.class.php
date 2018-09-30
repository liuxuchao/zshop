<?php
namespace Application;

use Think\Model\MongoModel;

/**
 * Description of BaseMongoDBModel
 *
 * @author 刘旭超 <liuxuchao126@126.com>
 */
class BaseMongoModel extends MongoModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 添加到数据库中
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-19 16:13
     * @param array $data 要添加的数据
     * @return boolean | string mongo _id
     */
    public function add( $data )
    {
        if ( empty($data) || !is_array($data) ) {
            return false;
        }
        
        $result = parent::add($data);
        return $result;
    }

    /**
     * 添加到数据库中
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-19 16:13
     * @param array $data 要添加的数据
     * @return boolean | string mongo _id
     */
    public function select()
    {
        $result = parent::select();
        return $result;
    }

    /**
     * 批量添加数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-19 14:32
     * @param array $data 数据
     * @return boolean | int
     */
    public function addAll($data)
    {
        if ( empty($data) ) {
            return false;
        }
        
        $add = parent::addAll($data);
        return $add;
    }
    
    /**
     * 更新数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-06 17:18
     * @access public
     * @param array $criteria 更新条件
     * @param array $newData 新数据
     * @param array $options
     * [
     *      'multi' => false, //是否是批量更新
     *      'upsert' => false, //数据不存在时是否插入
     * ]
     * @return array
     *  array(6) {
     *       ["ok"] => float(1)
     *       ["nModified"] => int(0)
     *       ["n"] => int(1)
     *       ["err"] => NULL
     *       ["errmsg"] => NULL
     *       ["updatedExisting"] => bool(true)
     *   }
     * 或者
     *  array(7) {
     *       ["ok"] => float(1)
     *       ["nModified"] => int(0)
     *       ["n"] => int(1)
     *       ["err"] => NULL
     *       ["errmsg"] => NULL
     *       ["upserted"] => object(MongoId)#17 (1) {
     *         ["$id"] => string(24) "586f1216e40ba4a40c3dbd7d"
     *       }
     *       ["updatedExisting"] => bool(false)
     *   }
     */
    public function upsert( $condition, $data, $option )
    {
        $result = parent::upsert($condition, $data, $option);
        return $result;
    }

}
