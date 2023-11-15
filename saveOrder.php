<?php include('header.php'); 
include('functions.php'); 

// 不是職員的不可以觀看訂單
if (!isStaff()) {
    header("Location: /");
    exit(); // 終止執行後面的程式碼
}

?>

<h1>Order們</h1>

<?php 
global $k;

// 拿訪客的訂單資料
$orderQ = mysqli_query($dbConnection, "SELECT * FROM `order`");

while ($order = mysqli_fetch_assoc($orderQ)) {

    $gemQ = mysqli_query($dbConnection, 'SELECT * FROM `gem` WHERE gem_id='.$order['gem_id']);
    $gem = mysqli_fetch_assoc($gemQ);

    echo '<div class="order"><p>';
    echo '客戶稱呼 : '.$order['client_name'].'<br/>';
    echo '訂單 : '.$gem['name'].' X '.$order['quantity'].'件 <br/>';
    echo '下單時間 : '.$order['order_time'].'<br/>';
    echo '</p></div>';

    echo '<div class="col">
        <button class="deleteBtn" onclick="deleteOrder('.$order['order_id'].')">刪除</button>
        <button class="saveBtn" onclick="saveOrder('.$order['order_id'].')">保存</button><br>
    </div>';
}

?>

<script>
function deleteOrder(orderId) {
    // 使用 JavaScript 的 fetch 函數向 delete.php 發送刪除請求
    fetch('/delete.php?order_id=' + orderId, {
        method: 'DELETE',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('刪除失敗');
        }
        // 刷新當前頁面
        location.reload();
    })
    .catch(error => {
        console.error('刪除失敗:', error);
    });
}

function saveOrder(orderId) {
    // 使用 JavaScript 的 fetch 函數向 saveOrder.php 發送保存請求
    fetch('/saveOrder.php?order_id=' + orderId, {
        method: 'POST',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('保存失敗');
        }
        // 提示保存成功
        alert('訂單保存成功');
    })
    .catch(error => {
        console.error('保存失敗:', error);
    });
}
</script>

<?php include('footer.php'); ?>
