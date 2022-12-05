<?php 
$connection = mysqli_connect("localhost", "root", "","entertainment_db");
//check if connection was made properly or no
if(mysqli_connect_errno())
{
    echo "Failed to connect: " . mysqli_connect_error();
}
echo "Connection made to database ";
if (isset($_POST['uname']) && isset($_POST['password'])) 
{
	function validate($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
	if (empty($uname))
	{
		header("Location: user_login.php?error=User Name is required");
		exit();
	}else if (empty($pass)) 
	{
		header("Location: user_login.php?error=password is required");
		exit();
	}else
	{
		
		// After connect database, here to jump into home web page
		echo "Valid input admin verify page<br>";
        
        //so far we have username and password of the user entered
        //check if those match with the admin informatino stored in the sql
        $success = false;
        $select_unames = mysqli_query($connection, "SELECT * FROM user");
        while($row = mysqli_fetch_array($select_unames))
        {
            if($uname == $row['Username'])
            {
                if($pass == $row['Password'])
                {
                   // echo $uname ."<br>". $row['Username'] . "<br>";
                   // echo $pass ."<br>". $row['Password'] . "<br>";
                    //Password and username matched here
                    //login successful
                    //ask for if want to update user information or entertainment information
                    // go to admin_choice.php
                   // header("Location: admin_choice.php");
                   $success = true;
                   break;
                }
            }        
        }
        mysqli_close($connection);
        if($success)
        {
            //if here, username and password match, we can move ahead
            //move to next page and pass the username of the admin to the next page
            //https://www.sitepoint.com/community/t/passing-variables-using-header-location/4929
            header("Location: user_choice.php?username=".$uname."");
        }
        else
        {
            //if here, username not in database or not matched
            header("Location: user_login.php?error=Access Denied");
        }

	}
}
else
{
	header("Location: admin_login.php");
	exit();
}
?>