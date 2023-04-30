<?php
    header("Content-Type: text/html; charset=utf-8");

    $title = $_POST["title"];
    $content = $_POST["content"];

    //$filename = "../../acticle/" . $title . ".txt";
    $filename = "../../acticle/" . iconv("UTF-8", "GBK", $title) . ".txt";
    if (file_exists($filename)) {
        echo "<script>alert('文章 " . $title . ".txt 已存在，请勿重复添加！！');close();</script>;";
        die();
    }
    $file = fopen($filename, "x") or die("Unable to open file!");

    fwrite($file, $content);

    fclose($file);
    echo "<script>alert('添加 " . $title . ".txt 成功！');close();</script>;";
?>