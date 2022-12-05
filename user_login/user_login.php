<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login Page</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">
</head>
<body>
	<form action="user_login_verify.php" method="post">
		<h2>Enter you Username and password</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>User Name</label>	
		<input type="text" name="uname" placeholder="User Name"><br>

		<label>Password</label>	
		<input type="password" name="password" placeholder="Password"><br>
		<button type="submit" >User Login Page</button>
		
		<!--<button type="submit">Login</button> -->
	</form>
</body>
</html>