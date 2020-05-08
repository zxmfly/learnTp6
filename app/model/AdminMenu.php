<?php
/**
 * User: zengxianmao
 * Date: 2020/4/27
 * Time: 16:07
 */

namespace app\model;


use think\Model;

class AdminMenu extends Model
{   protected $table = 'admin_menus';
    protected $pk = 'mid';

    public static function getAll(){
        $menu = self::getMenuByfid();
        foreach ($menu as &$row){
            $row['lists'] = self::getMenuByfid($row['mid']);
        }
        return $menu;
    }

    public static function getMenuByfid($fid = 0){
        return AdminMenu::where('pid', $fid)->select()->toArray();
    }

    public static function updateAdminMenu($all){
        return AdminMenu::where('mid',$all['mid'])->update($all);
    }

}