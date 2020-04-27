<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/4/26
 * Time: 22:08
 */
namespace app\model;
use think\Model;

class Goods extends Model
{
    /*
     * name	模型名（相当于不带数据表前后缀的表名，默认为当前模型类名）
       table	数据表名（默认自动获取）
        suffix	数据表后缀（默认为空）
        pk	主键名（默认为id）
        connection	数据库连接（默认读取数据库配置）
        query	模型使用的查询类名称
        field	模型允许写入的字段列表（数组）
        schema	模型对应数据表字段及类型
        type	模型需要自动转换的字段及类型
        strict	是否严格区分字段大小写（默认为true）
        disuse	数据表废弃字段（数组）
    // 设置字段信息
*/
    protected $name = 'Goods';
    protected $table = 'shop_goods';
    protected $pk = 'id';
    protected $schema = [
        'id' => 'int',
        'cat' => 'int',
        'title' => 'string',
        'price' => 'float',
        'discount' => 'int',
        'stock' => 'int',
        'status' => 'int',
        'add_time' => 'int'
    ];
    # 对某个字段定义需要自动转换的类型，可以使用type属性
    protected $type = [
        'shop_id' => 'int'
    ];
    protected $disuse = [//废弃的字段，查询自动过滤
        'discount',
        'stock'
    ];

    /*1、获取器
    获取器的作用是对模型实例的（原始）数据做出自动处理
    命名规则：get + 字段名 + Attr
    字段名是数据表字段的驼峰转换*/
    public function findStatus(){
        $find = Goods::find(2);
        echo $find->status;//自动转换处理
        return $find->toArray();
    }
    public function getStatusAttr($v){//自动转换处理
        $status = [
            1=>'开启',
            2=>'关闭',
            3=>'删除'
        ];
        return $status[$v];
    }

    /*2、修改器
    修改器的主要作用是对模型设置的数据对象值进行处理
    命名规则： set + 字段名 + Attr*/

    public function setAdd(){
        $create = Goods::create([
            'cat' =>  3.33,//自动对cat进行int转换
            'title' =>  '新商品',
            'price' =>  '59.99',
            'add_time' => time()
        ]);
        return $create;
    }
    public function setCatAttr($v, $all){
        // $all 全部参数,cat,title,price,add_time
        return (int)$v;
    }

    /*3、搜索器
    搜索器的作用是用于封装字段（或者搜索标识）的查询条件表达式
    命名规则： search + 字段名 + Attr*/

    public function searchAction(){
        //withSearch([搜索器的名字]，[搜索器的值])
        $select = Goods::withSearch(['title'],[
            'title' => '新'
        ])->select();
        return $select->toArray();
    }
    public function searchTitleAttr($query, $v){
        //$query tp Db类对象，可以直接使用链式操作进行修改
        $query->where('title','like', $v . '%');
    }

    /*4、检查数据
    如果要判断数据集是否为空，不能直接使用 empty 判断
    必须使用数据集对象的 isEmpty 方法判断 */
    public function checkAction(){
        $select = Goods::where('title','1')->select();
        if(empty($select)){
            echo 111;
        }
        if($select->isEmpty()){
            echo 111;
        }
    }

    //模型里面增删查改返回的都是对象
    public function getOne($id = 0)
    {
        //数据库的所有操作，再模型中都能使用
        $find = Goods::select();
        if($id){
            $find = Goods::find($id);
        }
        // $find = Goods::where('id',20)->find();
        //$find->toArray();//toArray(),
        return $find;
    }

    public function addOne()
    {//新增数据的最佳实践原则：使用create方法新增数据，使用saveAll批量新增数据。
        /* create方法默认会过滤不是数据表的字段信息，可以在第二个参数可以传入允许写入的字段列表，例如：
         // 只允许写入name和email字段的数据
         $user = User::create([
             'name'  =>  'thinkphp',
             'email' =>  'thinkphp@qq.com'
         ], ['name', 'email']);*/

        $create = Goods::create([
            'cat' => 3,
            'title' => '新商品',
            'price' => '59.99',
            'add_time' => time()
        ]);
        echo $create->id;  // 可以直接获取自增id
        return $create;
    }
    //update 静态方法修改数据，返回的是当前模型的对象实例
    //save 在取出数据后，更改字段更新数据。这种方式是最佳的更新方式
    public function updateOne()
    {
        # 更新方式1
        $update = Goods::update(
            ['price' => '99.99'],
            ['id' => 28]
        );

        # 更新方式2
        $user = Goods::getOne(29);
        $user->price = '102.99';
        $save = $user->save();

        return $save;
    }

    //delete 静态方法删除数据，返回的是当前模型的对象实例
    //destroy 根据主键删除
    public function del(){
        # 删除方法1
        $delete = Goods::where('id',3)->delete();
        # 删除方法2
        $delete = User::destroy(4);
        return $delete;
    }
}