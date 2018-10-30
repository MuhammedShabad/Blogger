<?php
	session_start();
	include '../follow/following.php';
	$username = $_SESSION['b_username'];
	$sql="SELECT count(*) c from follow where f_who='$username'";
	$result = mysqli_query($conn,$sql);
	mysqli_num_rows($result>0){
		$ans=mysqli_num_rows($result);
		echo $ans;
	}else{
		echo "0";
	}
?>