<?php 
	session_start();
	$whoCommented=$_SESSION['b_username'];
	include 'includes/dbh.inc.php';
	if(isset($_POST['comment'])){
		//$usernamewho = $_POST['whoCommented'];
		$id = $_POST['id'];
		$content = $_POST['content'];
		$insertcomment = "INSERT into comments(c_username,p_id,c_content) values('$whoCommented','$id','$content')";
		$sqluser="SELECT p_username as u from post where p_id='$id'";
		$result=mysqli_query($conn,$sqluser);
		$row=mysqli_fetch_array($result);
		$accountHolder = $row['u'];
		$notificationcomment="INSERT into notification(n_author,n_commenter,n_comment,n_like) values ('$accountHolder','$whoCommented','1','0')";
		mysqli_query($conn,$notificationcomment);
		mysqli_query($conn,$insertcomment);
		header("location:loggedInUser.php");
	}
?>

