<?php
/**
 * Created by PhpStorm.
 * User: zxmfly
 * Date: 2020/5/1
 * Time: 11:37
 */

namespace app\controller;


use app\BaseController;
use app\model\Admins;
use think\App;
use think\facade\Session;

class BaseAdmin extends BaseController
{
    public $learntTpAdmin;
    public $_admin;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->learntTpAdmin = Session::get('learnTpAdmin');
        $this->_admin = Admins::where('username', $this->learntTpAdmin)->find();
        if(empty($this->learntTpAdmin)){
            header('location:/login');
            exit;
        }
    }

    //判断权限

    public function loginOut(){
        Session::clear();
        return redirect('/login');
    }
}