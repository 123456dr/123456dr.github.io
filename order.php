<?php

include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hiddenTotalPrice"])) {
    $totalPrice = $_POST["hiddenTotalPrice"];

    // 將訂單相關資訊保存到 session 中
    $_SESSION["orderDetails"] = array(
        "clientName" => isset($_POST["name"]) ? $_POST["name"] : "",
        "gemId" => $_POST["gem_id"],
        "quantity" => $_POST["quantity"],
        "topping" => isset($_POST["topping"]) ? $_POST["topping"] : "",  // 如果 topping 沒有選擇，就設置為空字符串
        "totalPrice" => $totalPrice
    );

    // 新增變數來儲存加點欄位的文字
    $toppingText = isset($_POST["topping"]) ? implode(', ', $_POST["topping"]) : "";
} else {
    $totalPrice = 0;
    $toppingText = "";
}
?>

<form action="/functions.php?op=createOrder" method="post">

    <label for="gem_name">點餐 </label>
    <input type="hidden" id="gem_id" name="gem_id" value="<?php echo $_GET['gem_id']; ?>">

    <br>

    <?php
    $gemId = $_GET['gem_id'];
    if ($gemId == 1) {
        /*// 如果 gem_id 等於 1，輸出加料輸入框
        ?>
        <label for="topping">[加料(肉,菜,蛋,起司,年糕,泡菜)(複選優惠-5元):]</label>
        <input type="text" name="topping" id="topping" placeholder="請輸入加料，以逗號分隔"><br>

        <?php*/
        echo '<h3>人工計算</h3>';
        echo '<label for="name">加料:</label>
        <input type="text" id="name" name="name"><br/>';
    } else {
        // 否則，輸出 "你的稱呼" 欄位
        echo '<label for="name">你的稱呼:</label>
          <input type="text" id="name" name="name"><br/>';
    }
    ?>

    <label for="quantity">購買數量:</label>
    <input type="number" id="quantity" name="quantity" min="1" max="5" value="1">

    <br>
    <input class="buyBtn" type="submit" value="下單預訂">

</form>


<script>
    // JavaScript 函數計算總價
    function calculateTotal() {
        var quantity = document.getElementById('quantity').value;
        var gemId = document.getElementById('gem_id').value;

        // 發起 AJAX 請求獲取餐點價格
        $.get('/get_gem_price.php?gem_id=' + gemId, function (response) {
            var gemPrice = parseFloat(response);
            var totalPrice = quantity * gemPrice;

            // 更新顯示總價的元素
            document.getElementById('totalPrice').textContent = totalPrice;

            // 更新隱藏的總價字段
            document.getElementById('hiddenTotalPrice').value = totalPrice;
        });
    }
</script>

<?php include 'footer.php'; ?>
