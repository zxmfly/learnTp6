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
        // 模板输出
        return View::fetch('index');
    }

}