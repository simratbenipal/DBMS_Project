<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit HIRES Information</title>
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
	<h2>Editing HIRES Table </h2>
	<h2>Current HIRES Table</h2>

	<?php 
    echo "add join conditions between prod and director to show who is hired by whom and then give options to change it<br><br>";
    $connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		$result = mysqli_query($connection, "SELECT * FROM hires AS H, productioncompany AS PC, director AS dir WHERE dir.ssn = H.director_ssn AND PC.pid = H.prod_pid");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>PID</th>
			<th>Company name</th>
			<th>Company Location</th>
            <th>Director SSN</th>
            <th>Director Name</th>
			</tr>";
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['pid'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['ssn'] . "</td>";
            echo "<td>" . $row['fname'] . " " .$row['lname']   . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	?>
	<br><br>

	<!-- make these work on the same page -->
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "updateHires" type="submit">Add Data into HIRES Table </button>
	</form>	
    
	<form style = "width: 200px" action=""  method="post">
	<button name = "removeHires" type="submit">Delete Data into HIRES Table </button>
	</form>	
   
	<?php
		if (isset($_POST['updateHires'])) 
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
			$check = "SELECT * FROM HIRES WHERE director_ssn = '$directorSSN' AND prod_pid = '$prodPID'";
			$query = mysqli_query($connection, $check);
			//https://stackoverflow.com/questions/22677992/count-length-of-array-php
			$row_num = mysqli_num_rows($query);
			echo $row_num;
			//if $row = 0 --> add data else show "data exists'
			if($row_num < 1)
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

			echo "<form style = \"width: 200px\" action=\"admin_editHIRES.php\"  method = \"post\">";
			echo "<button name = \"\" type = \"submit\">Refresh Page</button>";
			echo "</form>";
	
		}
	?>

<?php
		if (isset($_POST['removeHires'])) 
		{
			echo "<h2>Remove rows from HIREs Table</h2>";
			echo "<h5>(Updates HIRES table)</h5>";
            $result = mysqli_query($connection, "SELECT * FROM hires AS H, productioncompany AS PC, director AS dir WHERE dir.ssn = H.director_ssn AND PC.pid = H.prod_pid");

			echo "<form action = \"\" method = \"post\">";
			echo "<label>Select row to delete: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>";
			echo "<select name = \"selectedRow\" id=\"selectedRow\">" ;
			
			while($row = mysqli_fetch_array($result))
			{
				//echo  $row['Username'] ; 
				//https://www.w3schools.com/tags/tag_select.asp
				echo "<option value = ".  $row['prod_pid']."#".$row['director_ssn'] .">".  $row['name'] ." HIRES ". $row['fname'] ." ". $row['lname']."</option>";
			}
			echo "</select>";	
			echo "<br><br><br>";
            echo "<button type = \"submit\">Delete row from HIRES table</button>";
            echo "</form>";
		}
	
		if (isset($_POST['selectedRow']))
		{
			$selectedRow = $_POST['selectedRow'];
           // echo $selectedRow; //pid#ssn
            //https://www.geeksforgeeks.org/php-explode-function/
            $splittedString = explode("#", $selectedRow);
            $prodPID = $splittedString[0];
            $director_ssn = $splittedString[1];
            //echo "<br>";
            //echo $prodPID;
            //echo "<br>";
            //echo $director_ssn;

            //delete this row from HIRES table//data is good, delete from database
            echo "<form>";
			try
			{
                mysqli_query($connection, "DELETE FROM HIRES WHERE prod_pid = '$prodPID' AND director_ssn = '$director_ssn'");
				echo "<p class = \"goodData\">";
				echo "Row deleted successfully from the database";
				echo "</p>";
				//header("Location: admin_editUserInfo.php");

				echo "<br>";
			}
			catch (Exception $e)
			{
				echo "<p class = \"error\">";
				echo "Error, Unable to delete the row</p>";
                //echo $e;
				//header("Location: admin_editUserInfo.php");
			}	
		  
			echo "<form style = \"width: 200px\" action=\"admin_editHIRES.php\"  method = \"post\">";
			echo "<button name = \"\" type = \"submit\">Refresh Page</button>";
			echo "</form>";
            echo "</form>";
	
		}
	?>
	<br><br>
	<a href="admin_editEntertainmentInfo.php">Link to Previous Page</a>	<br><br>
    <a href="./../index.php">Link to Main Page</a>
	<?php mysqli_close($connection); ?>		
</body>
</html>