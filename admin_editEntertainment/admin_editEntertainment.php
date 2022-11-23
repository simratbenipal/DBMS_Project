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
			<th>Date</th>
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
	<!--

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteActor" type="submit">Delete an Actor</button>
	</form>	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateExistingActor" type="submit">Add Data into ACTS_IN (under const)</button>
	</form>	
	-->
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

			echo $newEID;
			echo "<br>";
			echo $newName;	
			echo "<br>";
			echo $type;
			echo "<br>";
			echo $entertainment_rating;
			echo "<br>";
			echo $release_date;
			echo "<br>";
			echo $pc_dir;
			echo "<br>";
		
			
/*
			//https://www.geeksforgeeks.org/php-strlen-function/
			//https://www.w3schools.com/php/func_var_empty.asp
			if (empty($newSSN) || empty($newfname) || empty($newlname))
			{
				echo "<p class = \"error\">";
				echo "Values cannot be empty<br> Enter Data Again</p>";
			}
			else if (strlen($newSSN) < 12)
			{
				echo "<p class = \"error\">";
				echo "Enter a valid SSN<br> Enter Data Again</p>";
			}
			else
			{
				//https://www.php.net/manual/en/function.str-contains.php
				//should be good to prevent SQL injections
				//check for ;  =  -  ' '  \
				//if the username or password contains, then stop otherwise execute the query
				if(str_contains($newfname, ';')|| str_contains($newfname, '=') || str_contains($newfname, '-')|| str_contains($newfname, ' ') ||  str_contains($newfname, '\\') )
				{
					echo "<p class = \"error\">";
					echo "Invalid characters in First Name, try again<br>";
					echo "</p>";
				}
				else if(str_contains($newlname, ';')|| (str_contains ($newlname, '=')) || str_contains($newlname, '\\') ||  str_contains($newlname, ' ') || str_contains($newlname, '-'))
				{
					echo "<p class = \"error\">";
					echo "Invalid characters in Password, try again<br>";
					echo "</p>";
				}
				else if(str_contains($newSSN, ';')|| (str_contains ($newSSN, '=')) || str_contains($newSSN, '\\') ||  str_contains($newSSN, ' ') || str_contains($newSSN, '--'))
				{
					echo "<p class = \"error\">";
					echo "Invalid characters in SSN, try again<br>";
					echo "</p>";
				}
				else
				{
				//data is good, add to sql database
				$sql_insert = "INSERT INTO actor (ssn, fname, lname) VALUES('$newSSN','$newfname', '$newlname')";
				try
				{
					mysqli_query($connection, $sql_insert);
					echo "<p class = \"goodData\">";
					echo "Data added successfully to the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editActor.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, please check the data and enter again</p>";
					//header("Location: admin_editUserInfo.php");
					echo $e;
				}	
			}
			}
			*/
		}
	?>

	<!--
	<?php
		if (isset($_POST['deleteActor'])) 
		{
			echo "<h2>Deleting an Actor</h2>";
			//show a drop down of existing actors
			//have a checkbox to make sure 
			//delete from database
			
			$allActors = mysqli_query($connection, "SELECT * FROM actor");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Actor to delete : </label>";
			echo "<select name = \"selectedUser\" id=\"selectedUserId\">" ;
			
			while($row = mysqli_fetch_array($allActors))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['ssn']. "> (".  $row['ssn'] .") ". $row['fname'] ." ". $row['lname']."</option>";
			}
			echo "</select>";
			echo "<br><br>";
			echo "<label for = \"checkbox\"> Do you want to remove the selected User : </label>";
			echo  "<input type = \"checkbox\" name = \"checkbox\" id = \"checkedId\" </input> ";
			echo "<button type = \"submit\">Delete user from Database</button>";
			echo "</form>";
			echo "<br>";
		}

		if (isset($_POST['selectedUser']) )
		{
			$selectedUser 	= $_POST['selectedUser'];
			if(!isset($_POST['checkbox']))
			{
				echo "<p class = \"error\">";
				echo "Checkbox not selected<br>";
				echo "Actor not deleted<br>";
				echo "</p>";

			}
			else if (strcmp ($selectedUser, "1234") == 0)
			{
				echo "<p class = \"error\">";
				echo "Cannot delete 'John Doe'<br>";
				echo "</p>";
			}
			else
			{
				//data is good, delete from database
				$sql_delete = "DELETE FROM actor WHERE ssn = '$selectedUser'";
				try
				{
					mysqli_query($connection, $sql_delete);
					echo "<p class = \"goodData\">";
					echo "Actor deleted successfully from the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editActor.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to delete the actor<br>Check for Foreign Key Constraints</p>";
					//header("Location: admin_editUserInfo.php");
				}	
			}
		}	
	?>

	<?php
		if (isset($_POST['updateExistingActor'])) 
		{
			echo "<h2>Update an existing Actor Information</h2>";
			echo "<h5>(Updates ACTS_IN table)</h5>";
			//show list of users, then ask what you want to change and then do accordingly
			$allActors = mysqli_query($connection, "SELECT * FROM actor");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Actor: &nbsp  &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp</label>";
			echo "<select name = \"selectedActor\" id=\"selectedActor\">" ;
			
			while($row = mysqli_fetch_array($allActors))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['ssn']. "> (".  $row['ssn'] .") ". $row['fname'] ." ". $row['lname']."</option>";
			}
			echo "</select>";
			
			echo "<br>";
			
			//show list of users, then ask what you want to change and then do accordingly
			$allActors = mysqli_query($connection, "SELECT * FROM entertainment");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Entertainment: </label>";
			echo "<select name = \"selectedEntertainment\" id=\"selectedEntertainment\">" ;
			
			while($row = mysqli_fetch_array($allActors))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['eid']. "> (".  $row['eid'] .") ". $row['name'] ."</option>";
			}
			echo "</select>";
			echo "<br><br><br>";		
			echo "<button type = \"submit\">Update table</button>";
			echo "</form>";

		}
	
		if ((isset($_POST['selectedActor'])) || (isset($_POST['selectedEntertainment'])))
		{
			$actorSSN = $_POST['selectedActor'];
			$entertainmentEID = $_POST['selectedEntertainment'];
			$query = mysqli_query($connection, "SELECT fname, lname FROM actor WHERE ssn = '$actorSSN'");
			//this will result only one row of data as we are searching through primary key
			while($row = mysqli_fetch_array($query))
			{
				$actorFirstName = $row['fname'];
				$actorLastName = $row['lname'];
			}
			$actorName = $actorFirstName ." " . $actorLastName;

			$query = mysqli_query($connection, "SELECT name FROM entertainment WHERE eid = '$entertainmentEID'");
			//this will result only one row of data as we are searching through primary key
			while($row = mysqli_fetch_array($query))
			{
				$entertainmentName = $row['name'];
			}
			echo "<br>";
			echo "<form>";
			echo "Actor = '" . $actorName . "' ACTS_IN '" . "Movie Name = ". $entertainmentName . "'<br>";

			//check if this data already exists in the ACTS_IN table
			$check = "SELECT * FROM ACTS_IN WHERE actor_ssn = $actorSSN AND $entertainmentEID";
			$query = mysqli_query($connection, $check);
			//https://stackoverflow.com/questions/22677992/count-length-of-array-php
			$row_num = mysqli_num_rows($query);
			//echo $row_num;
			//if $row = 0 --> add data else show "data exists'
			if($row_num <= 1)
			{
				$insert_ACTS_IN = "INSERT INTO ACTS_IN (actor_ssn, entertainment_eid) VALUES ('$actorSSN',$entertainmentEID)";
				try
				{
					mysqli_query($connection, $insert_ACTS_IN);
					echo "<p class = \"goodData\">";
					echo "Data successfully in the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");
					echo "<br>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to update the user</p>";
					//header("Location: admin_editUserInfo.php");
					echo $e;
				}
			}	
			else
			{
				//$row > 0, no need to add again
				echo "<p class = \"goodData\">";
				echo "Data already in table</p>";
			}
			echo "</form>";
			echo "<br><br>";

			echo "<form style = \"width: 200px\" action=\"admin_editActor.php\"  method = \"post\">";
			echo "<button name = \"\" type = \"submit\">Refresh Page</button>";
			echo "</form>";
	
		}
	?>
	<br><br>
	-->
	<a href="admin_editInfo.php">Link to Previous Page</a>	<br><br>
	<a href="./../index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>