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
    // 过滤用户输入
    $account = mysqli_real_escape_string($conn, $_POST['account']);
    // 检测用户是否存在
    $sql = "SELECT * FROM users WHERE user_name = '$account'";
    $result = $conn->query($sql);
    if (!$result->num_rows) {
        echo "<script>alert('用户不存在');</script>";
    } else {
        // 确认不是删除root用户
        if ($account === 'root') {
            echo "<script>alert('禁止删除root用户');</script>";
        } else {
            // 删除用户
            $sql = "DELETE FROM users WHERE user_name = '$account'";
            if (!$conn->query($sql)) {
                echo "<script>alert('删除用户失败: " . $conn->error . "');</script>";
            } else {
                echo "<script>alert('删除用户成功'); window.location.href='manage.html';</script>";
            }
        }
    }
    $conn->close();
?>