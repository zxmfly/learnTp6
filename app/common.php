<?php
// 应用公共文件
if(!function_exists('rs_json')){
    //code= 0 成功，>0失败
    function rs_json($code = 0, $msg = '操作成功', $data=[], $is_exit = 1) : array
    {
        $rs = compact('code','msg', 'data');
        if($is_exit) {
            echo json_encode($rs);
            exit;
        }else{
            return json_encode($rs);
        }
    }
}