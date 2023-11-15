<?php 
session_start();
include 'stock.php';
include 'dbConnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>點餐系統</title>
    <link rel="stylesheet" href="/css/css.css">
</head>
<body>


<script>
function hideOrder(orderId) {
    // 在此添加隱藏訂單的邏輯
    const orderElement = document.getElementById('order_' + orderId);
    if (orderElement) {
        orderElement.style.display = 'none';
    } else {
        console.error('找不到訂單元素：', orderId);
    }
}
</script>


<nav>
<ul class="clientMeun">
        <li><a href="/">首頁</a></li>
        <li><a href="/about.php">關於</a></li>
</ul>
<ul class="staffMenu">
    <?php 
    if ($_SESSION)
    {
        echo '
            <li><a href="/allOrders.php">所有訂單</a></li>
            <li><a href="/functions.php?op=logout">登出</a></li>';
    }
    else
    {
        echo '<li><a href="/login.php">職員登入</a></li>';
    }
    ?>
</ul>
</nav>