<?php
	ob_start();
	include_once("link.php");

	$token=$_COOKIE["cookieToken"];
	
	$query="UPDATE users SET token=NULL WHERE token='$token'";
	mysqli_query($link, $query);

	unset($_COOKIE['cookieToken']);
	setcookie('cookieToken', NULL, -1, '/');

	header("Location: index.php");

	ob_end_flush();
?>