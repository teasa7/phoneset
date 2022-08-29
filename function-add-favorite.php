<?php
    include_once("link.php");
    $id_user = $_POST["id_user"];
    $id_product = $_POST["id_product"];

    $date = date('Y-m-d H:i:s');
    $query_add="INSERT INTO favorites(ID_user, ID_product, date_favorite) VALUE ('$id_user', '$id_product', '$date')";
    echo $query_add;
    mysqli_query($link, $query_add);
?>