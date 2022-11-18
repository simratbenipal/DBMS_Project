<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit User Information</title>
	<link rel="stylesheet" type="text/css" href="./../style.css">

	<style>
		<?php //https://www.w3schools.com/cssref/sel_class.php ?>
		p.goodData
		{
			background: #a3dd94;
			color: #eaece6;
			padding: 10px;
			width: 95%;
			border-radius: 5px;
			margin: 20px auto;
		}
</style>
</head>
<body style = "flex-direction: column; justify-content:normal">
	<h2>Editing Actor Information </h2>
	<h2>Current Actors in the System</h2>
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT * FROM actor");
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
	<button name = "addNewActor" style = "float:middle"  type="submit">Add New Actor
	</button>
	</form>

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteActor" type="submit">Delete an Actor</button>
	</form>	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateExistingActor" type="submit">Update ACTS_IN (under const)</button>
	</form>	

	<?php
		if (isset($_POST['addNewActor'])) 
		{
			echo "<h2>Adding a New Actor</h2>";
			//for to ask for user information
			//ask for SSN
			//ask for fname
			//ask for lname
			//ask for Rating
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
		}
	?>

	
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
				echo "User not deleted<br>";
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
					echo "User deleted successfully from the database";
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
					echo "Error, Unable to delete the user</p>";
					//header("Location: admin_editUserInfo.php");
				}	
			}
		}	
	?>

	<?php
		if (isset($_POST['updateExistingActor'])) 
		{
			echo "<h2>Update an existing Actor</h2>";
			//show list of users, then ask what you want to change and then do accordingly
			$allUsernames = mysqli_query($connection, "SELECT * FROM user");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select user to edit : </label>";
			echo "<select name = \"edit_user\" id=\"edit_user\">" ;
			
			while($row = mysqli_fetch_array($allUsernames))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['Username']. "> ".  $row['Username'] . "</option>";
			}
			echo "</select>";
			echo "<br>";
			//https://www.w3schools.com/tags/tag_select.asp
			echo "<label>Number of Reviews</label>";
			echo "<select name = \"num_reviews_edit\" id=\"num_of_reviews\">" ;
			echo "<option value= \"0\"> 0 (Default)</option>";
			echo "<option value= \"1\"> 1 </option>";
			echo "<option value= \"2\"> 2 </option>";
			echo "<option value= \"3\"> 3 </option>";
			echo "<option value= \"4\"> 4 </option>";
			echo "<option value= \"5\"> 5 </option>";
			echo "</select>";
			echo "<br>";

			echo "<label>Rating of the User&nbsp&nbsp</label>";
			echo "<select name = \"user_rating_edit\" id=\"rating_of_user\">" ;
			echo "<option value= \"0\"> 0 (Default)</option>";
			echo "<option value= \"1\"> 1 </option>";
			echo "<option value= \"2\"> 2 </option>";
			echo "<option value= \"3\"> 3 </option>";
			echo "<option value= \"4\"> 4 </option>";
			echo "<option value= \"5\"> 5 </option>";
			echo "</select>";
			echo "<br><br>";
			echo "<button type = \"submit\">Update user</button>";
			echo "<label>(Please select both values)</label>";
			echo "</form>";
			echo "<br>";

			

		}
		if ((isset($_POST['edit_user'])) || (isset($_POST['num_reviews_edit']))|| (isset($_POST['user_rating_edit'])))
		{
			$user_to_edit = $_POST['edit_user'];
			$edit_new_rating = $_POST['user_rating_edit'];
			$edit_new_reviews = $_POST['num_reviews_edit'];

			$user_edit = "UPDATE user SET Num_Reviews  = '$edit_new_reviews', Rating = '$edit_new_rating' WHERE username = '$user_to_edit'";
			try
				{
					mysqli_query($connection, $user_edit);
					echo "<p class = \"goodData\">";
					echo "User updated successfully in the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editUserInfo.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, Unable to update the user</p>";
					//header("Location: admin_editUserInfo.php");
				}	
		}
	?>
	<br><br>
	<a href="admin_editEntertainmentInfo.php">Link to Previous Page</a>	<br><br>
    <a href="./../index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>