<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit User Information</title>
	<link rel="stylesheet" type="text/css" href="style.css">

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
	<h2>Current admins in the System</h2>
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT Username FROM admin");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>Admin Username</th>
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['Username'] . "</td>";
			echo "</tr>";

		}
		echo "</table>";
	?>
	<br><br>
	<!-- make these work on the same page -->
	<form style = "width: 200px" action=""  method="post">
	<button name = "addNewAdmin" style = "float:middle"  type="submit">Add New Admin
	</button>
	</form>

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteAdmin" type="submit">Delete an Admin</button>
	</form>	

	<?php
		if (isset($_POST['addNewAdmin'])) 
		{
			echo "<h2>Adding a New Admin</h2>";
			//for to ask for Admin information
			//ask for Username
			//ask for Password
			echo "<form action = \"\" method = \"post\">";
			echo "<label>New Admin Username</label>";
			echo "<input type=\"text\" name=\"newAdmin\" placeholder=\"Enter username of the new Admin\"><br>";
			echo "<label>New Password</label>";
			echo "<input type=\"password\" name=\"newPassword\" placeholder=\"Enter password of the new Admin\"><br>";

			echo "<button type = \"submit\"> Add Data into Database</button>";
			echo "</form>";
		}

		if ((isset($_POST['newAdmin'])) && (isset($_POST['newPassword'])))
		{
			$newUser 	= $_POST['newAdmin'];
			$newPass 	= $_POST['newPassword'];
		
			//https://www.geeksforgeeks.org/php-strlen-function/
			//https://www.w3schools.com/php/func_var_empty.asp
			if (empty($newUser) || empty($newPass) || (strlen($newUser) < 7) || (strlen($newPass) < 7))
			{
				echo "<p class = \"error\">";
				echo "Enter a valid Username/Password<br> Enter Data Again</p>";
			}
			else
			{
				//https://www.php.net/manual/en/function.str-contains.php
				//should be good to prevent SQL injections
				//check for ;  =  -  ' '  \
				//if the username or password contains, then stop otherwise execute the query
				if(str_contains($newUser, ';')|| str_contains($newUser, '=') || str_contains($newUser, '-')|| str_contains($newUser, ' ') ||  str_contains($newUser, '\\') )
				{
					echo "<p class = \"error\">";
					echo "Invalid characters in Username, try again<br>";
					echo "</p>";
				}
				else if(str_contains($newPass, ';')|| (str_contains ($newPass, '=')) || str_contains($newPass, '\\') ||  str_contains($newPass, ' ') || str_contains($newPass, '-'))
				{
					echo "<p class = \"error\">";
					echo "Invalid characters in Password, try again<br>";
					echo "</p>";
				}
				else
				{
				//data is good, add to sql database
				$sql_insert = "INSERT INTO admin (Username, Password) VALUES('$newUser','$newPass')";
				try
				{
					mysqli_query($connection, $sql_insert);
					echo "<p class = \"goodData\">";
					echo "Data added successfully to the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_AddNewAdmin.php\"  method = \"post\">";
					echo "<button name = \"\" type = \"submit\">Click here to update table</button>";
					echo "</form>";
				}
				catch (Exception $e)
				{
					echo "<p class = \"error\">";
					echo "Error, please check the data and enter again</p>";
					//header("Location: admin_editUserInfo.php");
				}	
			}
			}
		}
	?>

	
	<?php
		if (isset($_POST['deleteAdmin'])) 
		{
			echo "<h2>Deleting an Admin</h2>";
			//show a drop down of existing users
			//have a checkbox to make sure 
			//delete from database
			
			$allUsernames = mysqli_query($connection, "SELECT * FROM admin");
			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select user to delete : </label>";
			echo "<select name = \"selectedUser\" id=\"selectedUserId\">" ;
			
			while($row = mysqli_fetch_array($allUsernames))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['Username']. "> ".  $row['Username'] . "</option>";
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
			else if (strcmp ($selectedUser, "administrator") == 0)
			{
				echo "<p class = \"error\">";
				echo "Cannot delete administrator<br>";
				echo "</p>";
			}
			else if ((strcmp ($selectedUser, "Simrat") == 0) || (strcmp ($selectedUser, "adminSimrat") == 0))
			{
				echo "<p class = \"error\">";
				echo "Cannot delete:  Simrat<br>";
				echo "</p>";
			}
			else
			{
				//data is good, delete from database
				$sql_delete = "DELETE FROM admin WHERE username = '$selectedUser'";
				try
				{
					mysqli_query($connection, $sql_delete);
					echo "<p class = \"goodData\">";
					echo "User deleted successfully from the database";
					echo "</p>";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_AddNewAdmin.php\"  method = \"post\">";
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
	<br><br>
	<a href="admin_choice.php">Link to Previous Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>