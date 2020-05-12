<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/9
 * Time: 22:50
 */

namespace app\controller;

use app\model\AdminMenu;
use app\model\Admins;
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
        $gid = Request::param('gid');
        $title = "角色列表";
        $role = [];
        if($gid > 0){
            $role = Group::where('gid',$gid)->find();
            $role && $role['rights']&& $role['rights'] = json_decode($role['rights'], 1);
        }
        $menu_list = AdminMenu::menuCates('mid');
        $menus = $this->gettreeitems($menu_list);
        $results = [];
        foreach ($menus as $value) {
            $value['children'] = isset($value['children']) ? $this->formatMenus($value['children']) : false;
            $results[] = $value;
        }
        $menus = $results;
        unset($results);
        $data = compact('title', 'menus', 'role');

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
    private function formatMenus($items, &$res = []){
        foreach($items as $item){
            if(!isset($item['children'])){
                $res[] = $item;
            }else{
                $tem = $item['children'];
                unset($item['children']);
                $res[] = $item;
                $this->formatMenus($tem,$res);
            }
        }
        return $res;
    }

    public function save(){
        $post = Request::param();
        $data['title'] = trim($post['title']);
        $menus = input('post.menu/a');//input助手函数/修饰符
        if(empty($data['title'])){
            echo json_encode(['code'=>1,'msg'=>'标题为空']);
            return;
        }
        $menus && $data['rights'] = json_encode(array_keys($menus));
        if(!intval($post['gid'])) {
            if (Group::where('title', $data['title'])->find()) {
                echo json_encode(['code' => 1, 'msg' => '角色名已存在']);
                return;
            }
            Group::insert($data);
        }else{
            $data['gid'] = $post['gid'];
            Group::updateGroups($data);
        }

        echo json_encode(['code'=>0,'msg'=>'保存成功']);
    }

    public function del(){
        $id = input('get.id');
        if(Admins::where('gid', $id)->find()){
            echo json_encode(['code'=>1,'msg'=>'角色在使用中，删除失败']);
            return;
        }
        Group::where('gid',$id)->delete();
        echo json_encode(['code'=>0,'msg'=>'删除成功']);
    }
}