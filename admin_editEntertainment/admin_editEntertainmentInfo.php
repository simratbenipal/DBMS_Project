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

	<div>
	<br>
		<form style = "width: 200px ;height:120px; float:left" action="admin_editProdCompany.php"  method="post">
			<button name = "edit_production_company" type = "submit">Edit Production Company Database</button>
		</form>
		<form style = "width: 200px ; height:120px ; float:right" action="admin_editHIRES.php"  method="post">
			<button name = "edit_HIRES" action="admin_editHIRES.php"type = "submit">Edit HIRES Database</button>
		</form>
		<form style = "width: 200px ; height:120px ; float:right" action="admin_editDirector.php"  method="post">
			<button name = "edit_director" action="admin_editDirector.php"type = "submit">Edit Director Database</button>
		</form>

	
		<br><br><br><br><br><br><br>
		
	</div>

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
	<br>
	<br>

	<a style = "align: centre" href="./../admin_choice.php">Link to Previous Page</a>
</body>
</html>