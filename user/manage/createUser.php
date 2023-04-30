<?php
    $account = $_POST["account"];

    // 获取数据库配置
    $db_config_string = file_get_contents('../../db_config.json');
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

    // 检测用户是否存在
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt->bind_param('s', $account);
    $stmt->execute();
    if ($stmt->fetch() > 0) {
        echo "<script>alert('用户名已存在'); window.location.href='register.html';</script>";
    } else {
        // 创建用户
        $stmt = $conn->prepare("INSERT INTO users VALUES(0, ?, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441')");
        $stmt->bind_param('s', $account);
        if (!$stmt->execute()) {
            echo "<script>alert('创建用户失败: " . $stmt->error . "'); window.location.href='register.html';</script>";
        } else {
            echo "<script>alert('创建用户成功，密码默认为：123456789  '); window.location.href='login.html';</script>";
        }

        $stmt->close();
    }

    $conn->close();
?>
