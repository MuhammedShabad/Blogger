<?php
	session_start();
	include '../includes/dbh.inc.php';
	$postId = $_POST['postId'];
	$deleteSql = "DELETE  from post where p_id='$postId'";
	mysqli_query($conn,$deleteSql);
	$deleteComment = "DELETE from comments where p_id = '$postId'";
	mysqli_query($conn,$deleteComment);
	$deletelikes = "DELETE  from likes where p_postid = '$postId'";
	mysqli_query($conn,$deletelikes);
	echo "Post deleted successfully";
?>