<?php
namespace Application;

/**
 * Description of BaseService
 *
 * @author liuxuchao
 */
abstract class BaseService
{
    protected $model;
    
    public function __construct()
    {
        $this->setModel();
    }
    
    /**
     * 设置当前model
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-14 11:01
     */
    abstract public function setModel($model=null);
    
    /**
     * 添加单条数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-14 11:02
     * @param array $data 数据
     * @return boolean | int
     */
    public function add($data)
    {
        if ( empty($data) || !is_array($data) ) {
            return false;
        }
        
        return $this->model->add($data);
    }
    
    /**
     * 批量添加数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-03 16:22
     * @param array $dataList 数据列表
     * @return boolean | int
     */
    public function addAll($dataList)
    {
        if ( empty($dataList) || !is_array($dataList) ) {
            return false;
        }
        return $this->model->addAll($dataList);
    }
    
    /**
     * 根据主键更新数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-18 14:38
     * @param int $primaryKey 主键
     * @param array $data 要更新的数据数组，key => value 形式。
     * @return boolean | int
     */
    public function updateByPrimaryKey($primaryKey, $data)
    {
        $primaryKey = intval($primaryKey);
        if ( 0 >= $primaryKey || empty($data) || !is_array($data) ) {
            return false;
        }
        
        $updateResult = $this->model->updateByPrimaryKey($primaryKey, $data);
        return $updateResult;
    }
    
    /**
     * 获取列表
     */
    public function getList($where,$page=1,$pageSize=10,$fields,$orderBy)
    {
        $data = $this->model->getList($where,$page,$pageSize,$fields,$orderBy);
        return $data;
    }

    /**
     * 根据主键列表获取数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-21 16:06
     * @param array $primaryKeyList 主键列表
     * @return bool | array
     */
    public function getListByPrimaryKeyList($primaryKeyList,$fields=[])
    {
        if ( empty($primaryKeyList) || !is_array($primaryKeyList) ) {
            return false;
        }

        $data = $this->model->getListByPrimaryKeyList($primaryKeyList,$fields);
        return $data;
    }
    
    
    /**
     * 根据主键读取数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-22 17:45
     * @param int $primaryKey 主键
     * @return boolean | array
     */
    public function getByPrimaryKey($primaryKey)
    {
        $primaryKey = intval($primaryKey);
        if ( 0 >= $primaryKey ) {
            return false;
        }
        
        $data = $this->model->getByPrimaryKey($primaryKey);
        return $data;
    }
    
    /**
     * 发送post请求
     * @author 刘徐超  <liuxuchao@liuxuchaozhao.com>
     * @data          2016-10-12T10:53:47+0800
     * @param  [type] $url                     请求接口地址
     * @param  [type] $data                  请求参数
     * @return  array|bool                      
     */
    public function sendPost($url, $data)
    {
        if(empty($data) || $data == null){
            return false ;
        }
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url);
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        return json_decode($return,true);
    }
    /**
     * *
     * 根据条件获取所有数据
     * @AuthorHTL 刘旭超<zhengziqiang@liuxuchaota.com>
     * @DateTime  2016-10-14T12:44:41+0800
     * @param     array  $map 
     * @return    array   
     */
    public function getAll($field)
    {

        return $this->model->getAll($field);
    }
    
    /**
     * 批量添加数据，当重复时更新。
     * 例：INSERT INTO TABLE (a,c) VALUES (1,3),(1,7) ON DUPLICATE KEY UPDATE c=c+1;
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-12-06 17:08
     * @param array $dataList 数据列表
     * @return boolean | int
     */
    public function addAllOnDuplicate($dataList)
    {
        if ( empty($dataList) ) {
            return false;
        }
        
        $result = $this->model->addAllOnDuplicate($dataList);
        return $result;
    }
    
    /**
     * 添加数据，当重复时更新。
     * 例：INSERT INTO TABLE (a,c) VALUES (1,3),(1,7) ON DUPLICATE KEY UPDATE c=c+1;
     * @param array $data 新数据
     * @return boolean | int
     */
    public function addOnDuplicate( $data )
    {
        if ( empty($data) ) {
            return false;
        }
        
        $result = $this->model->addOnDuplicate($data);
        return $result;
    }
    
    /**
     * 插入数据，当重复时忽略。
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-12 19:26
     * @param type $data
     * @return boolean | int
     */
    public function addDuplicateIgnore($data)
    {
        if ( empty($data) ) {
            return false;
        }
        
        return $this->model->addDuplicateIgnore($data);
    }
    
    /**
     * 批量插入数据，当重复时忽略。
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2017-01-12 19:26
     * @param type $data
     * @return boolean | int
     */
    public function addAllDuplicateIgnore($data)
    {
        if ( empty($data) ) {
            return false;
        }
        
        return $this->model->addAllDuplicateIgnore($data);
    }
    
    /**
     * 根据主键删除数据
     * @author 刘徐超 <liuxuhcao@liuxuchaozhao.com>
     * @date 2016-09-12 11:45
     * @param int $primaryKey 主键
     * @return boolean | array
     */
    public function deleteByPrimaryKey($primaryKey)
    {
        $primaryKey = intval($primaryKey);
        if ( 0 >= $primaryKey ) {
            return false;
        }
        
        $data = $this->model->deleteByPrimaryKey($primaryKey);
        return $data;
    }
    
    /**
     * 根据条件查找数据，支持翻页。
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-12-14 13:34
     * @param mixt $condition 查询条件数组或者条件字符串
     * @param string $order 排序规则
     * @param int $page 页数
     * @param int $pageSize 每页数据量
     */
    public function getByCondition_Page($condition, $order, $page, $pageSize)
    {
        $data = $this->model->getByCondition_Page($condition, $order, $page, $pageSize);
        return $data;
    }
    
    /**
     * 根据条件统计数量
     * @param mixt $condition 统计条件
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-12-13 16:40
     * @return int
     */
    public function countByCondition($condition=null)
    {
        $total = $this->model->countByCondition($condition);
        return $total;
    }
    
    /**
     * 如果数据存在就更新数据
     * @date 2017年1月5日21:35:54
     *  [
     *      'multi' => false, //是否是批量更新
     *      'upsert' => false, //数据不存在时是否插入
     * ]
     * @author 刘旭超 zhengziqiang@liuxuchaota.com
     * @param [type] $data [description]
     */
    public function addCompanyDataUpData($data,$option) 
    {
        if (empty($data) || !is_array($data)) {
            return  ;
        }

        return $this->model->update($data,$option);

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
    public function upsert($condition, $data, $option)
    {
        $result = $this->model->upsert($condition, $data, $option);
        return $result;
    }
    
    public function getLastSql()
    {
        return $this->model->getLastSql();
    }

}
