<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        $title = '商城';
        $login = '欧阳克';

        $left = Db::table('shop_menu')->where('fid', 0)->select()->toArray();
        $cat = Db::table('shop_cat')->where('status', 1)->select();
        foreach ($cat as $key => $value) {
            $catArr[$value['id']] = $value['name'];
        }
        foreach($left as &$val){
            $val['lists'] = Db::table('shop_menu')->where('fid', $val['id'])->select()->toArray();
        }
        $right = Db::table('shop_goods')->select()->toArray();
        View::assign([
            'title'  => $title,
            'login' => $login,
            'left' => $left,
            'right' => $right,
            'catArr' => $catArr
        ]);
        return View::fetch();
        //return View::fetch();
        //dump(Db::query("select * from `user` limit 1"));
    }

    public function edit(){
        if(Request::method() == 'POST'){
            $all = Request::param();
            $update = Db::table('shop_goods')->where('id',$all['id'])->update($all);
            if($update){
                echo json_encode(['code'=>0,'msg'=>'修改成功']);
            }else{
                echo json_encode(['code'=>1,'msg'=>'修改失败']);
            }
        }elseif (Request::method() == 'GET') {
            $id = Request::param('id');
            $shop = Db::table('shop_goods')->where('id', $id)->find();
            $cat = Db::table('shop_cat')->where('status', 1)->select();
            View::assign([
                'shop' => $shop,
                'cat' => $cat
            ]);
            return View::fetch();
        }else{
            echo "您的操作有误";
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
