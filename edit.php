<?php
include("./config/init.php");
include("./config/lib.php");


// 获取要编辑的留言id，查询该id对应的数据，将留言数据写入文本框
$m_id = isset($_GET['m_id']) ? $_GET['m_id']:0;
$sql = "SELECT * FROM `msgs` WHERE `m_id` = $m_id;";
$result = mysqli_query($conn,$sql);
$msg = mysqli_fetch_assoc($result);

// 根据session进行过滤
if($_SESSION['user_info']['u_id'] !== $msg['u_id']){
    alert("只能编辑自己的留言！", "./index.php");
}

// 等待编辑信息的提交，获取post数据后，将post上来的留言更新到数据库，并修改留言时间
// 更新成功后跳回首页
if($_POST){
    $time = time();
    $msg = $_POST['message'];
    $sql = "UPDATE `msgs` SET `m_content` = '$msg', `m_time` = $time WHERE `m_id` = $m_id";
    $result = mysqli_query($conn,$sql);
    if($result){
        alert("更新成功！", "./index.php");
    }

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑</title>
</head>
<body>
<form action="" method="post">
    <p>留言内容：<input type="text" name="message" value="<?php echo $msg['m_content'];?>"></p>
    <p><input type="submit" name="edit" value="编辑"></p>
</form>
</body>
</html>