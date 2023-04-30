<?php
// 获取数据库配置
$db_config_string = file_get_contents('../db_config.json');
$db_config = json_decode($db_config_string, true);

// 创建连接
$conn = new mysqli($db_config["servername"], $db_config["username"], $db_config["password"], $db_config["dbname"]);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 查询竞赛信息
$id = $_GET["id"];
// $sql = "SELECT * FROM contest_info WHERE contest_id = {$id} ORDER BY `date` DESC";
// $result = mysqli_query($conn, $sql);
// $rows = array();
// while($row = mysqli_fetch_assoc($result)) {
//     $rows[] = $row;
// }

// 查询参赛人员信息
// $users_sql = "SELECT user_name FROM users u WHERE NOT EXISTS ( SELECT * FROM contest_info ci WHERE u.user_name = ci.user_name COLLATE utf8mb4_general_ci AND ci.contest_id= {$id})";
$users_sql = "SELECT user_name FROM users u WHERE NOT EXISTS ( SELECT * FROM contest_info ci WHERE u.user_name = ci.user_name COLLATE utf8mb4_general_ci AND ci.contest_id= {$id}) AND u.user_name NOT IN ('root')";
// 指定不显示root
$users_result = mysqli_query($conn, $users_sql);
$users = array();
while($user = mysqli_fetch_assoc($users_result)) {
    $users[] = $user;
}

$conn->close();

// 返回数据
$response = array(
    'success' => true,
    'data' => $users
);
header('Content-Type: application/json');
echo json_encode($response);
?>