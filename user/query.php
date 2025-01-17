<?php
    $id = $_GET["id"];
    $now = date("Y-m-d H:i:s");

    // 获取数据库配置
    $db_config_string = file_get_contents('../db_config.json');
    $db_config = json_decode($db_config_string, true);

    // 创建连接
    $conn = new mysqli(
        $db_config["servername"],
        $db_config["username"],
        $db_config["password"],
        $db_config["dbname"]
    );
 
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM contest WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $acticle, $end_time, $time_limit);
    if ($stmt->fetch() == 0) {
        echo "<script>alert('竞赛ID不正确！请点击“查看竞赛”获取进行中的竞赛的ID');history.go(-1);</script>"; 
    } else{
        if (strtotime($now) > strtotime($end_time)) {
            echo "<script>alert('竞赛已结束！');history.go(-1);</script>";
        } else {
            echo "<script>location.href = '../type/competition.html?id=" . $id . "'</script>";
        }
    }

    $conn->close();
    header('Content-Type:text/html;charset=utf-8');
?>