<?php
    include_once("link.php");
    $code = $_POST["code"];
    $name = $_POST["name"];

    $result_code_check= mysqli_query($link, "SELECT ID FROM `colors` WHERE code='$code'");
    $row_code_check = mysqli_fetch_assoc($result_code_check);
    if($row_code_check["ID"] == '') {
        $result_color= mysqli_query($link, "INSERT INTO `colors`(`code`, `name`) VALUE ('$code', '$name')");
    }

?>