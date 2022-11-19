<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login Page</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">
</head>
<body>
	<form action=".php" method="post">
		<h2>Enter you Username and password</h2>
		<h2>Under construction</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>User Name</label>	
		<input type="text" name="uname" placeholder="User Name"><br>

		<label>Password</label>	
		<input type="password" name="password" placeholder="Password"><br>
		<button type="submit" action="login.php" >User Login Page</button>
		<button type="submit">Admin Login Page</button>

		<!--<button type="submit">Login</button> -->
	</form>
</body>
</html>