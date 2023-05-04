<!DOCTYPE html>
<html>
<head>
	<title>竞赛成长图息</title>
	<meta charset="UTF-8">
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-color: #ffffff;
		}

		h1 {
			text-align: center;
			margin-top: 30px;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-top: 40px;
		}

		label {
			margin-top: 10px;
			font-weight: bold;
			font-size: 20px;
			color: #333;
		}

		input[type="text"] {
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			box-shadow: inset 0 1px 3px #ddd;
			font-size: 16px;
			width: 300px;
			margin-bottom: 20px;
			outline: none;
		}

		button {
			padding: 10px;
			border-radius: 5px;
			border: none;
			background-color: #007bff;
			color: #fff;
			font-size: 16px;
			cursor: pointer;
			margin-top: 10px;
			transition: all 0.3s ease;
		}

		button:hover {
			background-color: #0062cc;
		}

		#myChart {
			width: 80%;
			height: 30%;
			margin: 10px auto;
			box-shadow: 0 2px 6px rgba(0,0,0,.1);
			border-radius: 8px;
		}
	</style>
</head>
<body>
<?php
session_start();
// 如果没有登录状态，则提示权限不足
if(empty($_SESSION['user'])) {
	echo '<h1>权限不足，请先登录。</h1>';
	die;
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

// 处理表单提交
if(isset($_POST['submit'])) {
	// 获取输入框里的姓名
	$user_name = $_POST['user_name'];
	// 查询数据库
	$sql = "SELECT * FROM contest_info WHERE user_name = '$user_name'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// 将查询结果保存到数组中
		$date = array();
		$speed = array();
		while($row = $result->fetch_assoc()) {
			array_push($date, date('m-d', strtotime($row["date"])));
			array_push($speed, intval($row["speed"]));
		}
		$date_json = json_encode($date, JSON_NUMERIC_CHECK);
		$speed_json = json_encode($speed, JSON_NUMERIC_CHECK);
	} else {
		// 查询结果为空
		echo '<h1>查询结果为空。</h1>';
	}
}
?>
<form method="post">
    <label for="user_name">请输入要查询的姓名：</label>
    <input type="text" id="user_name" name="user_name" value="<?php echo $_SESSION['user']; ?>" required style="margin-top: 8px;">
	<button type="submit" name="submit">查询竞赛成长信息</button>
</form>
<?php
// 如果有查询结果，则展示折线图
if(isset($date_json, $speed_json)) {
?>
<canvas id="myChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	var date = <?php echo $date_json; ?>;
	var speed = <?php echo $speed_json; ?>;
	
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'line',
	    data: {
	        labels: date,
	        datasets: [{
	            label: '成长折线图',
	            data: speed,
	            backgroundColor: [
	            	'rgba(220,20,60, 0.2)',
	            ],
	            borderColor: [
	            	'rgba(220,20,60, 1)',
	            ],
	            borderWidth: 1,
	            pointRadius: 4,
    			pointBackgroundColor: 'rgba(220,20,60, 1)',
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	            	gridLines: {
	                    display: true,
	                    color: '#ddd',
	                    lineWidth: 1,
	                    drawBorder: false,
	                    drawTicks: false,
	                },
	                ticks: {
	                    beginAtZero: true,
	                    fontColor: '#666',
	                    fontSize: 14,
	                    stepSize: 10,
	                },
	            }],
	            xAxes: [{
	            	gridLines: {
	                    display: false,
	                },
	                ticks: {
	                    fontColor: '#666',
	                    fontSize: 14,
	                },
	                barPercentage: 0.5,
	            }],
	        },
	        legend: {
	        	display: false,
	        },
	        tooltips: {
	        	enabled: true,
	        	titleFontSize: 14,
	        	bodyFontSize: 14,
	        	backgroundColor: 'rgba(0,0,0,0.7)',
	        	borderColor: '#333',
	        	xPadding: 12,
	        	yPadding: 12,
	        	caretSize: 6,
	        	caretPadding: 6,
	        	cornerRadius: 5,
	        	callbacks: {
	        		title: function(tooltipItems, data) {
	        			return '时间：' + tooltipItems[0].xLabel;
	        		},
	        		label: function(tooltipItems, data) {
	        			return '成绩：' + tooltipItems.yLabel + ' 秒';
	        		},
	        	},
	        },
	        layout: {
	            padding: {
	                left: 20,
	                right: 20,
	                top: 20,
	                bottom: 20,
	            },
	        },
	    }
	});
</script>
<?php } ?>
</body>
</html>
