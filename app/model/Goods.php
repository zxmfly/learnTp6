<?php
/**
 * User: zengxianmao
 * Date: 2020/4/27
 * Time: 17:03
 */

namespace app\model;


use think\Model;

class Goods extends Model
{
    public static function getAll($where=true, $page, $limit){
        return Goods::where($where)->page($page, $limit)->select()->toArray();
    }

    public static function getCount($where=true){
        return Goods::where($where)->count();
    }

    public static function updateGoods($all){
       return Goods::where('id',$all['id'])->update($all);
    }

    public static function addGoods($all){
        return Goods::where('id',$all['id'])->update($all);
    }



}