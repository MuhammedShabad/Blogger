<?php
include '../includes/dbh.inc.php';
$user="guest";
?>
<html>
<head>
	<title>BlogOwRite</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/loggedinuser.css">
</head>
<style type="text/css">
	.c{
		margin-right: 0px;
		margin-left: 0px;
		text-overflow: ellipsis;
		white-space: nowrap;
		overflow: hidden;
		height: 100px;
	}
</style>
<script type="text/javascript">
	function commentLogin() {
		alert("Please Login/Signup to Comment");
	}
	function fullpost(i) {
		window.location.href='fullpostviewer.php?postId='+i;
	}
	function like(i){
		alert("Please Login to Like the Post")
	}
</script>
<body>
	<div class="header">
		<span style="font-size: 25px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 32px;">O</span>wRite</span>
		<button class="btn btn-info" style="float: right; margin-top: 15px; margin-right: 10px;"><a href="../logsignup/login.php">Log In</a></button>
		<button class="btn btn-warning" style="float: right; margin-top: 15px; margin-right: 10px;"><a href="../logsignup/signup.php">Sign Up</a></button>
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
	</div>
	<div class="row card-style">
	<?php 
		$displaySql = "SELECT * from post";
		$res = mysqli_query($conn,$displaySql);
		$row = mysqli_num_rows($res);
		$i=0;
		while($result = mysqli_fetch_array($res)){
			$postid = $result['p_id'];
			$sqldis = "SELECT count(p_postid) c from likes where p_postid='$postid'";
			$res1 = mysqli_query($conn,$sqldis);
			$result2 = mysqli_fetch_array($res1);
	?>
		<div class="card text-dark col-sm-6 col-xs-12 col-md-3">
			<?php
			if($result['p_image']!=''){ ?>
  			<img class="card-img" src="../<?php echo $result['p_image'];?>" alt="Card image" height=180px>
  			<?php
  				}
  			?>
  			<div class="card-body c">
    			<h4 class="card-title"><?php echo $result['p_title'];?></h4>
    			<p class="card-text"><?php echo $result['p_content'];?></p>
  			</div>
  			<div class="card-footer text-dark">
    			<p class="card-text"><i class="fa fa-thumbs-up count<?php echo $result['p_id'];?>" onclick="like(<?php echo $result['p_id'];?>)" style="margin-right: 10px; "><?php echo $result2['c'];?></i><button class="btn-sm btn-primary"  onclick="commentLogin()">Comment</button><button style="float: right;" class="btn btn-info" onclick="fullpost(<?php echo $result['p_id'];?>)">Read More</button></p>
			</div>
		</div>
	<?php
		}
	?>
	</div>
</body>
</html>