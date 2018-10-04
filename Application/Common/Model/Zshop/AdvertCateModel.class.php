<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of OrderModel订单
 *
 * @author caizhuan  <zhuan1127@163.com>
 */
class AdvertCateModel extends BaseModel
{
    
    /**
     * 数据库连接配置
     * @var string
     */
    protected $connection = 'ZSHOP_DB';
    
    /**
     * 主键字段名称
     * @var string 
     */
    protected $pk = 'id';
    
    /**
     * 实际数据表名（包含表前缀）
     * @var string 
     */
    protected $trueTableName = 'zs_ad_category';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'name',
        'fid',
        'create_time',
        'has_child',
        'arr_childid',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }    


    /**
     * [gettree 获取栏目树]
     * @param  integer $p  [description]
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function gettree($p = 0, $lv = 0)
    {
        //定一个数组变量
        $t = [];
        //循环读取                            
        foreach ($this->select() as $k => $v) {
            //判断谁的父栏目等于0      
            if ($v['fid'] == $p) {
                $v['lv'] = $lv;
                //然后把（整条）数据放到 $t
                $t[] = $v;
                //检查   查出一个数据放到$t  +   递归开始                         
                $t = array_merge($t, $this->gettree($v['id'], $lv + 1));
            }
        }

        return $t;
    }


    /**
     * [findByName 根据字符串查找商品分类是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function findByName($name)
    {
        $where = [];
        $where['name'] = $name;
        $result = $this->where($where)->find();
        return $result;   
    }


    /**
     * [findByName 根据字符串查找商品分类是否存在]
     * @param  [string] $name [description]
     * @return [boole]       [description]
     */
    public function findChildCateById($id)
    {
        $where = [];
        $where['id'] = $id;
        $where['has_child'] = 1;
        $result = $this->where($where)->find();
        return $result ? true : false;   
    }


    /**
     * 根据类ID 删除操作
     * @author liuxuchao
     * @param string $catId 分类ID
     * @return array | boolean
     */
    public function doDelete($catid)
    {
        $catId = intval( $catid );
        if ( 0 >= $catId) {
            return false;
        }
        $where['id'] = $catId;
        $data = $this->where($where)->delete();
        if ( $data ) {
            return $data;
        }
        return false;
    }




}

