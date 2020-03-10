<?php
namespace app\controller;

use think\facade\Db;

class DbTest{
    public function demo1(){
        $sql = " select * from `user` WHERE age > :age limit :num";
        $map = ['age'=>20, 'num'=>2];
        $rs = Db::query($sql, $map);

        dump($rs);
    }
}