<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Entertainment Information</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">

	<style>
		<?php //https://www.w3schools.com/cssref/sel_class.php ?>
		p.goodData
		{
			background: #a3dd94;
			color: #ffffff;
			padding: 10px;
			width: 95%;
			border-radius: 5px;
			margin: 20px auto;
		}
</style>
</head>
<body style = "flex-direction: column; justify-content:normal">
	<h2>Editing Entertainment Information</h2>
	<h2>Current Entertainment information in the System</h2>
	
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT E.eid, E.name AS Ename, E.type, E.rating, E.date, PC.name AS PC_name, PC.address,D.ssn, D.fname, D.lname FROM entertainment AS E, productioncompany AS PC, director as D WHERE E.prod_pid = PC.pid AND E.dir_ssn = D.ssn");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>EID</th>
			<th>Name</th>
			<th>Type</th>
			<th>Rating</th>
			<th>Release Date</th>
			<th>Production Company, Location</th>
			<th>Director Name</th>
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['eid'] . "</td>";
			echo "<td>" . $row['Ename'] . "</td>";
			echo "<td>" . $row['type'] . "</td>";
			echo "<td>" . $row['rating'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
		   	echo "<td>" . $row['PC_name'] ." , " . $row['address'] .  "</td>";
		   	echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
			echo "</tr>";

		}
		echo "</table>";

	?>
	<br><br>
	

	<form style = "width: 200px" action=""  method="post">
	<button name = "addNewEntertainment" style = "float:middle"  type="submit">Add New Entertainment
	</button>
	</form>
	

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteEntertainment" type="submit">Delete an Entertainment</button>
	</form>	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateEntertainment" type="submit">Update Entertainment</button>
	</form>	

	
	<?php
		if (isset($_POST['addNewEntertainment'])) 
		{
			//ask for unique eid
			//ask for name
			//drop down for type
			//drop down for rating
			//date released
			//production company (from existing)
			//director (from existing)
			echo "<h2>Adding a New Entertainment</h2>";
			echo "<form action = \"\" method = \"post\">";
			
			echo "<label>New Entertainment ID</label>";
			echo "<input type=\"number\" name=\"newEID\" placeholder=\"Enter EID (xxxx)\"><br>";
			
			echo "<label>Name</label>";
			echo "<input type=\"text\" name=\"newName\" placeholder=\"Enter Name\"><br>";
			
			//https://www.w3schools.com/tags/tag_select.asp
			echo "<label>Select Type</label>";
			echo "<select name = \"type\" id=\"type\">" ;
			echo "<option value= \"Sci-Fi\"> Sci-Fi </option>";
			echo "<option value= \"Fiction\"> Fiction </option>";
			echo "<option value= \"Action\"> Action </option>";
			echo "<option value= \"Comedy\"> Comedy </option>";
			echo "</select>";
			echo "<br>";

			echo "<label>Rating&nbsp&nbsp</label>";
			echo "<select name = \"entertainment_rating\" id=\"entertainment_rating\">" ;
			echo "<option value= \"0\"> 0 (Default)</option>";
			echo "<option value= \"1\"> 1 </option>";
			echo "<option value= \"2\"> 2 </option>";
			echo "<option value= \"3\"> 3 </option>";
			echo "<option value= \"4\"> 4 </option>";
			echo "<option value= \"5\"> 5 </option>";
			echo "</select>";
			echo  "<br>";echo  "<br>";

			echo "<label>Rating&nbsp&nbsp</label>";
			echo "<input type = \"date\" id = \"release_date\" name = \"release_date\" value = \"2018-07-22\" min = \"2018-01-01\" max = \"2018-12-31\">";

			//since director and production company are linked 
			$result = mysqli_query($connection, "SELECT * FROM hires, productioncompany, director WHERE prod_pid = pid AND director_ssn = ssn");
			echo "<label>Select Prodcution Company and Director</label>";
			echo "<select name = \"pc_dir\" id=\"pc_dir\">" ;
			echo  "<br>";
			while($row = mysqli_fetch_array($result))
			{
				echo "<option value= \"" . $row['pid'] . "," . $row['ssn'] . "\">". $row['name'] . " , " . $row['fname'] . " " . $row['fname'] . " </option>";
			}

			echo "</select>";
			echo  "<br>";echo  "<br>";

			echo "<button type = \"submit\"> Add Data into Database</button>";
			echo "</form>";
		}

		if ((isset($_POST['newEID'])) && (isset($_POST['newName'])) && (isset($_POST['type'])) && (isset($_POST['entertainment_rating'])) && (isset($_POST['release_date'])) &&  (isset($_POST['pc_dir'])))
		{
			$newEID 	= $_POST['newEID'];
			$newName 	= $_POST['newName'];
			$type 		= $_POST['type'];
			$entertainment_rating = $_POST['entertainment_rating'];
			$release_date = $_POST['release_date'];
			$pc_dir			= $_POST['pc_dir'];
			//$pc_dir --> production company id and director ssn
			//these must be separated based on ',' 

            //https://www.geeksforgeeks.org/php-explode-function/
            $splittedString = explode(",", $pc_dir);
            $prodPID = $splittedString[0];
            $director_ssn = $splittedString[1];

			//check if the values are correct
			//ADDING INTO ENTERTAINMENT TABLE
			echo "<form>";
			if(str_contains($newName, ';')|| str_contains($newName, '=') || str_contains($newName, '--')|| str_contains($newName, '  ') ||  str_contains($newName, '\\') )
			{
				echo "<p class = \"error\">";
				echo "Invalid characters in Name<br> Enter Data Again</p>";
			}
			else if(empty($newEID)|| empty($newName))
			{
				echo "<p class = \"error\">";
				echo "Cannot have empty Name or EID<br> Enter Data Again</p>";
			}
			else if (strlen($newEID) < 5)
			{
				echo "<p class = \"error\">";
				echo "EID should have at least 4 numbers <br> Enter Data Again</p>";
			}
			else
			{
				//Add data into entertainment table
				//data is good, add to sql database
				$sql_insert = "INSERT INTO entertainment (eid, name, type, rating, date, prod_pid, dir_ssn) VALUES('$newEID','$newName', '$type' , '$entertainment_rating' , '$release_date' , '$prodPID' , '$director_ssn' )";
				try
				{
					mysqli_query($connection, $sql_insert);
					echo "<form>";
					echo "<p class = \"goodData\">";
					echo "Data added successfully to the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editEntertainment.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, please check the data and enter again</p>";
					//header("Location: admin_editUserInfo.php");
					//echo $e;
				}	
			}
			echo "</form>";
		}
	?>

	<?php
		if (isset($_POST['deleteEntertainment'])) 
		{
			echo "<h2>Deleting an Entertainment</h2>";
			//show a drop down of existing entertainment
			//have a checkbox to make sure 
			//delete from database
			//data is good, add to sql database
			
			$allEntertainment = mysqli_query($connection, "SELECT * FROM entertainment");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Entertainment to delete : </label>";
			echo "<select name = \"selectedEntertainment\" id=\"selectedEntertainmentId\">" ;
			
			while($row = mysqli_fetch_array($allEntertainment))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['eid']. "> (".  $row['eid'] .") ". $row['name'] . "</option>";
			}
			echo "</select>";
			echo "<br><br>";
			echo "<label for = \"checkbox\"> Do you want to remove the selected Entertainment : </label>";
			echo  "<input type = \"checkbox\" name = \"checkbox\" id = \"checkedId\" </input> ";
			echo "<button type = \"submit\">Delete user from Database</button>";
			echo "</form>";
			echo "<br>";
		}

		if (isset($_POST['selectedEntertainment']) )
		{
			echo "<form>";
			$toBeDetetedEntertainment 	= $_POST['selectedEntertainment'];
			if(!isset($_POST['checkbox']))
			{
				echo "<p class = \"error\">";
				echo "Checkbox not selected<br>";
				echo "Entertainment not deleted<br>";
				echo "</p>";
			}
			else if (strcmp ($toBeDetetedEntertainment, "1") == 0)
			{
				echo "<p class = \"error\">";
				echo "Cannot delete 'The Invincible'<br>";
				echo "</p>";
			}
			else
			{
				//data is good, delete from database
				$sql_delete = "DELETE FROM entertainment WHERE eid = '$toBeDetetedEntertainment'";
				try
				{
					mysqli_query($connection, $sql_delete);
					echo "<p class = \"goodData\">";
					echo "Entertainment deleted successfully from the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");
					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editEntertainment.php\"  ethod = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to delete the Entertainment<br>Check for Foreign Key Constraints</p>";
					//header("Location: admin_editUserInfo.php");
				}	
			}
			echo "</form>";
		}	
	?>

	<?php
		if (isset($_POST['updateEntertainment'])) 
		{
			echo "<h2>Update an Entertainment Information</h2>";
			$allEntertainment = mysqli_query($connection, "SELECT * FROM entertainment");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Entertainment: &nbsp  &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp</label>";
			echo "<select name = \"selectedEntertainmentDelete\" id=\"selectedEntertainment\">" ;
			
			while($row = mysqli_fetch_array($allEntertainment))
			{
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['eid']. "> (".  $row['eid'] .") ". $row['name'] . "</option>";
			}
			echo "</select>";
			echo "<br>";
			echo "<br>";
			echo "<button type = \"submit\">Edit information</button>";
			echo "</form>";
			
			echo "<br>";
		}
	
		if (isset($_POST['selectedEntertainmentDelete'])) 
		{
			$selectedEntertainmentEID = $_POST['selectedEntertainmentDelete'];
			echo "<h2>Editing </h2>";
			echo $selectedEntertainmentEID;
			
		}
	?>
	<br><br>

	<a href="admin_editInfo.php">Link to Previous Page</a>	<br><br>
	<a href="./../index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>