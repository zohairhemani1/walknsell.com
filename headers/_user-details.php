<?php


	
	
		if(isset($_SESSION['username']))
		{
		$username = $_SESSION['username'];
		include 'connect_to_mysql.php';
		$query = "SELECT * FROM users WHERE username like '$username'";
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_array($result)){
			$_userID = $row['ID'];
			$_username = $row['username'];
			$_fname = $row['fname'];
			$_fname_uppercase = strtoupper($_fname);
			$_lname = $row['lname'];
			$_lname_uppercase = strtoupper($_lname);
			$_college = $row['collegeID'];
			$_email = $row['email'];
			$_password = $row['password'];
			$_joinDate = $row['joinDate'];
			$_profilePic = $row['profilePic'];


		}
		}
		else
		{
			//include 'cookie_user.php';
			
		}
	

?>