<?php
	session_start();
	include 'includes/dbh.inc.php';
	$id = $_GET['id'];
	$username = $_SESSION['b_username'];	
	$check = "SELECT * from likes where p_username='$username' and p_postid='$id'";
	$res = mysqli_query($conn,$check);
	if(mysqli_num_rows($res)==0){
		$sql = "INSERT into likes(p_username,p_postid) values ('$username','$id')";
		mysqli_query($conn,$sql);
	}
	$sqluser="SELECT p_username as u from post where p_id='$id'";
	$result=mysqli_query($conn,$sqluser);
	$row=mysqli_fetch_array($result);
	$author = $row['u'];
	$notificationcomment="INSERT into notification(n_author,n_commenter,n_comment,n_like) values ('$author','$username','0','1')";
		mysqli_query($conn,$notificationcomment);
	header("location:loggedInUser.php");
?>