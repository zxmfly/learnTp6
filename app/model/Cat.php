<?php
/**
 * User: zengxianmao
 * Date: 2020/4/27
 * Time: 16:56
 */

namespace app\model;


use think\Model;

class Cat extends Model
{
    public static function getAll(){
        $cat = Cat::where('status', 1)->select()->toArray();
        foreach ($cat as $key => $value) {
            $catArr[$value['id']] = $value['name'];
        }
        return $catArr;
    }
}