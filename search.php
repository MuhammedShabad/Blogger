<?php
	include 'includes/dbh.inc.php';
	if(isset($_POST["query"])){
		$output = '';
		$query = "SELECT * from blogger where blog_username like '%". $_POST["query"] ."%'"; 
		$result = mysqli_query($conn,$query);
		$output = '<ul class="liststyle">';
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
				$output .= '<li>'.$row["blog_username"].'</li>';
			}
		}else{
			$output .='<li>No User with such username</li>';
		}
		$output .='</ul>';
		echo $output; 
	}
?>