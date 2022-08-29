<? include_once("link.php");

$ID_area=$_POST['ID_area'];
$result_area=mysqli_query($link, "SELECT * FROM `areas` WHERE ID='$ID_area'");	
$row_area=mysqli_fetch_assoc($result_area);
$area=$row_area["price"];
$price=$_POST['price'];

$all_price = $price + $area; 
echo $all_price; ?>