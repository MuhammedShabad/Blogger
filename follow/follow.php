<?php
	session_start();
	$username = $_SESSION['b_username'];
	$whom = $_POST['whom'];
	$i = strlen($whom);
	$f=$whom[$i-1];
	$whom = substr($whom, 0,-1);
	include '../includes/dbh.inc.php';
	if($username && $f==1){
		$ans='';
		$who = $username;
		$sql = "DELETE from follow where f_who='$who' and f_whom='$whom'";
		mysqli_query($conn,$sql);
		$ans=$whom.$who."0";
		echo $ans;
	}
	if($username && $f==0){
		$ans='';
		$who = $username;
		$sql = "INSERT into follow(f_who,f_whom) values ('$who','$whom')";
		mysqli_query($conn,$sql);
		$ans=$whom.$who."1";
		echo $ans;
	}else{
		header("location: ../logsignup/login.php?LoginToFollow");
	}
?>