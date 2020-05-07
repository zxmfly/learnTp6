<?php
/**
 * User: zengxianmao
 * Date: 2020/5/7
 * Time: 16:05
 */

namespace app\model;


use think\Model;

class Group extends Model
{
    protected $table = 'admin_groups';
    protected $pk = 'gid';

    public static function getGroupsName(){
        $goups = Group::select()->toArray();
        $data = [];
        foreach ($goups as $row){
            $data[$row['gid']] = $row['title'];
        }

        return $data;
    }
}