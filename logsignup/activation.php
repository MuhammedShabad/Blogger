<?php
	session_start();
	include_once '../includes/dbh.inc.php';
	$hash=$_GET['activation_code'];
	$sql = "UPDATE blogger SET blog_verified='1' where blog_hash='$hash'";
	mysqli_query($conn,$sql);
	header("location: login.php");
?>