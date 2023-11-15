<?php
include('dbConnect.php');

$gemId = $_GET['gem_id'];

$sql = "SELECT price FROM gem WHERE gem_id = " . $gemId;
$result = mysqli_query($dbConnection, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['price'];
} else {
    echo "0";
}

mysqli_close($dbConnect.php);
?>


