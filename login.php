<?php
include("./config/init.php");
include("./config/lib.php");

// 拿到客户端浏览器的 SID 去找服务端中的 SID 文件
// 如果 SID 文件中已经设置了 session 内容，则跳转到首页
if (!empty($_SESSION["user_info"])) {
    alert("您已登录！", "./index.php");
}

// 账号密码正确跳转到首页
if ($_POST) {

    $username = trim($_POST["username"]);
    $password = md5($_POST["password"]);

    $sql = "select `u_id`,`u_name` from `users` where `u_name` = '$username' and `u_pass` = '$password';";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_info = mysqli_fetch_assoc($result);
        $_SESSION["user_info"] = $user_info;
        alert("登录成功！", "./index.php");
    } else {
        alert("登录失败！");
    }
}

include("./view/login/login.html");
