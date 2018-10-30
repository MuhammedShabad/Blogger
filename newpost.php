<?php
	session_start();
	$username = $_SESSION['b_username'];
	include 'includes/dbh.inc.php';
	$destinationFile='';
	if(isset($_POST['addpost'])){
		$title = $_POST['title'];
		$content = $_POST['content'];
		//$image = $_POST['file'];
		if(isset($_FILES['image'])){
		$image =  $_FILES['image'];
		print_r($image);
		$imagename = $_FILES['image']['name'];
		$fileExtension = explode('.', $imagename);
		$fileCheck = strtolower(end($fileExtension));
		$fileExtensionStored = array('png','jpg','jpeg');
		if(in_array($fileCheck, $fileExtensionStored)){
			$destinationFile = 'images/'.$imagename;
			move_uploaded_file($_FILES['image']['tmp_name'], $destinationFile);
			$sql = "INSERT into post (p_username,p_title,p_content,p_image) values ('$username','$title','$content','$destinationFile')";
			mysqli_query($conn,$sql);
			header("location:loggedInUser.php?PostAddedSuccessfully");
		}
	}else{
		move_uploaded_file($_FILES['image']['tmp_name'], $destinationFile);
		$sql = "INSERT into post (p_username,p_title,p_content,p_image) values ('$username','$title','$content','$destinationFile')";
		mysqli_query($conn,$sql);
		header("location:loggedInUser.php?success");}
	}
	if(isset($_POST['Id'])){
		$postId = $_POST['Id'];
		$sqli = "SELECT * from post where p_id='$postId'";
		$ans=mysqli_query($conn,$sqli);
		$res='';
		if($row=mysqli_fetch_array($ans)){
			$res.=$row['p_id'];
			$res.="#";
			$res.=$row['p_title'];
			$res.="#";
			$res.=$row['p_content'];
			echo $res;
		}
	}
	if(isset($_POST['editpost'])){
		$oldId=$_POST['id'];
		$rem = "DELETE from post where p_id='$oldId'";
		mysqli_query($conn,$rem);
		$title = $_POST['title'];
		$content = $_POST['content'];
		//$image = $_POST['file'];
		if(isset($_FILES['image'])){
		$image =  $_FILES['image'];
		$imagename = $_FILES['image']['name'];
		$fileExtension = explode('.', $imagename);
		$fileCheck = strtolower(end($fileExtension));
		$fileExtensionStored = array('png','jpg','jpeg');
		if(in_array($fileCheck, $fileExtensionStored)){
			$destinationFile = 'images/'.$imagename;
			move_uploaded_file($_FILES['image']['tmp_name'], $destinationFile);
			$sql = "INSERT into post (p_username,p_title,p_content,p_image) values ('$username','$title','$content','$destinationFile')";
			mysqli_query($conn,$sql);
			header("location:loggedInUser.php?PostAddedSuccessfully");
		}
	}else{
		move_uploaded_file($_FILES['image']['tmp_name'], $destinationFile);
		$sql = "INSERT into post (p_username,p_title,p_content,p_image) values ('$username','$title','$content','$destinationFile')";
		mysqli_query($conn,$sql);
		header("location:loggedInUser.php?success");}
	}
?>