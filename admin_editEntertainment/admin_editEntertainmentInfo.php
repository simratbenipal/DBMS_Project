<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Entertainment Information</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">
</head>
<body style = "flex-direction: column; justify-content:normal">
	<h2>Add/Edit Entertainment Information </h2>

	<form>
		<form style = "width: 200px" action="admin_AddNewAdmin.php"  method="post">
			<button name = "edit_production_company" type = "submit">Edit Production Company Database</button>

		<form style = "width: 200px" action="admin_AddNewAdmin.php"  method="post">
			<button name = "edit_director" type = "submit">Edit Director Database</button>
		
		<br><br><br>
		<form style = "width: 200px" action="admin_AddNewAdmin.php"  method="post">
			<button name = "edit_hires" type = "submit">Edit Hires Database</button>
	
	</form>	

	<h2>Add/update production company </h2>
	<h2>add/update director </h2>
		<h2>update hires table </h2>


	<form>

		<button name = "edit_entertainment" type = "submit">Edit Entertainment Database</button>

		<button name = "edit_available_IN" type = "submit">Edit Available IN</button>
		<br><br><br>

		<button name = "edit_available_ON" type = "submit">Edit Available ON</button>

	</form>	

	<h2>add/update entertainment </h2>
		<h2>update available IN table </h2>
		<h2>update available ON table </h2>


		
	<form style = "width: 200px" action="admin_editActor.php"  method="post">
		<button name = "edit_actor" type = "submit">Edit Actor Information</button>
	</form>	

	<h2>add/update actor </h2>
		<h2>update acts_in table </h2>


	<a href="./../admin_choice.php">Link to Previous Page</a>	
</body>
</html>