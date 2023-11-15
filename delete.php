<?php
// delete.php

include 'header.php'; 
include 'dbConnect.php';

// 檢查是否有傳入 order_id
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // 刪除指定 order_id 的訂單
    $deleteQuery = "DELETE FROM `order` WHERE `order_id` = $order_id";
    
    if (mysqli_query($dbConnection, $deleteQuery)) {
        echo "訂單已成功刪除";
    } else {
        echo "刪除訂單時發生錯誤：" . mysqli_error($dbConnection);
    }
} else {
    echo "未指定要刪除的訂單";
}

include 'footer.php';
?>