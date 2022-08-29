<?php
    include_once("link.php");
    $id = $_POST["id"];

    $query_delete="DELETE FROM `carts` WHERE ID=$id";
    mysqli_query($link, $query_delete);

    $ID_user=$_POST["user"];
    $query="SELECT * FROM `carts` WHERE ID_user='$ID_user'";
	$result=mysqli_query($link, $query);
	while($row=mysqli_fetch_assoc($result)) {
        $ID_product=$row["ID_product"];
        $count=$row["count"];    

        $date = '0000-00-00';
        $query_price="SELECT price, `date` FROM `prices` WHERE ID_product='$ID_product'";	
        $result_price=mysqli_query($link, $query_price);
        while($row_price=mysqli_fetch_assoc($result_price)) {
            if ($row_price['date'] > $date) {
                $price = $row_price['price'];
                $date = $row_price['date'];
            }          
        }

        $query_product="SELECT * FROM `products` WHERE ID='$ID_product'";	
        $result_product=mysqli_query($link, $query_product);
        $row_product=mysqli_fetch_assoc($result_product); 
        $new_price=round($price-($price / 100 * $row_product["discount"]));

        $totalPrice=$totalPrice+($new_price*$count);
    }
    echo $totalPrice;
?>