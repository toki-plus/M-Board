<?php
include("./config/init.php");
include("./config/lib.php");

if ($_POST) {
    // 上传图片后 验证登录
    if (!isset($_SESSION['user_info']) || empty($_SESSION['user_info'])) {
        alert("请登录后再上传图片！", "./login.php");
    }

    if ($_FILES['uploadfile']['error'] == 4) {
        alert("上传文件为空！");
    }

    if ($_FILES['uploadfile']['error'] != 0) {
        alert("上传失败！");
    }


    // 上传的文件名
    $upload_filename = $_FILES['uploadfile']['name'];
    // 临时存放的文件名
    $tmp_name = $_FILES['uploadfile']['tmp_name'];
    // 文件名的后缀
    $ext_name = pathinfo($upload_filename)['extension'];
    // 允许的图片类型
    $img_type = ['jpg', 'png', 'gif'];
    // 验证扩展名
    if (!in_array($ext_name, $img_type)) {
        alert("不支持的文件类型！");
    }
    // 文件上传路径
    $upload_path = "./assets/img/upload/";
    if (!is_dir($upload_path)) {
        // 第三个参数为允许嵌套创建
        mkdir($upload_path, 0777, true);
    }
    // 构造文件名
    $img_name = 'img_' . time() . mt_rand(10000, 99999) . '.' . $ext_name;
    // 拼接文件路径
    $img_path = $upload_path . $img_name;
    // 定义一个报错信息
    $error_msg = null;
    // 判断目录是否创建成功
    if (file_exists($upload_path)) {
        // 判断文件是否已上传
        if (is_uploaded_file($tmp_name)) {
            // 判断是否已将缓存文件移入上传目录，移入成功后清除缓存文件
            if (move_uploaded_file($tmp_name, $img_path)) {
                clearstatcache();
                // 将图片路径保存至当前用户的
                $user_id = $_SESSION['user_info']['u_id'];
                // $user_id 是整型不用加引号
                $sql = "update users set `u_pic` = '$img_path' where `u_id` = $user_id;";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_affected_rows($conn) > 0) {
                    $_SESSION['user_info']['u_pic'] = $img_path;
                    alert('上传成功！');
                }
            } else {
                $error_msg = '移动缓存文件失败！';
            }
        } else {
            $error_msg = '文件通过http上传失败！';
        }
    } else {
        $error_msg = '目录错误！';
    }
    // 打印错误信息
    if ($error_msg != null) {
        alert($error_msg);
    }
}


include("./view//upload/upload.html");
