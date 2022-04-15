<?php

// 连接数据库
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "123456");
define("DATABASE", "phpdb");
define("PORT", "3306");
define("SOCKET", null);
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE, PORT, SOCKET) or die('数据库连接失败');

// 开启 session
session_start();
setcookie(session_name(), session_id(), time() + 60*15, "/", "localhost");


// html 编码配置
header('Content-Type: text/html; charset=utf-8');

// 设置时区
date_default_timezone_set('PRC');