<?php
namespace Application;

use Think\Model;

/**
 * model基类
 *
 * @author liuxuchao
 */
abstract class BaseModel extends Model
{
    /**
     * 数据库连接配置
     * @var string 
     */
    protected $connection = '';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 添加单条数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-14
     * @param type $data
     * @return boolean
     */
    public function add($data)
    {
        if ( empty($data) || !is_array($data) ) {
            return false;
        }
        $result = parent::add($data);
        return $result;
    }
    
    /**
     * 批量添加数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-08-03 16:22
     * @param array $dataList 数据列表
     * @return boolean | int
     */
    public function addAll($dataList,$options=array(),$replace=false)
    {
        if ( empty($dataList) || !is_array($dataList) ) {
            return false;
        } 
        $result = parent::addAll($dataList,array(),$replace);
        return $result;
    }
    
    /**
     * 以replace的方式添加数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-14 15:37
     * @param array $data 数据
     * @param array $options 选项
     * @return boolean | int
     */
    public function replace($data, $options=array())
    {
        if ( empty($data) || !is_array($data) ) {
            return false;
        }
        
        $result = parent::add($data, $options, true);
        return $result;
    }
    
    /**
     * 根据主键删除数据，删除单条。
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-06-14 15:59
     * @param int $primaryKey 主键的值
     * @return boolean | int
     */
    public function deleteByPrimaryKey( $primaryKey )
    {
        $primaryKey = intval($primaryKey);
        if ( 0 >= $primaryKey ) {
            return false;
        }
        
        $result = parent::delete($primaryKey);
        return $result;
    }
    
    /**
     * 根据主键获取数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-18 12:25
     * @param int $primaryKey 主键的值
     * @return boolean | array
     */
    public function getByPrimaryKey( $primaryKey )
    {
        $primaryKey = intval($primaryKey);
        if ( 0 >= $primaryKey ) {
            return false;
        }
        
        $data = parent::find($primaryKey);
        return $data;
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
        
        $where = [$this->pk => $primaryKey];
        $result = parent::where($where)->save($data);
        return $result;
    }
     /**
     * 获取列表
     */
    public function getList($where,$page=1,$pageSize=10,$fields=[],$orderBy='')
    {
        if($fields){
            $this->field($fields);
        }
        $offset = ($page - 1) * $pageSize;
        if($orderBy){
          $this->order($orderBy);  
        }
        if($where){
            $this->where($where);
        }
        $data = $this->limit($offset, $pageSize)->select();
        return $data;
    }
    /**
     * 根据主键列表获取数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-21 16:06
     * @param array $primaryKeyList 主键列表
     * @return bool | array
     */
    public function getListByPrimaryKeyList($primaryKeyList, $fields=[])
    {
        if ( empty($primaryKeyList) || !is_array($primaryKeyList) ) {
            return false;
        }
        if($fields){
            $this->field($fields);
        }
        $where = "{$this->pk} IN ('" . implode("','", $primaryKeyList) . "')";
        $data = parent::where($where)->select();
        return $data;
    }
    
    /**
     * 获取全部数据
     * @author 刘旭超 <liuxuchao126@126.com>
     * @date 2016-07-22 11:37
     * @return bool | array 
     */
    public function getAll($field)
    {
        $data = $this->field($field)->select();
        return $data;
    }
    
    /**
     * 兼容分页
     * @AuthorHTL 刘旭超<zhengziqiang@liuxuchaota.com>
     * @DateTime  2016-11-23T18:07:04+0800
     * @param     int    $sizeCount [总条数]
     * @param     int    $pageNum   [每页显示多少条]
     * @return    string 
     */
    protected function formatPage($sizeCount,$pageNum)
    {
        $Page = new \Think\Page($sizeCount,$pageNum);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        return str_replace(['.','html','php'], '', $show);
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
        
        $columns = array_keys($dataList[0]);
        $sql = "INSERT INTO {$this->trueTableName} (" . implode(',', $columns) . ") VALUES ";
        foreach ($dataList as $data) {
            $sql .= '(';
            foreach ( $columns as $column ) {
                $value = isset($data[$column]) ? $data[$column] : NULL;
                $sql .= "'{$value}',";
            }
            $sql = trim($sql, ',');
            $sql .= '),';
        }
        $sql = trim($sql, ',');
        $sql .= " ON DUPLICATE KEY UPDATE ";
        foreach ( $columns as $column ) {
            $sql .= "{$column}=VALUES({$column}),";
        }
        $sql = trim($sql, ',');
        $executeResult = $this->execute($sql);
        return $executeResult;
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
        
        $columns = array_keys($data);
        $sql = "INSERT INTO {$this->trueTableName} (" . implode(',', $columns) . ") VALUES (";
        foreach ( $columns as $column ) {
            $sql .= "'{$data[$column]}',";
        }
        $sql = rtrim($sql, ',');
        $sql .= ")";
        $sql .= " ON DUPLICATE KEY UPDATE ";
        foreach ( $columns as $column ) {
            $sql .= "{$column}=VALUES({$column}),";
        }
        $sql = trim($sql, ',');
        $executeResult = $this->execute($sql);
        return $executeResult;
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
        
        $columns = array_keys($data);
        $sql = "INSERT IGNORE INTO {$this->trueTableName} (" . implode(',', $columns) . ") VALUES (";
        foreach ( $columns as $column ) {
            $sql .= "'{$data[$column]}',";
        }
        $sql = rtrim($sql, ',');
        $sql .= ")";
        return $this->execute($sql);
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
        
        $columns = array_keys($data[0]);
        $sql = "INSERT IGNORE INTO {$this->trueTableName} (" . implode(',', $columns) . ") VALUES ";
        foreach ( $data as $value ) {
            $sql .= '(';
            foreach ($columns as $col) {
                $sql .= "'{$value[$col]}',";
            }
            $sql = rtrim($sql, ',');
            $sql .= '),';
        }
        $sql = rtrim($sql, ',');
        return $this->execute($sql);
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
        $offset = ($page - 1) * $pageSize;
        if ( !empty($condition) ) {
            $data = $this->where($condition)->order($order)->limit($offset, $pageSize)->select();
        } else {
            $data = $this->order($order)->limit($offset, $pageSize)->select();
        }
        
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
        if ( !empty($condition) ) {
            $total = $this->where($condition)->count();
        } else {
            $total = $this->count();
        }
        
        return $total;
    }
}
