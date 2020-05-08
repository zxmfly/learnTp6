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

    public function save(){
        $post = Request::param();
        $pid = $post['pid'];
        $ords = $post['ord'];
        $titles = $post['title'];
        $ctls = $post['controller'];
        $methods = $post['method'];
        $ishs = isset($post['ishidden']) ? $post['ishidden'] : [];
        $sts = isset($post['status']) ? $post['status'] : [];
        foreach ($ords as $key => $val){
            $data = [];
            $data['ord'] = $val;
            $data['title'] = $titles[$key];
            $data['controller'] = $ctls[$key];
            $data['method'] = $methods[$key];
            $data['ishidden'] = isset($ishs[$key]) ? 1 : 0;
            $data['status'] = isset($sts[$key]) ? 1 : 0;
            $data['pid'] = $pid;

            if($key == 0 && $data['title']){
                if($pid > 0){
                    if($data['controller'] == '') {
                        continue;
                    }
                    if($data['method'] == '') $data['method'] = 'index';
                }
                AdminMenu::create($data);
            }

            if($key > 0){
                if($data['title'] == ''){
                    $delete = AdminMenu::destroy($key);
                    AdminMenu::where('pid',$key)->delete();
                }elseif($data['controller'] == ''){
                    continue;
                }
                if($data['method'] == '') $data['method'] = 'index';
                $data['mid'] = $key;
                $menu = AdminMenu::updateAdminMenu($data);
            }
        }
        echo json_encode(['code'=>0,'msg'=>'保存成功']);
    }
}