<?php
/**
 * User: zengxianmao
 * Date: 2020/4/17
 * Time: 16:11
 */

namespace app\controller;

use app\model\Goods;
use think\facade\Db;
use think\facade\View;

class Test
{
    //使用模型操作数据库
    public function useModel(){
        $db = new Goods();
        $index = $db->getOne();
        dump($index->toArray());
        //$add = $db->addOne();
        //var_dump($add);
        //$up = $db->updateOne();
        //var_dump($up);

        var_dump($db->findStatus());


    }
    public function index(){
        $a= 100;
        $b = 101;
        $data = compact('a','b');
        View::assign($data);
        //模版函数 (自学)
        View::assign('time',1576048640);
        View::assign('num',10.0032);
        View::assign('str','OUyangKE');
        View::assign('arr',[
            '朱老师',
            '欧阳克',
            '西门大官人'
        ]);
        //循环标签

        $farr = [
            [
                'id' => 1,
                'name' => '欧阳克'
            ],
            [
                'id' => 2,
                'name' => '朱老师'
            ],
            [
                'id' => 3,
                'name' => '西门大官人'
            ]
        ];
        View::assign('farr',$farr);
        //if判断
        View::assign('status',1);
        View::assign('order_status',3);

        //调试：
        $select = Db::table('shop_goods')->where('id','>=',10)->select();
        echo Db::getLastSql();//方法只能获取最后执行的 SQL 记录

        //fetchSql 方法直接返回当前的 SQL 而不执行
        $select = Db::table('shop_goods')->fetchSql()->select();
        echo $select;

        //动态连接数据库
        $admin_user = Db::connect('sgzm_admin')->table('t_admin_user')->select()->toArray();
        dump($admin_user);

        return View::fetch();
        // 模板输出
        //return View::fetch('index');
    }

        /*
         *1、query 方法用于执行 MySql 查询操作
         *2、execute 方法用于执行 MySql 新增和修改操作
         * */
    public function testdb(){

        $rs = Db::query("select * from shop_goods");
        dump($rs);
        //$execute = Db::execute("INSERT INTO `shop_goods` VALUES (3, 1, '2019秋冬新款时尚简约纯羊绒加厚圆领羊绒长裙显瘦气质连衣裙女', 1179.00, 0, 200, 1, 1576080000)");
        //print_r($execute);
        //$execute = Db::execute("UPDATE `shop_goods` set `price`='1100' where `id`=3 ");
        //print_r($execute);

        //1、单条数据查询 find
        //$find = Db::table('shop_goods')->find(2);
        //$find = Db::table('shop_goods')->where('id', 1)->find();
        //dump($find);
        //Db::table('shop_goods')->where('id', 1)->findOrFail();//查询不存在，抛出异常
        //Db::table('think_user')->where('id', 1)->findOrEmpty();//查询

        //2、多条数据查询 select 方法查询结果是一个数据集对象，如果需要转换为数组可以使用
        $select = Db::table('shop_goods')->where('status', 1)->select();
        dump ($select->all());
        if($select->isEmpty()){//$select 是对象，提供判断方法
            echo "数据为空";
        }
        $select = Db::table('shop_goods')->where('status', 1)->select()->toArray();//直接转换成数组

        //如果设置了数据表前缀参数的话，可以使用

        $sql = Db::name('goods')->where('id', 1)->find();
        var_dump($sql);
        $sql = Db::name('goods')->where('status', 1)->where('id', '>',25)->select();
        var_dump($sql);

        //3、值和列查询 返回某个字段的值
        Db::table('shop_goods')->where('id', 1)->value('title');

        //查询某一列的值可以用
        // 返回数组
        Db::table('shop_goods')->where('status',1)->column('title');
        // 指定id字段的值作为索引
        Db::table('shop_goods')->where('status',1)->column('title', 'id');
        //如果要返回完整数据，并且添加一个索引值的话，可以使用
        // 指定id字段的值作为索引 返回所有数据
        Db::table('shop_goods')->where('status',1)->column('*','id');


        //4数据添加
        //insert 方法添加数据成功返回添加成功的条数，通常情况返回 1
        $data = ['cat'=>'1','title'=>'日系小浪漫与温暖羊毛针织拼接网纱百褶中长收腰连衣裙','price'=>'1598.35','add_time'=>1576080000];
        //$insert = Db::table('shop_goods')->insert($data);

        //insertGetId 方法添加数据成功返回添加数据的自增主键
        $data = ['cat'=>'1','title'=>'针织毛衣连衣裙2019秋冬新款气质宽松羊毛长袖中长款休闲打底裙女','price'=>'690.00','add_time'=>1576080000];
        //$insert = Db::table('shop_goods')->insertGetId($data);

        //insertAll 方法添加数据成功返回添加成功的条数
        $data = [
            ['cat'=>'1','title'=>'秋冬加厚连衣裙女超长款宽松羊绒衫高领套头过膝毛衣百搭针织长裙','price'=>'658.00','add_time'=>1576080000],
            ['cat'=>'1','title'=>'2019新款秋冬慵懒风宽松毛衣针织连衣裙复古港味网红两件套','price'=>'408.00','add_time'=>1576080000],
            ['cat'=>'2','title'=>'男士长袖t恤秋季圆领黑白体恤T 纯色上衣服打底衫男装','price'=>'99.00','add_time'=>1576080000]
        ];
        //$insert = Db::table('shop_goods')->insertAll($data);


        //5、修改
        //修改数据 update
        $data = ['price'=>'68'];
        $update = Db::table('shop_goods')->where('id',8)->update($data);
        //inc 方法自增一个字段的值
        $inc = Db::table('shop_goods')->where('id',5)->inc('stock')->update();//+1
        print_r($inc);
        # 字段的值增加5
        $inc = Db::table('shop_goods')->where('id',6)->inc('stock',5)->update();//+N

        //dec 方法自减一个字段的值
        $dec = Db::table('shop_goods')->where('id',7)->dec('stock')->update();// -1
        print_r($dec);
        # 字段的值减去5
        $dec = Db::table('shop_goods')->where('id',8)->dec('stock',5)->update();// -N

        //6、删除
        # 根据条件删除数据
        //$delete = Db::table('shop_goods')->where('id',1)->delete();
        # 删除主键为2的数据
        //$delete = Db::table('shop_goods')->delete(2);
        # 删除整表数据
        //$delete = Db::table('shop_goods')->delete(true);

        //2、软删除 useSoftDelete 业务数据不建议真实删除数据，TP系统提供了软删除机制
        # 软删除
        $delete = Db::table('shop_goods')->useSoftDelete('status',3)->delete(2);
        //相当update status = 3 where id=2

        //7、save 操作
        //save 方法统一写入数据，自动判断是新增还是更新数据（以写入数据中是否存在主键数据为依据）。
        # 添加数据
        $data = ['cat'=>'2','title'=>'美特斯邦威七分牛仔裤女2018夏季新款中腰修身洗水牛仔裤商场款','price'=>'49.90','add_time'=>1576080000];
        $save = Db::table('shop_goods')->save($data);
        print_r($save);
        # 修改数据
        $data = ['price'=>'99.00','id'=>25];
        $save = Db::table('shop_goods')->save($data);
        print_r($save);

        return View::fetch();
    }

}