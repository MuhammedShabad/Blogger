<?php 
	session_start();
	include 'includes/dbh.inc.php';
	$username=$_SESSION['b_username'];
	$times=$_POST['times'];
	$output='';
	$insert = "SELECT * from notification where n_author = '$username'";
	$result=mysqli_query($conn,$insert);
	$count = mysqli_num_rows($result);
	if($count>0){
		$output='<ul class="dropdown-menu" style="width:250px;">';
		while($row=mysqli_fetch_array($result)){
			if($row['n_like']==1)
				$output.='<li>'.$row['n_commenter'].' liked your Post.</li>';
			else
				$output.='<li>'.$row['n_commenter'].' commented your Post.</li>';
		}
		$output.='</ul>';
	}

	echo $output;
?>