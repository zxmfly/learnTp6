<?php
namespace app\controller;

use think\facade\Db;

class DbTest{
    public function demo1(){
        $sql = " select * from `user` WHERE age > :age limit :num";
        $map = ['age'=>20, 'num'=>2];
        $rs = Db::query($sql, $map);
        //test
        dump($rs);
    }

    public function demo2(){//execute()
        $sql = " update `user` set age = :age WHERE  user_id = :uid ";
        $map = ['age'=>18, 'uid'=> 1];
        $rs = Db::execute($sql, $map);//返回成功执行的行数
        //test
        dump($rs);
    }
    /*
     * table() 设置表
     * field() 查下的字段
     * find（）返回第一条记录,必须带有条件或者order 或者传入主键值 否则返回Null 你必须明确要查询什么数据
     * */
    public function demo3(){
        $rs = Db::name('user')
            ->field('*')
            //->where('user_id','<>',1)
            ->find(3);
        echo  Db::name('user')->getLastSql();//输出sql
        dump($rs);
    }
}