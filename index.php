
<?php include('header.php');?>


    <h1>505霍格黃資</h1>
    <h2>訂餐系統</h2>

<div class="flex-grid">
<?php
//顯示貨品
//global $idd
$gemQ = mysqli_query($dbConnection, "SELECT * FROM `gem`");

$i=0;
while ($gem = mysqli_fetch_assoc($gemQ)) {
    $i++;
    echo '<div class="col">
    
    <img src="/images/'.$gem['image'].'" />
    <p>
    '.$gem['name'].'<br>
    $'.$gem['price'].'<br>
    <a href="/order.php?gem_id='.$gem['gem_id'].'" class="buyBtn">預訂'.$gem['name'].'</a><br>
    </div>';
    if($i=='6'){ echo "<br><br>";}
}

/* foreach($gems as $key => $gem)
{
    echo '<div class="col">
    <img src="/images/'.$gem['image'].'" />
    <p>
    名稱：'.$gem['name'].'<br>
    價格：$'.$gem['price'].'<br>
    <a href="/order.php?gem_id='.$gem['gem_id'].'" class="buyBtn">預訂'.$gem['name'].'</a><br>
    </div>';
} */
?>
</div>

<?php include('footer.php'); ?>