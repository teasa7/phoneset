<?php
    include_once("link.php");
    $id = $_POST["id"];

    $query_delete="DELETE FROM `favorites` WHERE ID=$id";
    mysqli_query($link, $query_delete);
?>