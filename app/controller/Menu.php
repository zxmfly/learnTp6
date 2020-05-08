<?php
/**
 * User: zengxianmao
 * Date: 2020/5/8
 * Time: 11:23
 */

namespace app\controller;

use think\facade\Request;
use think\facade\View;
use app\model\AdminMenu;

class Menu extends BaseAdmin
{
    public function index(){
        $pid = Request::param('pid');
        $pid = intval($pid);
        $title = "菜单列表";
        $menus = AdminMenu::where('pid', $pid)->select()->toarray();

        $back_id = 0;
        if($pid > 0){
            $menu = AdminMenu::where('mid', $pid)->find();
            $back_id = $menu['pid'];
        }

        $data = compact('title','menus', 'back_id', 'pid');
        View::assign($data);
        return View::fetch();
    }
}