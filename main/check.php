<?php
    include_once("link.php");

    $token=$_COOKIE['cookieToken'];

	$query="SELECT `ID_right` FROM `users` WHERE token='$token'";
	if(!empty($token))
	{
		if($result=mysqli_query($link, $query))
		{
			if(mysqli_num_rows($result))
			{
				$row=mysqli_fetch_assoc($result);
			}
			else header("Location: index.php");
		}
		else header("Location: index.php");
	}
	else header("Location: index.php");
	if($row["ID_right"]!=1 && $row["ID_right"]!=2 && $row["ID_right"]!=3 && $row["ID_right"]!=5) header("Location: index.php");

	$query_add = "SELECT ID FROM `users` WHERE token = '$token'";
	if($result_add=mysqli_query($link, $query_add)) {
		$row_add=mysqli_fetch_assoc($result_add);
	}
	$MyId=$row_add["ID"];
?>