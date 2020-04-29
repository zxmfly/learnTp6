<?php
/**
 * User: zengxianmao
 * Date: 2020/4/28
 * Time: 12:01
 */

namespace app\controller;


use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Login extends BaseController
{
    /**
     * @return array
     */
    public function index()
    {
        View::assign([
            'title' => '登录',
        ]);
        return View::fetch('login');
    }

    public function login(){
        $all = Request::param();
        if(empty($all['username'])){
            rs_json(1,'用户名不能为空');
        }
        if(empty($all['password'])){
            rs_json(1,'密码不能为空');
        }
        if(empty($all['captcha_code'])){
            rs_json(1,'验证码不能为空');
        }
        if(!captcha_check($all['captcha_code'])){
            rs_json(1,'验证码错误');
        }

        echo json_encode(['data'=>$all,'code'=>1,'msg'=>'登录成功']);
    }
}