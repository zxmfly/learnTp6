<?php
/**
 * User: zengxianmao
 * Date: 2020/4/17
 * Time: 16:11
 */

namespace app\controller;

use think\facade\View;

class Test
{

    public function index(){
        $a= 100;
        $b = 101;
        $data = compact('a','b');
        View::assign($data);
        //模版函数 (自学)
        View::assign('time',1576048640);
        View::assign('num',10.0032);
        View::assign('str','OUyangKE');
        View::assign('arr',[
            '朱老师',
            '欧阳克',
            '西门大官人'
        ]);
        //循环标签

        $farr = [
            [
                'id' => 1,
                'name' => '欧阳克'
            ],
            [
                'id' => 2,
                'name' => '朱老师'
            ],
            [
                'id' => 3,
                'name' => '西门大官人'
            ]
        ];
        View::assign('farr',$farr);
        //if判断
        View::assign('status',1);
        View::assign('order_status',3);

        return View::fetch();
        // 模板输出
        //return View::fetch('index');
    }

}