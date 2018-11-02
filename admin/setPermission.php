<?php 
	session_start();
	include '../includes/dbh.inc.php';
	$username=$_GET['uname'];
	$permission= $username[0];
	$username = substr($username,1);
	if($permission==0){
		$sqlUpdate = "UPDATE blogger set blog_permission = '1' where blog_username = '$username'";
	}else{
		$sqlUpdate = "UPDATE blogger set blog_permission = '0' where blog_username = '$username'";
	}
	mysqli_query($conn,$sqlUpdate);
	header("Location:index.php?SuccessfullyUpdated");
?>