<?php
	session_start();
	$usertosearch='';
	$username='';
	include 'includes/dbh.inc.php';
	if(isset($_POST["searched"])){
		$username = $_POST['viewer'];
		$usertosearch = $_POST['usernameofsearch'];
		$sql = "SELECT * from blogger where blog_username='$usertosearch'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_array($result);
			$fname=$row['blog_first'];
			$lname=$row['blog_last'];
			$email=$row['blog_email'];
			$phone=$row['blog_phone'];
		}
	}
	$follow=0;
	if($usertosearch!=''){
		$sqlfollow = "SELECT * from follow where f_whom='$usertosearch' and f_who='$username'";
		$result = mysqli_query($conn,$sqlfollow);
		if(mysqli_num_rows($result)>0){
			$follow=1;
		}else{
			$follow=0;
		}
	}
?>
<html>
<head>
	<title>BlogOwRite</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/loggedinuser.css">
	<script type="text/javascript">
		var s,follows=0;
		var user = "<?php echo $username;?>";
		function follow(namei) {
			if(user!='guest'){
				if($(".followbtn").text()=="Following"){
					follows=1;
					namei=namei+'1';
				}
				else{
					follows=0;
					namei=namei+'0';
				}
				$.ajax({
					url:"follow/follow.php",
					method:"POST",
					data:{whom:namei},
					success:function(data){
						if(follows==0)
							$(".followbtn").html("Following");
						else
							$(".followbtn").html("Follow");
					}
				});
			}else{
				alert("Please Login to Follow");
			}
		}
	</script>
</head>
<body>
	<div class="header">
		<span style="font-size: 30px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 40px;">O</span>wRite</span>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<form method="post" action="searcheduserprofile.php">
				<div class="input-group mb-3 col-sm-12">
					  <input type="text" class="form-control" id="searchedUser" placeholder="Username" aria-label="username" aria-describedby="button-addon2" name="usernameofsearch">
					  <div class="input-group-append">
					    <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="searched">Search</button>
					  </div>
				</div>
				<div id="searchedUserlist" class="col-sm-4"></div>
			</form>
		</div>
		<div class="col-sm-2 offset-2">
			<button type="submit" onclick="follow(s='<?php echo $usertosearch;?>')" class="btn btn-primary followbtn"><?php if($follow==0)
			echo "Follow"; else
			echo "Following";?></button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 offset-2">
			<label style="font-size: 20px; font-weight: 600;">Name:</label>
		</div>
		<div class="col-sm-3 offset-1">
			<p style="font-size: 20px; font-weight: 400;"><?php echo $fname." ".$lname;?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 offset-2">
			<label style="font-size: 20px; font-weight: 600;">Phone Number:</label>
		</div>
		<div class="col-sm-3 offset-1">
			<p style="font-size: 20px; font-weight: 400;"><?php echo $phone;?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 offset-2">
			<label style="font-size: 20px; font-weight: 600;">Email:</label>
		</div>
		<div class="col-sm-3 offset-1">
			<p style="font-size: 20px; font-weight: 400;"><?php echo $email;?></p>
		</div>
	</div>
</body>
</html>