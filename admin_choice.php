<?php
		if (isset($_GET['username'])) 
		{ 
			$username = $_GET['username'];
		}
?>
		

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome Admin</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style = "flex-direction: column">
	<h2>Welcome <?php echo $username; ?></h2>
	<form style = "width: 200px" action="admin_editUserInfo.php"  method="post">
	<button style = "float:middle"  type="submit" action="user_login.php">Edit User Information
	</button>	
	</form>
	
	<form style = "width: 200px" action="admin_editEntertainmentInfo.php"  method="post">
	<button type="submit">Edit Entertainment Information</button>
	</form>	
	
</body>
</html>