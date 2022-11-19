<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Director Information</title>
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
	<h2>Editing Director Information </h2>
	<h2>Current Directors in the System</h2>
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT * FROM director");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>SSN</th>
			<th>First Name</th>
			<th>Last Name</th>
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['ssn'] . "</td>";
			echo "<td>" . $row['fname'] . "</td>";
			echo "<td>" . $row['lname'] . "</td>";
			echo "</tr>";

		}
		echo "</table>";

	
	?>
	<br><br>
	<!-- make these work on the same page -->
	<form style = "width: 200px" action=""  method="post">
	<button name = "addNewDirector" style = "float:middle"  type="submit">Add New Director
	</button>
	</form>

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteDirector" type="submit">Delete a Director</button>
	</form>	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateExistingDirector" type="submit">Add Data into HIRES Table (under const)</button>
	</form>	

	<?php
		if (isset($_POST['addNewDirector'])) 
		{
			echo "<h2>Adding a New Director</h2>";
			//for to ask for user information
			//ask for SSN
			//ask for fname
			//ask for lname
			echo "<form action = \"\" method = \"post\">";
			echo "<label>New SSN</label>";
			echo "<input type=\"text\" name=\"newSSN\" placeholder=\"Enter SSN (xxx-xxx-xxxx)\"><br>";
			echo "<label>First Name</label>";
			echo "<input type=\"text\" name=\"newfname\" placeholder=\"Enter First Name\"><br>";
            echo "<label>Last Name</label>";
			echo "<input type=\"text\" name=\"newlname\" placeholder=\"Enter Last Name\"><br>";

			echo "<button type = \"submit\"> Add Data into Database</button>";
			echo "</form>";
		}

		if ((isset($_POST['newSSN'])) && (isset($_POST['newfname'])) && (isset($_POST['newlname'])))
		{
			$newSSN 	= $_POST['newSSN'];
			$newfname 	= $_POST['newfname'];
			$newlname = $_POST['newlname'];

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
				$sql_insert = "INSERT INTO director (ssn, fname, lname) VALUES('$newSSN','$newfname', '$newlname')";
				try
				{
					mysqli_query($connection, $sql_insert);
					echo "<p class = \"goodData\">";
					echo "Data added successfully to the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editDirector.php\"  method = \"post\">";
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
		}
	?>

	
	<?php
		if (isset($_POST['deleteDirector'])) 
		{
			echo "<h2>Deleting a Director</h2>";
			//show a drop down of existing actors
			//have a checkbox to make sure 
			//delete from database
			
			$allDirector = mysqli_query($connection, "SELECT * FROM director");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Director to delete : </label>";
			echo "<select name = \"selectedUser\" id=\"selectedUserId\">" ;
			
			while($row = mysqli_fetch_array($allDirector))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['ssn']. "> (".  $row['ssn'] .") ". $row['fname'] ." ". $row['lname']."</option>";
			}
			echo "</select>";
			echo "<br><br>";
			echo "<label for = \"checkbox\"> Do you want to remove the selected Director : </label>";
			echo  "<input type = \"checkbox\" name = \"checkbox\" id = \"checkedId\" </input> ";
			echo "<button type = \"submit\">Delete Director from Database</button>";
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
				echo "Director not deleted<br>";
				echo "</p>";

			}
			else if (strcmp ($selectedUser, "123-123-1234") == 0)
			{
				echo "<p class = \"error\">";
				echo "Cannot delete 'John Doe'<br>";
				echo "</p>";
			}
			else
			{
				//data is good, delete from database
				$sql_delete = "DELETE FROM director WHERE ssn = '$selectedUser'";
				try
				{
					mysqli_query($connection, $sql_delete);
					echo "<p class = \"goodData\">";
					echo "Director deleted successfully from the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editDirector.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to delete the Director</p>";
					//header("Location: admin_editUserInfo.php");
				}	
			}
		}	
	?>

	<?php
		if (isset($_POST['updateExistingDirector'])) 
		{
			echo "<h2>Update an existing Director Information</h2>";
			echo "<h5>(Updates HIRES table)</h5>";
			//show list of users, then ask what you want to change and then do accordingly
			$allDirector = mysqli_query($connection, "SELECT * FROM director");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select Director: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>";
			echo "<select name = \"selectedDirector\" id=\"selectedDirector\">" ;
			
			while($row = mysqli_fetch_array($allDirector))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['ssn']. "> (".  $row['ssn'] .") ". $row['fname'] ." ". $row['lname']."</option>";
			}
			echo "</select>";	
			echo "<br>";
			
			//show list of users, then ask what you want to change and then do accordingly
			$allProdCompany = mysqli_query($connection, "SELECT * FROM productioncompany");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Production Company: </label>";
			echo "<select name = \"selectedProd\" id=\"selectedProd\">" ;
			
			while($row = mysqli_fetch_array($allProdCompany))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['pid']. "> (".  $row['pid'] .") ". $row['name'] ."</option>";
			}
			echo "</select>";
			echo "<br><br><br>";		
			echo "<button type = \"submit\">Update table</button>";
			echo "</form>";

		}
	
		if ((isset($_POST['selectedDirector'])) || (isset($_POST['selectedProd'])))
		{
			$directorSSN = $_POST['selectedDirector'];
			$prodPID = $_POST['selectedProd'];
			$query = mysqli_query($connection, "SELECT fname, lname FROM director WHERE ssn = '$directorSSN'");
			//this will result only one row of data as we are searching through primary key
			while($row = mysqli_fetch_array($query))
			{
				$directorFirstName = $row['fname'];
				$directorLastName = $row['lname'];
			}
			$directorName = $directorFirstName ." " . $directorLastName;

			$query = mysqli_query($connection, "SELECT name FROM productioncompany WHERE pid = '$prodPID'");
			//this will result only one row of data as we are searching through primary key
			while($row = mysqli_fetch_array($query))
			{
				$productionName = $row['name'];
			}
			echo "<br>";
			echo "<form>";
			echo "Production Company Name = '". $productionName . "' HIRES " . "Director = '" . $directorName . "'<br>";

			//check if this data already exists in the ACTS_IN table
			$check = "SELECT * FROM HIRES WHERE director_ssn = $directorSSN AND prod_pid = $prodPID";
			$query = mysqli_query($connection, $check);
			//https://stackoverflow.com/questions/22677992/count-length-of-array-php
			$row_num = mysqli_num_rows($query);
			//echo $row_num;
			//if $row = 0 --> add data else show "data exists'
			if($row_num <= 1)
			{
				$insert_HIRES = "INSERT INTO HIRES (prod_pid, director_ssn) VALUES ('$prodPID',$directorSSN)";
				try
				{
					mysqli_query($connection, $insert_HIRES);
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

			echo "<form style = \"width: 200px\" action=\"admin_editDirector.php\"  method = \"post\">";
			echo "<button name = \"\" type = \"submit\">Refresh Page</button>";
			echo "</form>";
	
		}
	?>
	<br><br>
	<a href="admin_editEntertainmentInfo.php">Link to Previous Page</a>	<br><br>
    <a href="./../index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>