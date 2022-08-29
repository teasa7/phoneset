<?php
    include_once("link.php");
    $id = $_POST["id"];

	$result=mysqli_query($link, "SELECT * FROM `favorites` WHERE ID='$id'");
	$row=mysqli_fetch_assoc($result);

    $ID_product=$row["ID_product"];
    $ID_user=$row["ID_user"];
    $date = date('Y-m-d H:i:s');

    $result=mysqli_query($link, "INSERT INTO carts(ID_user, ID_product, date_cart) VALUE ('$ID_user', '$ID_product', '$date')");
	$row=mysqli_fetch_assoc($result);
?>