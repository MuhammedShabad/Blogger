<?php
	include '../includes/dbh.inc.php';
	$id = $_GET['postId'];
	$sql = "SELECT * from post where p_id='$id'";
	$resultPost=mysqli_query($conn,$sql);
?>
<html>
<head>
	<title>BlogOwRite</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/loggedinuser.css">
	<script type="text/javascript">
		var times=0;
		$(document).ready(function(){
		$("#searchedUser").keyup(function(){
			var query = $(this).val();
			if(query==''){
				$('.liststyle').fadeOut();
			}
			if(query != ''){
				$.ajax({
					url:"../search.php",
					method:"POST",
					data:{query:query},
					success:function(data){
						$("#searchedUserlist").fadeIn();
						$("#searchedUserlist").html(data);
					}
				});
			}
		});
		$(document).on('click','li',function() {
			$('#searchedUser').val($(this).text());
			$('#searchedUserlist').fadeOut();
		});

	});

	function commentLogin() {
		alert("Please Login to Comment on the Post");
	}
	</script>
<body>
	<div class="header">
		<span style="font-size: 30px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 40px;">O</span>wRite</span>
		<button class="btn btn-info" style="float: right; margin-top: 15px; margin-right: 10px;"><a href="../logsignup/login.php">Log In</a></button>
		<button class="btn btn-warning" style="float: right; margin-top: 15px; margin-right: 10px;"><a href="../logsignup/signup.php">Sign Up</a></button>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<form method="post" action="../searcheduserprofile.php">
				<div class="input-group mb-3 col-sm-12">
					  <input type="text" class="form-control" id="searchedUser" placeholder="Username" aria-label="username" aria-describedby="button-addon2" name="usernameofsearch">
					  <div class="input-group-append">
					  <input type="hidden" name="viewer" value="guest">
					    <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="searched">Search</button>
					  </div>
				</div>
				<div id="searchedUserlist" class="col-sm-4"></div>
			</form>
		</div>
	</div>
	<div class="card-style">
	<?php 
		if(mysqli_num_rows($resultPost)>0){
			$result = mysqli_fetch_array($resultPost);
			$postid = $result['p_id'];
			$sqldis = "SELECT count(p_postid) c from likes where p_postid='$postid'";
			$res1 = mysqli_query($conn,$sqldis);
			$result2 = mysqli_fetch_array($res1);
			$title = $result['p_title'];
			$content = $result['p_content'];
			$image = $result['p_image']; 
			$sqlComment = "SELECT * FROM comments where p_id='$postid'";
			$commentResult=mysqli_query($conn,$sqlComment);
	?>	
		<div>
			<h2 style="text-align: center; color: blue;"><?php echo $title;?></h2>
			<p><img src="../<?php echo $image;?>" style="float: right; width: 250px; margin: 5px;"><?php echo $content;?></p>
			<button class="btn btn-primary" style="margin-left: 30px;" onclick="commentLogin()">Comment</button>
		</div>
		<div class="listOFComment" style="clear: both; margin-left:20px;">
			<h2 style="color: green; text-align: center;" >Comments</h2>
			<?php 
				if(mysqli_num_rows($commentResult)>0){

					while($row=mysqli_fetch_array($commentResult)){
			?>	
				
				<div>
					<h3 style="color: blue;"><?php echo $row['c_username'];?></h3>
					<p style="margin-left: 40px;"><?php echo $row['c_content'];?></p>
				</div>
			<?php			
					}
				}
			}
			?>
			
		</div>
	</div>
</body>