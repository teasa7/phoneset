<?php
    include_once("link.php");
    $ID_brand = $_POST["ID_brand"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $ID_country = $_POST["ID_country"];

    $result_model_check= mysqli_query($link, "SELECT ID FROM `models` WHERE ID_brand='$ID_brand' AND model='$model' AND year_release='$year' AND ID_country='$ID_country'");
    $row_model_check = mysqli_fetch_assoc($result_model_check);
    if($row_model_check["ID"] == '') {
        $result_model= mysqli_query($link, "INSERT INTO models(`ID_brand`, `model`, `year_release`, `ID_country`) VALUE ('$ID_brand', '$model', '$year', '$ID_country')");
    }

?>