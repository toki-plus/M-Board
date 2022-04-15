<?php
include("./config/init.php");
include("./config/lib.php");
include("./config/page.php");


// 分页功能
$current = isset($_GET['page'])?$_GET['page']:1;
// 每页显示多少条
$limit = 8;
// 设置每页开始值 0 5 10 15
$start = ($current - 1) * $limit;
// 中间显示多少条
$size = 6;
// 获取数据库留言总条数
$sql = "select count(*) as count from `msgs`";
$result = mysqli_query($conn,$sql);
$count = mysqli_fetch_assoc($result);
$count = $count['count'];
// 分页函数调用
$pages = page($current,$count,$limit,$size);



// 渲染留言板
$sql = "select `m_id`, `m_content`, `m_time`, `u_name`, `u_pic` from `msgs` as m left join `users` as u on m.u_id = u.u_id order by m.m_time desc limit $start,$limit;";
// 留言列表渲染
$result = mysqli_query($conn, $sql);
$review_lists = [];
while ($row = mysqli_fetch_assoc($result)){
    $review_lists[] = $row;
}


// 提交评论功能
if ($_POST) {
    // 提交留言后 验证登录
    if (!isset($_SESSION['user_info']) || empty($_SESSION['user_info'])) {
        alert("请登录后再留言！", "./login.php");
    }

    //  获取留言的 post 信息
    if (!isset($_POST['message']) || empty($_POST['message'])){
        alert("留言不能为空！");
    }

    $review_message = strip_tags($_POST['message']);
    $review_time = time();
    $user_id = $_SESSION['user_info']['u_id']$_POST['message'];

    // 插入数据库
    $sql = "insert into `msgs` (`m_content`, `m_time`, `u_id`) values ('$review_message', '$review_time', '$user_id');";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) > 0) {
        alert("评论成功！", "./index.php");
    } else {
        alert("评论失败！");
    }
}


include('./view/index/index.html');
