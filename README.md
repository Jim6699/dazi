## 打字系统

**感谢原作者提供基础代码支持：[点我跳转仓库](https://github.com/HuanLing4763/dazi "点我进入")**

****
在原作者仓库基础上优化如下:

1.增加SQL创建教程

2.优化一些脚本和网页的代码错误（字符问题、重置后字数不清空导致速度异常等）

3.增加“指法练习”“英文处理”“其他内容”“竞赛排名”“未参加竞赛统计”等功能 

****


在线试用网站：http://welfare.freeee.ml/dazi

用户：test

密码：123456789（普通用户默认）

> 免费主机：https://www.freehost.cc/

db_config.json（必须修改）
```json
{
    "servername": "localhost:3306", 
	#如果用的上面免费主机就是：sql110.freeee.ml:3306
    "username": "账号",
    "password": "密码",
    "dbname": "数据库名"
}
```
SQL创建命令：
```sql
比赛数据库：
CREATE TABLE `contest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acticle` varchar(255) NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `time_limit` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

用户数据库：
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

练习成绩表：
CREATE TABLE `grades` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '成绩ID',
  `user_name` VARCHAR(50) NOT NULL COMMENT '用户名',
  `acticle` VARCHAR(100) NOT NULL COMMENT '文章内容',
  `word_count` INT NOT NULL COMMENT '字数',
  `time` FLOAT(5,2) NOT NULL COMMENT '时间',
  `date` DATE NOT NULL COMMENT '日期',
  `speed` FLOAT(5,2) NOT NULL COMMENT '速度',
  `accuracy` FLOAT(5,2) NOT NULL COMMENT '正确率',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COMMENT '成绩表';

比赛成绩表：
CREATE TABLE `contest_info` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '比赛记录ID',
  `user_name` VARCHAR(50) NOT NULL COMMENT '用户名',
  `contest_id` INT NOT NULL COMMENT '比赛ID',
  `acticle` VARCHAR(100) NOT NULL COMMENT '文章内容',
  `word_count` INT NOT NULL COMMENT '字数',
  `time` FLOAT(5,2) NOT NULL COMMENT '时间',
  `date` DATE NOT NULL COMMENT '日期',
  `speed` FLOAT(5,2) NOT NULL COMMENT '速度',
  `accuracy` FLOAT(5,2) NOT NULL COMMENT '正确率',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COMMENT '比赛记录表';


新增管理员：
账号 root   密码 qwerty
INSERT INTO `users` (`user_name`, `user_password`) VALUES ('root', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e')
补充：管理员密码可自行修改，可先查看网页请求的加密值修改即可
```

