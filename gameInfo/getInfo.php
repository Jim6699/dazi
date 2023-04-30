<?php
    $id = $_GET["id"];

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

    $sql = "SELECT * FROM contest_info WHERE contest_id = {$id} ORDER BY `date` DESC";
    $result = mysqli_query($conn, $sql);

    $rows = array();

    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $conn->close();

    // 转换为JSON格式
    $response = array(
        'success' => true,
        'data' => $rows
    );

    header('Content-Type: application/json');
    echo json_encode($response);
?>
