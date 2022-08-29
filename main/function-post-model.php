<?php include_once("link.php");

$brand=$_POST['brand'];
$query_brand="SELECT ID FROM `brands` WHERE brand='$brand'";
$result_brand=mysqli_query($link, $query_brand);
$row_brand=mysqli_fetch_assoc($result_brand);

$ID_brand=$row_brand['ID'];
$query_model="SELECT model FROM `models` WHERE ID_brand='$ID_brand'";
$result_model=mysqli_query($link, $query_model);
while ($row_model=mysqli_fetch_assoc($result_model)) {
    echo $row_model["model"].",";
}	?>

