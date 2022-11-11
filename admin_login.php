<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ADMIN LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="admin_login_verify.php" method="post">
		<h2>Enter your admin username and password</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Admin User Name</label>	
		<input type="text" name="uname" placeholder="Enter admin user uame"><br>

		<label>Admin Password</label>	
		<input type="password" name="password" placeholder="Enter admin password"><br>

		<button type="submit">Admin Login</button>
	</form>
</body>
</html>