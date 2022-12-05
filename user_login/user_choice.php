<?php
		if (isset($_GET['username'])) 
		{ 
			$username = $_GET['username'];
		}
		else
		{
			$username = ' ';
		}
?>
		

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome User</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">
</head>
<body style = "flex-direction: column">
    <h2>Entertainment Rating System</h2>
	<h2>Welcome <?php echo $username; ?></h2>
	<form style = "width: 200px" action="user_all_entertainment.php"  method="post">
	<button style = "float:middle"  type="submit">View All Entertainment
	</button>	
	</form>
	<form style = "width: 200px" action="user_subscription.php"  method="post">
	<button style = "float:middle ; width : 120px" type="submit">Subscription
	</button>	
	</form>
	<form style = "width: 200px" action="user_make.php"  method="post">
	<button style = "float:middle; width: 120px"  type="submit">Make a Post
	</button>	
	</form>

	<br><br>
	<a href="./../index.php">Link to Main Page</a>
	
</body>
</html>