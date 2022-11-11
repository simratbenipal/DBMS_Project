<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit User Information</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style = "flex-direction: column">
	<h2>Editing User Information </h2>
	<h2>Current Users in the System</h2>
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT Username, Num_Reviews AS `No of Reviews`, Rating FROM user");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>Username</th>
			<th>'No of Reviews'</th>
			<th>Rating</th>
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['Username'] . "</td>";
			echo "<td>" . $row['No of Reviews'] . "</td>";
			echo "<td>" . $row['No of Reviews'] . "</td>";
			echo "</tr>";

		}
		echo "</table>";

		$displayUserForm = FALSE;
		//mysqli_close($connection);
	?>
	<br><br>
	<!-- make these work on the same page -->
	<form style = "width: 200px" action=""  method="post">
	<button name = "addNewUser" style = "float:middle"  type="submit">Add New User
	</button> <?php $displayUserForm = TRUE;?>
	</form>

	<form style = "width: 200px" action=""  method="post">
	<button name = "deleteUser" type="submit">Delete an User</button>
	</form>	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateExistingUser" type="submit">Update Existing User</button>
	</form>	

	<?php
		if (isset($_POST['addNewUser'])) 
		{
			echo "<h2>Adding a New User</h2>";
			//for to ask for user information
			//ask for Username
			//ask for Password
			//ask for Num_Reviews
			//ask for Rating
			echo "<form action = \"\" method = \"post\">";
			echo "<label>New Username</label>";
			echo "<input type=\"text\" name=\"newUsername\" placeholder=\"Enter username of the new user\"><br>";
			echo "<label>New Password</label>";
			echo "<input type=\"password\" name=\"newPassword\" placeholder=\"Enter password of the new user\"><br>";

			//https://www.w3schools.com/tags/tag_select.asp
			echo "<label>Number of Reviews</label>";
			echo "<select name = \"num_reviews\" id=\"num_of_reviews\">" ;
			echo "<option value= \"0\"> 0 (Default)</option>";
			echo "<option value= \"1\"> 1 </option>";
			echo "<option value= \"2\"> 2 </option>";
			echo "<option value= \"3\"> 3 </option>";
			echo "<option value= \"4\"> 4 </option>";
			echo "<option value= \"5\"> 5 </option>";
			echo "</select>";
			echo "<br>";

			echo "<label>Rating of the User&nbsp&nbsp</label>";
			echo "<select name = \"user_rating\" id=\"rating_of_user\">" ;
			echo "<option value= \"0\"> 0 (Default)</option>";
			echo "<option value= \"1\"> 1 </option>";
			echo "<option value= \"2\"> 2 </option>";
			echo "<option value= \"3\"> 3 </option>";
			echo "<option value= \"4\"> 4 </option>";
			echo "<option value= \"5\"> 5 </option>";
			echo "</select>";

			echo "<button type = \"submit\"> Add Data into Database</button>";
			echo "</form>";
		}

		if ((isset($_POST['newUsername'])) && (isset($_POST['newPassword'])) && (isset($_POST['num_reviews'])) && (isset($_POST['user_rating'])) )
		{
			$newUser 	= $_POST['newUsername'];
			$newPass 	= $_POST['newPassword'];
			$newReviews = $_POST['num_reviews'];
			$newRating 	= $_POST['user_rating'];

			//https://www.geeksforgeeks.org/php-strlen-function/
			//https://www.w3schools.com/php/func_var_empty.asp
			if (empty($newUser) || empty($newPass) || (strlen($newUser) < 7) || (strlen($newPass) < 7))
			{
				echo "<p class = \"error\">";
				echo "Enter a valid Username/Password<br> Enter Data Again</p>";
			}
			else
			{
				//data is good, add to sql database
				$sql_insert = "INSERT INTO user (Username, Password, Num_Reviews, Rating) VALUES('$newUser','$newPass', $newReviews, $newRating )";
				try
				{
					mysqli_query($connection, $sql_insert);
					echo "Data added successfully to the database";
					//header("Location: admin_editUserInfo.php");

					echo "<br>";
					echo "<form style = \"width: 200px\" action=\"admin_editUserInfo.php\"  method = \"post\">";
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
	?>

	<?php
		if (isset($_POST['updateExistingUser'])) 
		{
			echo "<h2>Update an existing user</h2>";
			//show list of users, then ask what you want to change and then do accordingly
		}
	?>

	<?php
		if (isset($_POST['deleteUser'])) 
		{
			echo "<h2>Delete an user</h2>";
			//show a drop down of existing users
			//have a checkbox to make sure 
			//delete from database

		}
	?>
	<br><br>
	<a href="index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>