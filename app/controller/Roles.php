<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/9
 * Time: 22:50
 */

namespace app\controller;

use app\model\AdminMenu;
use app\model\Group;
use think\facade\Request;
use think\facade\View;

class Roles extends BaseAdmin
{
    public function index(){
        $title = "角色列表";
        $groups = Group::select()->toArray();


        $data = compact('title','groups');
        View::assign($data);
        return View::fetch();
    }

    public function add()
    {
        $title = "角色列表";
        $menu_list = AdminMenu::where('status', 0)->select()->toArray();
        foreach ($menu_list as $row) {
            $menus[$row['mid']] = $row;
        }
        $menus = $this->gettreeitems($menus);
        dump($menus);
        $data = compact('title', 'menus');
        View::assign($data);
        return View::fetch();
    }
    private function gettreeitems($items){//采用引用的方式比递归快
        $tree = array();
        foreach ($items as $item) {
            if(isset($items[$item['pid']])){
                $items[$item['pid']]['children'][] = &$items[$item['mid']];//引用赋值的方式
            }else{
                $tree[] = &$items[$item['mid']];//引用赋值的方式
            }
        }
        return $tree;
    }
}