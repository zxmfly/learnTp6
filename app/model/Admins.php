<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/4/30
 * Time: 22:09
 */

namespace app\model;
use think\Model;

class Admins extends Model
{
    protected $table = 'admins';

    public static function updateAdmins($all){
        return Admins::where('id',$all['id'])->update($all);
    }

}