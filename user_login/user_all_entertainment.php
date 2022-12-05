<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Entertainment Information</title>
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
	<h2>Current Entertainment information in the System</h2>
	
	<?php 
		$connection = mysqli_connect("localhost", "root", "","entertainment_db");
		//check if connection was made properly or no
		if(mysqli_connect_errno())
		{
			echo "Failed to connect: " . mysqli_connect_error();
		}
		//echo "Connection made to database ";
		//$result = mysqli_query($connection, "SELECT E.eid, E.name AS Ename, E.type, E.rating, E.date, PC.name AS PC_name, PC.address,D.ssn, D.fname, D.lname, AI.city_name AS city, AI.theatre_name as Theatre_name, AO.url AS url, P.name AS platform FROM entertainment AS E, productioncompany AS PC, director as D, available_in AS AI, available_on AS AO, Platform as P WHERE E.prod_pid = PC.pid AND E.dir_ssn = D.ssn AND AI.eid = E.eid AND AO.eid = E.eid AND P.url = AO.url");
        $result = mysqli_query($connection, "SELECT E.eid, E.name AS Ename, E.type, E.rating, E.date, PC.name AS PC_name, PC.address,D.ssn, D.fname, D.lname FROM entertainment AS E, productioncompany AS PC, director as D WHERE E.prod_pid = PC.pid AND E.dir_ssn = D.ssn ");
		echo "<table style = \"background: #D0E4F5;border: 1px solid #AAAAAA;
		padding: 3px 2px;font-size: 20px;\" border = '1'>
			<tr>
			<th>EID</th>
			<th>Name</th>
			<th>Type</th>
			<th>Rating</th>
			<th>Release Date</th>
			<th>Production Company, Location</th>";
            
            //echo"
			//<th>Director Name</th>
           // <th>Available ON</th>
           // <th>Available IN</th>";
			echo"</tr>";
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
           // echo "<td>" . $row['Theatre_name'] . "," . $row['city'] . "</td>";
           // echo "<td>" . $row['platform'] . "," . $row['url'] . "</td>";
			echo "</tr>";

		}
		echo "</table>";

	?>
	<br><br>
		
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "showMore" type="submit">Show more info about an  Entertainment</button>
	</form>	
    <br><br>

	

	<?php
		//update entertainment buttom is pressed
		if (isset($_POST['showMore'])) {
			echo "<h2>More Info about an Entertainment</h2>";
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

				

				echo "</form>";	
			}
		}
?>
	<br><br>
	
	
	<form style = "width: 200px" action=""  method="post">
	<button name = "" style = "float:middle"  type="submit">Refresh Page
	</button>
	</form>

	<a href="user_choice.php">Link to Previous Page</a>	<br><br>
	<a href="./../index.php">Link to Main Page</a>
	<br><br>
	<?php mysqli_close($connection); ?>		
</body>
</html>