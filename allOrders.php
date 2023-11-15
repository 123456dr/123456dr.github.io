<?php
include('header.php'); 
include('functions.php'); 

// 如果不是職員，則重定向到首頁
if (!isStaff()) {
    header("Location: /");
    exit(); // 終止執行後面的程式碼
}

// 處理隱藏和恢復顯示的 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"])) {
    $orderId = $_POST["order_id"];

    // 讀取之前的隱藏狀態
    $hiddenOrders = [];
    if (file_exists('hidden_orders.txt')) {
        $hiddenOrders = unserialize(file_get_contents('hidden_orders.txt'));
    }

    // 切換隱藏狀態
    if (isset($hiddenOrders[$orderId])) {
        $hiddenOrders[$orderId] = !$hiddenOrders[$orderId];
    } else {
        $hiddenOrders[$orderId] = true;
    }

    // 寫入新的隱藏狀態到文件
    file_put_contents('hidden_orders.txt', serialize($hiddenOrders));

    // 重定向到當前頁面以刷新
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order們</title>
    <style>
        /* 在你的樣式表（CSS 文件）中 */
        .hidden-order {
            display: none;
        }
    </style>
</head>
<body>

<h1>Order們</h1>

<?php 
global $k;

// 拿訪客的訂單資料
$orderQ = mysqli_query($dbConnection, "SELECT * FROM `order`");

// 讀取之前的隱藏狀態
$hiddenOrders = [];
if (file_exists('hidden_orders.txt')) {
    $hiddenOrders = unserialize(file_get_contents('hidden_orders.txt'));
}

while ($order = mysqli_fetch_assoc($orderQ)) {

    $gemQ = mysqli_query($dbConnection, 'SELECT * FROM `gem` WHERE gem_id='.$order['gem_id']);
    $gem = mysqli_fetch_assoc($gemQ);

    // 判斷是否已經隱藏，如果隱藏，設置相應的 CSS class
    $hiddenClass = (isset($hiddenOrders[$order['order_id']]) && $hiddenOrders[$order['order_id']]) ? 'hidden-order' : '';
    global $userInputTopping;
    
    echo '<div class="order ' . $hiddenClass . '" id="order_' . $order['order_id'] . '"><p>';
    echo '加料: '.$userInputTopping ; 
    echo '<br> 餐點ID : '.$order['order_id'].'<br/>';  // 新增這一行顯示 gen_id
    echo '訂單 : '.$gem['name'].' X '.$order['quantity'].'件 <br/>';
    echo '客戶稱呼 : '.$order['client_name'].'<br/>';
    echo '下單時間 : '.$order['order_time'].'<br/>';
    
    echo '</p></div>';

    // 添加隱藏按鈕和恢復顯示按鈕
    echo '<div class="col">
        <form method="post" style="display: inline;">
            <input type="hidden" name="order_id" value="'.$order['order_id'].'">
            <button class="hideBtn" type="submit">隱藏/恢復顯示</button>
        </form>
        <form method="post" style="display: inline;">
            <input type="hidden" name="order_id" value="'.$order['order_id'].'">
            
        </form>
    </div>';
}

?>

<?php include('footer.php'); ?>

</body>
</html>
