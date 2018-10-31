<?php
	session_start();
	include 'includes/dbh.inc.php';
	$username = $_SESSION['b_username'];
	$id=$_GET['postId'];
	$sql = "SELECT * from post where p_id='$id'";
	$resultPost=mysqli_query($conn,$sql);
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
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/loggedinuser.css">
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
	function comment(i){
		window.location.href="comment.php?id="+i;	
	}
	function notification(){
		times++;
		$.ajax({
			url:"notification.php",
			method:"post",
			data:{times:times},
			success:function(data){
				//$(".d").html("");
				var a='<div class="dropdown col-sm-1"><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Notification</button>'+data+'</div>';
				$(".d").html(a);
			}
		});
	}
	function fullpost(i) {
		window.location.href='fullpost.php?postId='+i;
	}
	</script>
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
		<div class="col-sm-2 ">
			<button class="btn btn-info" onclick="mypost()">My Post</button>
		</div>
		<div class="d">
			<div class="dropdown col-sm-1">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" onclick="notification()">Notification</button>
			</div>
		</div>
		<div class="newPost offset-1">
			<img src="images/edit.png" width="34px;" style="float: right;" onclick="newPost()">
		</div>
	</div>
	<div class="form"></div>
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
			<p><img src="<?php echo $image;?>" style="float: right; width: 250px; margin: 5px;"><?php echo $content;?></p>
			<button class="btn btn-primary" style="margin-left: 30px;" data-toggle="modal" data-target="#myModal<?php echo $postid;?>">Comment</button>
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
			?>
			
		</div>
		<div>
			<form method="post" action="comment.php">
				<div class="modal fade" id="myModal<?php echo $result['p_id'];?>" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <h4 class="modal-title">Comment on <?php echo $result['p_title'];?></h4>
				        </div>
				        <div class="modal-body">
				          <textarea name="content" rows=4 style="width: 100%";></textarea>
				          <input type="hidden" name="id" value="<?php echo $result['p_id'];?>">
				          <input type="hidden" name="whoCommented" value="<?php echo $username;?>">
				        </div>
				        <div class="modal-footer">
				        	<button type="submit" name="comment" class="btn btn-success">Comment</button>
				        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        </div>
				      </div>
				    </div>
				</div>
			</form>
		</div>
	<?php
		}
	?>
	</div>
</body>
<script type="text/javascript">
	
</script>
</html>
