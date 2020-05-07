<?php
namespace app\controller;

use app\model\Cat;
use app\model\AdminMenu;
use app\model\Goods;
use app\model\Menu;
use think\facade\Request;
use think\facade\View;

class Index extends BaseAdmin
{
    //仿爱奇艺视频网站学习
    public function home(){
        $title = '商城管理系统';
        $login = $this->learntTpAdmin;
        $left = AdminMenu::getAll();


        $data = compact('title','login','left');
        View::assign($data);
        return View::fetch();
    }

    public function welcome(){
        return View::fetch();
    }

    //tp6正式版学习
    public function index()
    {
        $title = '商城';
        $login = $this->learntTpAdmin;
        $limit = 3;
        $left = Menu::getAll();

        $all = Request::param();
        $status = isset($all['status']) ? $all['status'] : 0;
        $where = $status > 0 ? ['status'=>$status] : true;
        $count = Goods::getCount($where);

        $p = isset($all['p']) ? $all['p'] : 1;
        $limit = isset($all['limit']) ? $all['limit'] : $limit;
        $right = Goods::getAll($where, $p, $limit);
        $cat = Cat::getAll();

        View::assign([
            'cat' => $cat,
            'title'  => $title,
            'login' => $login,
            'left' => $left,
            'right' => $right,
            'status' => $status,
            'limit' => $limit,
            'count' => $count,
            'p'=>$p,
        ]);
        return View::fetch();
    }

    public function edit(){
        if(Request::method() == 'POST'){
            $all = Request::param();
            $update = Goods::updateGoods($all);
            if($update){
                echo json_encode(['code'=>0,'msg'=>'修改成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'修改失败']);
            }
        }elseif (Request::method() == 'GET') {
            $id = Request::param('id');
            $shop = Goods::find($id);
            $cat = Cat::getAll();
            View::assign([
                'cat' => $cat,
                'title'  => '修改',
                'shop' => $shop,
            ]);
            return View::fetch();
        }else{
            echo "您的操作有误";
        }
    }

    public function add(){

        if(Request::method() == 'POST'){
            $data = Request::param();
            $data['add_time'] = time();
            $insert = Goods::insert($data);
            if($insert){
                echo json_encode(['code'=>0,'msg'=>'添加成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'添加失败']);
            }
        }else {
            $cat = Cat::getAll();
            View::assign([
                'cat' => $cat,
                'title'  => '修改',
            ]);
            return View::fetch();
        }
    }

    public function del(){
        $id = Request::param('id');
        if($id) {
           // $delete = Db::table('shop_goods')->delete($id);
            $delete = Goods::useSoftDelete('status',3)->delete($id);
            if($delete){
                echo json_encode(['code'=>0,'msg'=>'删除成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'删除失败']);
            }
        }else{
            echo json_encode(['code'=>1,'msg'=>'操作有误']);
        }
    }



    public function user()
    {
        return 'user';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
