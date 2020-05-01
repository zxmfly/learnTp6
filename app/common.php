<?php
// 应用公共文件
if(!function_exists('rs_json')){
    //code= 0 成功，>0失败
    function rs_json($code = 0, $msg = '操作成功', $data=[], $is_exit = 1) : string
    {
        $rs = compact('code','msg', 'data');
        echo json_encode($rs);
        if($is_exit) {
            exit;
        }else{
            return json_encode($rs);
        }
    }
}