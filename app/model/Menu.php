<?php
/**
 * User: zengxianmao
 * Date: 2020/4/27
 * Time: 16:07
 */

namespace app\model;


use think\Model;

class Menu extends Model
{
    public static function getAll(){
        $menu = self::getMenuByfid();
        foreach ($menu as &$row){
            $row['lists'] = self::getMenuByfid($row['id']);
        }
        return $menu;
    }

    public static function getMenuByfid($fid = 0){
        return Menu::where('fid', $fid)->select()->toArray();
    }
}