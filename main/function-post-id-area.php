<? include_once("link.php");

$name_area=$_POST['name_area'];
$result_area=mysqli_query($link, "SELECT * FROM `areas` WHERE area='$name_area'");	
$row_area=mysqli_fetch_assoc($result_area);

$ID_area=$row_area["ID"];

echo $ID_area; ?>