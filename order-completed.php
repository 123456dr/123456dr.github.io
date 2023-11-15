


<?php
include('header.php'); 
include('functions.php'); 

// 獲取最後一個訂單信息
$orderQ = mysqli_query($dbConnection, "SELECT * FROM `order` ORDER BY order_time DESC LIMIT 1");
echo '<h2>訂單已送出，請至505付款！</h2>';
echo '<h1>請截圖  </h1>';

echo '<div class="container">';

$totalCost = 0;  // 用於計算總花費金額

if ($order = mysqli_fetch_assoc($orderQ)) {
    $gemQ = mysqli_query($dbConnection, 'SELECT * FROM `gem` WHERE gem_id=' . $order['gem_id']);
    $gem = mysqli_fetch_assoc($gemQ);

    // 計算每個訂單的金額
    $orderCost = $order['quantity'] * $gem['price'];
    
    // 考慮加料次數，每+1次總金額+10元
    $toppingCount = isset($order['topping']) && is_array($order['topping']) ? count($order['topping']) : 0;
    $orderCost += $toppingCount * 10;
    
    $totalCost += $orderCost;
    global $userInputTopping;
    echo '<p>';
    echo '訂單ID : ' . $order['order_id'] . '<br/>';
    echo '餐點(' . $userInputTopping . '): ' . $gem['name'] . ' X ' . $order['quantity'] . '件 <br/>';
    echo '客戶稱呼 : ' . $order['client_name'] . '<br/>';
    echo '下單時間 : ' . $order['order_time'] . '<br/>';

    // 檢查是否有加料
    if ($toppingCount > 0) {
        echo '加料 : ' . implode(', ', $order['topping']) . '<br/>';
    }

    echo '</p>';
} else {
    echo '<p>沒有找到訂單信息。</p>';
}

echo '<p>總花費金額：' . $totalCost . '</p>';
echo '</div>';

include('footer.php');
?>
