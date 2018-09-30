<?php
namespace Common\Model\Zshop;

use Application\BaseModel;

/**
 * Description of ArticleCateModel
 *
 * @author 刘旭超  <liuxuchao@liuxuchaozhao.com>
 */
class ArticleCateModel extends BaseModel
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
    protected $trueTableName = 'zs_article_cate';
    
    /**
     * 数据表字段列表
     * @var array
     */
    protected $fields = [
        'id',
        'cate_name',
        'parent_id',
        'description',
        'cate_sort',
        'is_display',
        'create_time',
        'update_time',
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
    public function getTree($p = 0, $lv = 0)
    {
        //定一个数组变量
        $t = [];
        //循环读取                            
        foreach ($this->select() as $k => $v) {
            //判断谁的父栏目等于0      
            if ($v['parent_id'] == $p) {
                $v['lv'] = $lv;
                //然后把（整条）数据放到 $t
                $t[] = $v;
                //检查   查出一个数据放到$t  +   递归开始                         
                $t = array_merge($t, $this->getTree($v['id'], $lv + 1));
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
        $where['cate_name'] = $name;
        $result = $this->where($where)->find();
        return $result;   
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
}

