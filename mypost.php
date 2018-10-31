<?php
	session_start();
	include 'includes/dbh.inc.php';
	$fname = $_SESSION['b_first'];
	$lname = $_SESSION['b_last'];
	$username = $_SESSION['b_username'];
	$email = $_SESSION['b_email'];
	$phone = $_SESSION['b_phone'];
	include 'includes/dbh.inc.php';
	$sqlfollowing = "SELECT * from follow where f_who='$username'";
	$result = mysqli_query($conn,$sqlfollowing);
	$following = mysqli_num_rows($result);
	$sqlfollower = "SELECT * from follow where f_whom='$username'";
	$result = mysqli_query($conn,$sqlfollower);
	$follower = mysqli_num_rows($result);
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
		$(document).ready(function(){
		$("#searchedUser").keyup(function(){
			var query = $(this).val();
			if(query==''){
				$('.liststyle').fadeOut();
			}
			if(query != ''){
				$.ajax({
					url:"search.php",
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
	function logout() {
		window.location.href='includes/logout.inc.php';
	}
	function mypost() {
		window.location.href='mypost.php';
	}
	function newPost(){
		$(".card-style").html('');	
		var formNew = "<h2 class='offset-4' style='margin-bottom:30px;'>Create New Post</h2><form method='post' action='newpost.php' enctype='multipart/form-data'><div class='form-group'><div class='row'><div class='col-sm-2 offset-2'><label for='post-title' class='control-label'>Title</label></div><div class='col-sm-4'><input type='text' class='form-control' name='title' id='post-title' placeholder='Title'></div></div><div class='row'><div class='col-sm-2 offset-2'><label for='post-content' class='control-label'>Content</label></div><div class='col-sm-4'><textarea class='form-control' name='content' rows='7'></textarea></div></div><div class='row'><div class='col-sm-2 offset-2'><label for='postimage' class='control-label'>Image</label></div><div class='col-sm-4'><input type='file' name='image' id='postimage'></div></div><button class='btn btn-success offset-5' name='addpost'>Submit</button></div></form";
		$(".form").html(formNew);
	}
	function like(i){
		window.location.href="like.php?id="+i;
	}
	function editPost(id){	
			$.ajax({
				url:"newpost.php",
				method:"POST",
				data:{Id:id},
				success:function(data){
					$(".card-style").html('');
					var arr=data.split("#");	
					var formNew = "<h2 class='offset-4' style='margin-bottom:30px;'>Edit the Post</h2><form method='post' action='newpost.php' enctype='multipart/form-data'><div class='form-group'><div class='row'><div class='col-sm-2 offset-2'><label for='post-title' class='control-label'>Title</label></div><div class='col-sm-4'><input type='text' class='form-control' name='title' id='post-title' placeholder='Title' value="+arr[1]+"></div></div><div class='row'><div class='col-sm-2 offset-2'><label for='post-content' class='control-label'>Content</label></div><div class='col-sm-4'><textarea class='form-control' name='content' rows='7'>"+arr[2]+"</textarea></div></div><div class='row'><div class='col-sm-2 offset-2'><label for='postimage' class='control-label'>Image</label></div><div class='col-sm-4'><input type='file' name='image' id='postimage'></div></div><input type='hidden' name='id' value="+arr[0]+"><button class='btn btn-success offset-5' name='editpost'>Submit</button></div></form";
					$(".form").html(formNew);
				}
			});
		
	}
	function fullpost(i) {
		window.location.href='fullpost.php?postId='+i;
	}
	</script>
<style type="text/css">
	.c{
		margin-right: 0px;
		margin-left: 0px;
		text-overflow: ellipsis;
		white-space: nowrap;
		overflow: hidden;
	}
</style>
</head>
<body>
	<div class="header">
		<span style="font-size: 30px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 40px;">O</span>wRite</span>
		<button class="btn btn-primary logout" onclick="logout()">Logout</button>
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
		<div class="col-sm-3">
			<button class="btn btn-primary followings">Following <?php echo " ".$following; ?> </button>
			<button class="btn btn-primary">Follower <?php echo " ".$follower; ?></button>
		</div>
		<div class="col-sm-2 offset-1">
			<button class="btn btn-info" onclick="mypost()">My Post</button>
		</div>
		<div class="newPost col-sm-1 offset-1">
			<img src="images/edit.png" width="35px;" style="float: right;" onclick="newPost()">
		</div>
	</div>
	<div class="form"></div>
	<div class="row card-style">
	<?php 
		$displaySql = "SELECT * from post where p_username='$username'";
		$res = mysqli_query($conn,$displaySql);
		$row = mysqli_num_rows($res);
		$i=0;
		while($result = mysqli_fetch_array($res)){
			$postid = $result['p_id'];
			$sqldis = "SELECT count(p_postid) c from likes where p_postid='$postid'";
			$res1 = mysqli_query($conn,$sqldis);
			$result2 = mysqli_fetch_array($res1);
	?>
		<div class="card text-dark col-sm-3">
			<?php
			if($result['p_image']!=''){ ?>
  			<img class="card-img" src="<?php echo $result['p_image'];?>" alt="Card image" height=180px>
  			<?php
  				}
  			?>
  			<div class="card-body c">
    			<h4 class="card-title"><?php echo $result['p_title'];?></h4>
    			<p class="card-text"><?php echo $result['p_content'];?></p>
  			</div>
  			<div class="card-footer text-dark">
    			<p class="card-text"><i class="fa fa-thumbs-up count<?php echo $result['p_id'];?>" onclick="like(<?php echo $result['p_id'];?>)"><?php echo $result2['c'];?></i><button onclick="editPost(<?php echo $result['p_id'];?>)" class="btn btn-primary edit" style="margin-left: 20px;">Edit</button><button style="float: right;" class="btn btn-info" onclick="fullpost(<?php echo $result['p_id'];?>)">Read More</button></p>
			</div>
		</div>
	<?php
		}
	?>
	</div>
</body>
<script type="text/javascript">
	
</script>
</html>