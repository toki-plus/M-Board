<?php
include("./config/init.php");
include("./config/lib.php");


// 由get请求获取get数据，拿到m_id去查数据对应的u_id，看是否与session里的uid相同，进行拦截
$m_id = isset($_GET['m_id']) ? $_GET['m_id'] : 0;
$sql = "select * from `msgs` where `m_id` = $m_id;";
$result = mysqli_query($conn, $sql);
$msg = mysqli_fetch_assoc($result);

if ($_SESSION['user_info']['u_id'] !== $msg['u_id']) {
    alert("只能删除自己的留言！", "./index.php");
}


// 拿到get到的m_id去数据库删数据，删除成功后跳转到首页
$sql = "DELETE FROM `msgs` WHERE `m_id` = $m_id";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_affected_rows($conn) > 0) {
    alert("删除成功！", "./index.php");
}
