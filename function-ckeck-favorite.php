<?php
    include_once("link.php");
    $id_user = $_POST["id_user"];
    $id_product = $_POST["id_product"];
    $date = date('Y-m-d H:i:s');

    $query_check="SELECT ID FROM `favorites` WHERE ID_user=$id_user and ID_product=$id_product";
    $result_check=mysqli_query($link, $query_check);
    $row_check = mysqli_fetch_assoc($result_check);
    if ($row_check["ID"] == '') {      
        $query_add="INSERT INTO favorites(ID_user, ID_product, date_favorite) VALUE ('$id_user', '$id_product', '$date')"; 
        mysqli_query($link, $query_add);
        $text_check = 1;
    }
    else {
        $query_delete="DELETE FROM `favorites` WHERE ID_user=$id_user and ID_product=$id_product";
        mysqli_query($link, $query_delete);   
        $text_check = 0;
    }
    echo $text_check;
?>
