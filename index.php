<html>
<head>
	<title>BlogOwRite</title>
</head>
<body>
	<div class="header">
		<span style="font-size: 25px; color: blue; margin-left: 14px;">Blog<span style="color: orange; font-size: 32px;">O</span>wRite</span>
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
</body>
</html>