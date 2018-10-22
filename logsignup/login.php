<?php
	session_start();

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Login </title>
	<link rel="stylesheet" href="../css/login.css">
	<style type="text/css">
		.verify p{
  			text-align: center;
		  	font-size: 20px;
	  		color: red;
	}
	</style>
</head>
<body class="bgimg">
	<div class="container">
		<div>
			<h1>BlogOwRite</h1>
		</div>
		<div class="verify">
			<p><?php echo $_SESSION['msg'];?></p>
		</div>
		<div class="login-box">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
			<form action="../includes/login.inc.php" method="POST">
            <label for="email">Email</label>
			<br>
			<input type="email" id="email" name="email" required>
			<br>
			<label for="password">Password</label>
			<br>
			<input type="password" id="password" name="pwd" required>
			<br>
			<button type="submit" name="submit">Sign In</button>
			<br>
			<a href="signup.php"><p class="small">Register here</p></a>
            </form>
		</div>
	</div>
</body>

</html>