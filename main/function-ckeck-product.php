<?php
    include_once("link.php");
    $id_color = $_POST["id_color"];
    $id_product = $_POST["id_product"];

    $result_image_one=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_product='$id_product'");
    $row_image_one=mysqli_fetch_assoc($result_image_one); 

    echo $row_image_one["image"];
?>
