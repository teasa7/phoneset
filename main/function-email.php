<? include_once("link.php"); 

if ($_GET['hash']) {
    $hash = $_GET['hash'];

    if ($result = mysqli_query($link, "SELECT ID, verified FROM `users` WHERE `hash`='$hash'")) {
        while($row = mysqli_fetch_assoc($result)) { 
            echo $row["ID"] . " " . $row["verified"];
            if ($row["verified"] == 0) {
                $ID = $row["ID"];
                mysqli_query($db, "UPDATE users SET verified=1 WHERE ID='$ID'");
                echo "Email подтверждён";
            } else {
                echo "Что то пошло не так";
            }
        } 
    } 
    else {
        echo "Что то пошло не так";
    }
} 
else {
    echo "Что то пошло не так";
}
?>