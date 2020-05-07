<?php
namespace app\controller;

use app\model\Admins;
use app\model\Group;
use think\facade\Request;
use think\facade\View;

class Admin extends BaseAdmin
{
    public function index(){
        $title = "管理员列表";
        $admin = Admins::select()->toArray();
        $groups = Group::getGroupsName();

        $data = compact('admin','title','groups');
        View::assign($data);
        return View::fetch();
    }

    public function add(){
        if(Request::method() == 'POST'){
            $data = Request::param();
            $admins = Admins::where('username', $data['username'])->whereOr('truename', $data['truename'])->find();
            if($admins){
                echo json_encode(['code'=>1,'msg'=>'添加失败,该用户已存在']);
                return;
            }
            $data['add_time'] = time();
            $data['password'] = md5($data['username'].$data['password']);
            $insert = Admins::insert($data);
            if($insert){
                echo json_encode(['code'=>0,'msg'=>'添加成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'添加失败']);
            }
            return;
        }
        $title = "添加管理员";
        $groups = Group::select()->toArray();

        $data = compact('title','groups');
        View::assign($data);
        return View::fetch();
    }

    public function edit(){
        if(Request::method() == 'POST'){
            $data = Request::param();
            if($data['password'])
                $data['password'] = md5($data['username'].$data['password']);
            $update = Admins::updateAdmins($data);
            if($update){
                echo json_encode(['code'=>0,'msg'=>'修改成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'修改失败']);
            }
            return;
        }elseif (Request::param('id')) {
            $title = "修改管理员";
            $admins = Admins::where('id',Request::param('id'))->find();
            $groups = Group::getGroupsName();

            $data = compact('title', 'admins', 'groups');
            View::assign($data);
            return View::fetch();
        }
    }

    public function del(){
        $id = Request::param('id');
        if($id) {
            $delete = Admins::destroy($id);
            //$delete = Admins::useSoftDelete('status',3)->delete($id);
            if($delete){
                echo json_encode(['code'=>0,'msg'=>'删除成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'删除失败']);
            }
        }else{
            echo json_encode(['code'=>1,'msg'=>'操作有误']);
        }
    }

}