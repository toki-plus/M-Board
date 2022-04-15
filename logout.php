<?php
include("./config/init.php");
include("./config/lib.php");

// 清除 session 并跳转到登陆
if (!empty($_SESSION["user_info"])) {
    setcookie(session_name(), "", time() - 3600, "/", "localhost");
    unset($_COOKIE[session_name()]);

    // unset($_SESSION['user_info']);
    $_SESSION = array();
    // session_unset();
    session_destroy();
    alert("退出成功！", "./login.php");
}

include("./view/logout/logout.html");
