<?php
   	session_start();
   	include 'dbh.inc.php';
  	$username=$_SESSION['b_username'];
   	$delete = "DELETE from notification where n_author='$username'";
	mysqli_query($conn,$delete);
    session_unset();
    session_destroy();
    header("Location: ../logsignup/login.php");
    exit();
?>