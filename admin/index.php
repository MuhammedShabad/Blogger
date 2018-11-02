<?php 
	session_start();
	include '../includes/dbh.inc.php';
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
	<link rel="stylesheet" type="text/css" href="../css/adminstyle.css">
</head>
<style type="text/css">
	
</style>
<script type="text/javascript">
	var uname;
	function logout(){
		window.location.href='../includes/logout.inc.php';
	}
	function ViewUser(){
		var first,last,email,phone;
		var i=0;
		var ta = '<table class="table"><thead class="thead-dark"><tr><th scope="col-1">Sr No.</th><th scope="col-2">First Name</th><th scope="col-2">Last Name</th><th scope="col-2">Email</th><th scope="col-2">Username</th><th scope="col-2">Phone</th><th scope="col-1">Permission</th></tr></thead><tbody>';
		<?php 
			$user = "SELECT * from blogger";
			$result = mysqli_query($conn,$user);
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_array($result)){
					?>
					i++;
					first="<?php echo $row['blog_first'];?>";
					last="<?php echo $row['blog_last'];?>";
					email="<?php echo $row['blog_email'];?>";
					phone="<?php echo $row['blog_phone'];?>";
					username = "<?php echo $row['blog_username'];?>";
					permission = "<?php echo $row['blog_permission']; ?>";

					if(permission==1){
						var row = '<tr><th scope="row">'+i+'</th><th scope="row">'+first+'</th><th scope="row">'+last+'</th><th scope="row">'+email+'</th><th scope="row">'+username+'</th><th scope="row">'+phone+'</th><th scope="row"><input type="checkBox" checked onClick="gave(\''+ permission + username +'\')"></th></tr>';
					}else{
						var row = '<tr><th scope="row">'+i+'</th><th scope="row">'+first+'</th><th scope="row">'+last+'</th><th scope="row">'+email+'</th><th scope="row">'+username+'</th><th scope="row">'+phone+'</th><th scope="row"><input type="checkBox" onClick="gave(\''+ permission + username +'\')"></th></tr>';
					}
					ta = ta + row;
					<?php
				}
			}
		?>
		ta=ta+"</tbody></table>";
		$(".layout").html(ta);
	}
	function gave(user){
		window.location.href="setPermission.php?uname="+user;
	}
	function ViewPost(){
		var ans="<div class='row card-style'><?php $displaySql = "SELECT * from post";$res = mysqli_query($conn,$displaySql);
		$row = mysqli_num_rows($res);
		$i=0;
		while($result = mysqli_fetch_array($res)){
			$postid = $result['p_id'];
	?>
		<div class='card text-dark col-sm-6 col-xs-12 col-md-3'><?php
			if($result['p_image']!=''){ ?><img class='card-img' src='../<?php echo $result['p_image'];?>' alt='Card image' height=180px><?php
  				}
  			?>
  			<div class='card-body c'><h4 class='card-title'><?php echo $result['p_title'];?></h4><p class='card-text'><?php echo $result['p_content'];?></p></div><div class='card-footer text-dark'><p class='card-text'><button class='btn-sm btn-danger' onclick='deletePost(<?php echo $postid;?>)'>Delete</button></p></div></div><?php
		}
	?>
	</div>";
	$(".layout").html(ans);
	}
	function deletePost(id){
		$.ajax({
			url:"deletePost.php",
			method:"POST",
			data:{postId:id},
			success:function(data){
				alert(data);
				location.reload();
			}
		});
	}
</script>
<body>
	<div class="header">
		<span style="font-size: 30px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 40px;">O</span>wRite</span>
		<button class="btn btn-primary logout" onclick="logout()">Logout</button>
		<hr>
	</div>
	<div class="navigation">
		<ul>
			<li><button class="btn btn-primary" onclick="ViewUser()">View User</button></li>
			<li><button class="btn btn-primary" onclick="ViewPost()">View Post</button></li>
		</ul>
	</div>
	<div class="layout">
	</div>
</body>
</html>