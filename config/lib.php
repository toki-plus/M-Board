<?php

/**
 * PHP弹框提示
 * 传单个参数表示操作失败返回原来的页面
 * 传两个参数表示操作成功跳转到新的页面
 */
function alert($str, $url = "")
{
    if($url){
        echo "<script>alert('$str');location.href='$url';</script>";
    }else{
        echo "<script>alert('$str');window.history.back()</script>";
    }
    exit();
}
