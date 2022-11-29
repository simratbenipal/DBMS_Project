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
		select
		{
			width: max-content;
			size: legal;
			font-size: medium;
			font-style: initial;
			font-family: sans-serif;
			font-weight: bold;
			border: solid;
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
		//Adding new information into the system
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
			echo "<form style=\"width:600px\"action = \"\" method = \"post\">";
			
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
			echo "<br>";echo "<br>";echo "<br>";

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

			echo "<label>Release Date&nbsp&nbsp</label>";
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

		//error checking the names and other information
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
		//if delete entertainment button is pressed
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

		//Deleting the selected entertainment, only possible if the checkbox is selected
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
		//update entertainment buttom is pressed
		if (isset($_POST['updateEntertainment'])) {
			echo "<h2>Update an Entertainment Information</h2>";
			$allEntertainment = mysqli_query($connection, "SELECT * FROM entertainment");
			echo "<form style = \"width:600px\" action = \"\" method = \"post\">";
			echo "<label>Select Entertainment: &nbsp  &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp</label>";
			echo "<select name = \"selectedEntertainment_edit\" id=\"selectedEntertainment\">" ;
			
			while($row = mysqli_fetch_array($allEntertainment))
			{
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['eid']. "> (".  $row['eid'] .") ". $row['name'] . "</option>";
			}
			echo "</select>";
			echo "<br>";
			echo "<br>";
			echo "<button type = \"submit\"  name = \"selectedEntertainment_av_in\" >Show AVAILABLE_IN information</button>";
			echo "<button type = \"submit\"  name = \"selectedEntertainment_av_on\" >Show AVAILABLE_ON information</button>";
			echo "<br>";echo "<br>";echo "<br>";echo "<br>";
			echo "<button type = \"submit\"  name = \"selectedEntertainment_type_rating\" >Show \"Type\" and \"Rating\" information</button>";
			echo "</form>";	
			echo "<br>";
		}
		//getting which entertainment to edit
		if (isset($_POST['selectedEntertainment_edit'])) {
			echo "<h2>Editing </h2>";
			echo "<form style = \"width:600px\">";
			$selectedEntertainmentEID = $_POST['selectedEntertainment_edit'];			
			//echo $selectedEntertainmentEID;
			$result = mysqli_query($connection, "SELECT E.eid, E.name AS Ename, E.type, E.rating, E.date FROM entertainment AS E  WHERE E.eid = '$selectedEntertainmentEID' ");
			while($row = mysqli_fetch_array($result))
			{
				$entertainmentName =  $row['Ename'];
			}

			//pressed the edit Available on button
			if (isset($_POST['selectedEntertainment_av_on'])) {
				echo "<p class = \"\">";
				echo "'" . $entertainmentName . "' is AVAILABLE_ON : ";
				echo "</p>";
			
				$allEntertainment_AO = mysqli_query($connection, "SELECT * FROM entertainment AS E, available_on AS AO, platform WHERE E.eid = AO.eid AND AO.url = platform.url AND E.eid = $selectedEntertainmentEID");
				$i = 1;
				echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
						padding: 3px 2px;font-size: 20px;\" border = '1'>";
				echo "<tr>";
				echo "<th> </th>";
				echo "<th>Entertainment Name</th>";
				echo "<th>Platform Name</th>";
				echo "<th>Platform URL</th>";
				echo  "</tr>";
				while($row = mysqli_fetch_array($allEntertainment_AO)) {
					echo "<tr>";
					echo "<td>" .  $i . "</td>";
					echo "<td>" . $row['eid'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['url'] . "</td>";
					echo "</tr>";
					$i++;
				}
				echo "</table>";
				echo "<br><br>";
				echo "</form>";
			

				echo "<form style = \"width:600px\" action = \"\" method = \"post\">";
				$allPlatform = mysqli_query($connection, "SELECT * FROM platform ");
				echo "<label>Select which platform this entertainment is available on : </label>";
				echo "<br><br>";
				echo "<select name = \"selectedPlatform\" id=\"selectedPlatform\">" ;
				while($row = mysqli_fetch_array($allPlatform)) {
					echo "<option value = ".  $row['url'] ."," . $row['name'] . "," .$selectedEntertainmentEID . "> (".  $row['url'] .") ". $row['name'] . "</option>";
				}
				echo "</select>";
				echo "<br><br>";

				echo "<button type = \"submit\"  name = \"selectedEntertainment_av_on_edit\" >Add into database</button>";
				echo "</form>";
			}

		
			//pressed the available in button on the form
			if (isset($_POST['selectedEntertainment_av_in'])) {
				echo "<form style = \"width:600px\">";
				echo "<p class = \"\">";
				echo "'" . $entertainmentName . "' is AVAILABLE_IN : ";
				echo "</p>";
				$allEntertainment_AI = mysqli_query($connection, "SELECT * FROM entertainment AS E, available_in AS AI WHERE E.eid = AI.eid AND E.eid = $selectedEntertainmentEID");
				$i = 1;
				echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
						padding: 3px 2px;font-size: 20px;\" border = '1'>";
				echo "<tr>";
				echo "<th> </th>";
				echo "<th>Entertainment ID</th>";
				echo "<th>Entertainment Name</th>";
				echo "<th>Theatre Name</th>";
				echo "<th>City Name</th>";
				echo  "</tr>";
				while($row = mysqli_fetch_array($allEntertainment_AI)) {
					echo "<tr>";
					echo "<td>" .  $i . "</td>";
					echo "<td>" . $row['eid'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['theatre_name'] . "</td>";
					echo "<td>" . $row['city_name'] . "</td>";
					echo "</tr>";
					$i++;
				}
				echo "</table>";
				echo "<br><br>";
				echo "</form>";

				echo "<form style = \"width:600px\" action = \"\" method = \"post\">";
				$allTheatre = mysqli_query($connection, "SELECT * FROM city_theater_name ");
				echo "<label>Select which theatre this entertainment is available IN : </label>";
				echo "<br><br>";
				echo "<select name = \"selectedTheatre\" id=\"selectedTheatre\">" ;
				while($row = mysqli_fetch_array($allTheatre)) {
					echo "<option value = " . $row['theatre_name'] . "," . $row['city_name'] . "," .$selectedEntertainmentEID . ">" . $row['theatre_name'] . " , ". $row['city_name'] . "</option>";
				}
				echo "</select>";
				echo "<br><br>";

				echo "<button type = \"submit\"  name = \"selectedEntertainment_av_on_edit\" >Add into database</button>";
				echo "</form>";
			

				echo "</form>";	
			}

			//if show "Type and Rating" information buttom is pressed
			if (isset($_POST['selectedEntertainment_type_rating'])) {
				
				$allEntertainment_type_rating = mysqli_query($connection, "SELECT type, rating FROM entertainment WHERE eid = $selectedEntertainmentEID");
				
				//this will result in only two values as EID is unique
				while($row = mysqli_fetch_array($allEntertainment_type_rating)) {
					$type = $row['type'];
					$rating = $row['rating'];

				}

				echo "<form style = \"width:600px\">";
				echo "<p class = \"\">";
				echo "The \"Type\" of '".$entertainmentName . "' is : \"" . $type . "\"";
				echo "<br>";
				echo "The \"Rating\" of '" . $entertainmentName . "' is : \"". $rating . "\"";
				echo "</p>";
				echo "</form>";

				echo "<form style = \"width:600px\" action = \"\" method = \"post\">";
				$allTheatre = mysqli_query($connection, "SELECT * FROM city_theater_name ");
				echo "<label>Select updated \"Type\" and \"Rating\" of this entertainment: </label>";
				echo "<br><br>";
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<label>Select Type</label>";
				echo "<select name = \"type_edit\" id=\"type\">" ;
				echo "<option value= \"Sci-Fi,".$selectedEntertainmentEID."\"> Sci-Fi </option>";
				echo "<option value= \"Fiction,".$selectedEntertainmentEID."\"> Fiction </option>";
				echo "<option value= \"Action,".$selectedEntertainmentEID."\"> Action </option>";
				echo "<option value= \"Comedy,".$selectedEntertainmentEID."\"> Comedy </option>";
				echo "</select>";
				echo "<br>";echo "<br>";

				echo "<label>Rating&nbsp&nbsp</label>";
				echo "<select name = \"entertainment_rating_edit\" id=\"entertainment_rating\">" ;
				echo "<option value= \"0,".$selectedEntertainmentEID."\"> 0 (Default)</option>";
				echo "<option value= \"1,".$selectedEntertainmentEID."\"> 1 </option>";
				echo "<option value= \"2,".$selectedEntertainmentEID."\"> 2 </option>";
				echo "<option value= \"3,".$selectedEntertainmentEID."\"> 3 </option>";
				echo "<option value= \"4,".$selectedEntertainmentEID."\"> 4 </option>";
				echo "<option value= \"5,".$selectedEntertainmentEID."\"> 5 </option>";
				echo "</select>";
				echo "<br>";
				echo "<label>(Please note that both of these values will be updated)</label>";

				echo "<br><br>";

				echo "<button type = \"submit\"  name = \"selectedEntertainment_type_rating_edit\" >Add into database</button>";
				echo "</form>";
				echo "</form>";	
			}
		}

		//adding information about the new platform
		if(isset($_POST['selectedPlatform'])) 
		{
			//echo $_POST['selectedPlatform'];
			//The value of the option in html is "URL,Name_of_platform,EID"
			//so we can split and add that into the table

			echo "<form style = \"width:600px\">";
            //https://www.geeksforgeeks.org/php-explode-function/
            $splittedString = explode(",", $_POST['selectedPlatform']);
            $platform_url = $splittedString[0];
            $entertainment_eid = $splittedString[2];
		
			//add this information into available_on table in the database
			//check if this data is already in the table
			//if no then add, otherwise display message about data already in table
			$check = "SELECT * FROM available_on WHERE eid = '$entertainment_eid' AND url = '$platform_url'";
			$query = mysqli_query($connection, $check);
			//https://stackoverflow.com/questions/22677992/count-length-of-array-php
			$row_num = mysqli_num_rows($query);
			//echo "row num -->".$row_num . "<---";
			//if $row = 0 --> add data else show "data exists'
			if($row_num < 1)
			{
				$insert_available_on = "INSERT INTO available_on (eid, url) VALUES ('$entertainment_eid' , '$platform_url')";
				try
				{
					mysqli_query($connection, $insert_available_on);
					echo "<p class = \"goodData\">";
					echo "Data successfully in the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");
					echo "<br>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to update the information</p>";
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
		}

		//adding the information about theatre into the database
		if(isset($_POST['selectedTheatre'])) 
		{
			//echo $_POST['selectedTheatre'];
			//The value of the option in html is "URL,Name_of_platform,EID"
			//so we can split and add that into the table

			echo "<form style = \"width:600px\">";
            //https://www.geeksforgeeks.org/php-explode-function/
            $splittedString = explode(",", $_POST['selectedTheatre']);
            $theatre_name = $splittedString[0];
			$theatre_city = $splittedString[1];
            $entertainment_eid = $splittedString[2];
		
			//add this information into available_IN table in the database
			//check if this data is already in the table
			//if no then add, otherwise display message about data already in table
			$check = "SELECT * FROM available_in WHERE eid = '$entertainment_eid' AND city_name = '$theatre_city' AND theatre_name = '$theatre_name'";
			$query = mysqli_query($connection, $check);
			//https://stackoverflow.com/questions/22677992/count-length-of-array-php
			$row_num = mysqli_num_rows($query);
			//echo "row num -->".$row_num . "<---";
			//if $row = 0 --> add data else show "data exists'
			if($row_num < 1)
			{
				$insert_available_in = "INSERT INTO available_in (eid, city_name, theatre_name) VALUES ('$entertainment_eid' , '$theatre_city' , '$theatre_name')";
				try
				{
					mysqli_query($connection, $insert_available_in);
					echo "<p class = \"goodData\">";
					echo "Data successfully in the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");
					echo "<br>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to update the information</p>";
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
		}
		

		//adding "type" and "rating" information into database
		if(isset($_POST['entertainment_rating_edit']) && isset($_POST['type_edit']) )
		{
			//echo "rating new".$_POST['entertainment_rating_edit'];
			//echo "<br>";

			//echo $_POST['entertainment_rating_edit'];
			//The value of the option in html is "number,EID"
			//so we can split and add that into the table
			echo "<form style = \"width:600px\">";
			//https://www.geeksforgeeks.org/php-explode-function/
			$splittedString = explode(",", $_POST['entertainment_rating_edit']);
			$new_rating = $splittedString[0];
			$entertainment_eid = $splittedString[1];

			$splittedString = explode(",", $_POST['type_edit']);
			$new_type = $splittedString[0];
			//$entertainment_eid = $splittedString[1];
	
			//add this information into entertainment table in the database
			$update_rating = "UPDATE entertainment SET rating = '$new_rating' , type = '$new_type' WHERE eid = '$entertainment_eid'";
			try
			{
				mysqli_query($connection, $update_rating);
				echo "<p class = \"goodData\">";
				echo "Data successfully in the database";
				echo "</p>";
				//header("Location: admin_editUserInfo.php");
				echo "<br>";
			}
			catch (Exception $e)
			{
				echo "<p class = \"error\">";
				echo "Error, Unable to update the information</p>";
				//header("Location: admin_editUserInfo.php");
				echo $e;
			}	
			echo "</form>";
			echo "<br><br>";
		}
		//echo print_r($_POST);	
	?>
	<br><br>
	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "" style = "float:middle"  type="submit">Refresh Page
	</button>
	</form>

	<a href="admin_editInfo.php">Link to Previous Page</a>	<br><br>
	<a href="./../index.php">Link to Main Page</a>
	<br><br>
	<?php mysqli_close($connection); ?>		
</body>
</html>