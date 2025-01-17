<?php
    session_start();
    $name = $_SESSION['user'];
    $acticle = $_GET["acticle"];
    $wordCount = $_GET["wordCount"];
    $time = $_GET["time"];
    $speed = $_GET["speed"];
    $accuracy = $_GET["accuracy"];
    $contestId = $_GET["contestId"];
    $date = $_GET["date"];

    // 检测是否为访客
    if (!$name) {
        echo 1;
        exit(0);
    }

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

    $stmt = $conn->prepare("INSERT INTO grades VALUES(0, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissii", $name, $acticle, $wordCount, $time, $date, $speed, $accuracy);
    $result = $stmt->execute();  // 执行 SQL 语句
    $stmt->close();  // 关闭 prepared statement

    if ($contestId) {
        $stmt = $conn->prepare("INSERT INTO contest_info VALUES(0, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisissii", $name, $contestId, $acticle, $wordCount, $time, $date, $speed, $accuracy);
        $result = $stmt->execute();  // 执行 SQL 语句
        $stmt->close();  // 关闭 prepared statement
    }

    $conn->close();  // 关闭连接

    if ($result) {
        echo "<script>alert('提交成功！');</script>";
        echo "<script>console.log('提交成功！');</script>";
    } else {
        echo "<script>alert('提交失败：".$conn->error."');</script>";
        echo "<script>console.log('提交失败：".$conn->error."');</script>";
    }

?>
