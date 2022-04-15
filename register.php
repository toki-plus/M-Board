<?php
include("./config/init.php");
include("./config/lib.php");

// 拿到客户端浏览器的 SID 去找服务端中的 SID 文件
// 如果 SID 文件中已经设置了 session 内容，则跳转到首页
if (!empty($_SESSION["user_info"])) {
    alert("退出登录后注册！", "./index.php");
}

if ($_POST) {
    if (!isset($_POST["username"]) || empty($_POST["username"])) {
        alert("用户名不能为空！");
    }
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        alert("密码不能为空！");
    }
    if (!isset($_POST["repassword"]) || empty($_POST["repassword"])) {
        if ($_POST["password"] !== $_POST["repassword"]) {
            alert("密码不匹配！");
        }
    }

    $username = trim($_POST["username"]);
    $password = md5($_POST["password"]);
    $regtime = time();

    // 检查用户名是否已注册
    $sql = "select `u_name` from `users` where `u_name` = '$username';";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        alert("用户名已被注册！");
    }

    $sql = "insert into `users` (`u_name`, `u_pass`, `u_time`) values ('$username', '$password', '$regtime');";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) > 0) {
        alert("注册成功！", "./login.php");
    } else {
        alert("注册失败！");
    }
}



include("./view/register/register.html");
