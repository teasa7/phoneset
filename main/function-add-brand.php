<?php
    include_once("link.php");
    $brand=$_POST["brand"];

    $image=$_FILES["file"]["tmp_name"][0];
    $image = addslashes(file_get_contents($image));

    $result_brand_check= mysqli_query($link, "SELECT ID FROM `brands` WHERE brand='$brand'");
    $row_brand_check = mysqli_fetch_assoc($result_brand_check);
    if($row_brand_check["ID"] == '') {
        $result_brand= mysqli_query($link, "INSERT INTO brands(brand, `image`) VALUE ('$brand', '$image')");
    }

?>