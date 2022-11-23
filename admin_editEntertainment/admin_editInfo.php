<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Information</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">
</head>
<body style = "flex-direction: column; justify-content:normal">
	<h2>Add/Edit Information in the System </h2>

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

	<br><br><br><br>

	<div>
		<br>
		<form style = "width: 300 ;height:170px; float:right" action="admin_editEntertainment.php"  method="post">
		<label>Can edit information about Entertainment, including which platform this entertainment is available (AVAILABLE_ON) and in which countries this entertianment is available (AVAILABLE_IN)</label> <br><br>
			<button name = "edit_entertainment" style = "float:none" type = "submit">Edit Entertainment</button>
			<br><br>
		</form>
		<br><br><br><br><br><br><br>
	</div>

	<br><br><br><br>

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