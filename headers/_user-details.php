<?php
session_start();
if(!isset($_SESSION['username']) && !isset($_COOKIE['remember'])){
	header('Location: index.php');		
} else{
	
	
		if(isset($_SESSION['username']))
		{
			$username = $_SESSION['username'];
		}
		else
		{
			include 'cookie_user.php';
			
		}
	
		include 'connect_to_mysql.php';
		$query = "SELECT * FROM users WHERE username like '$username'";
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_array($result)){
			$_username = $row['username'];
			$_fname = $row['fname'];
			$_lname = $row['lname'];
			$_college = $row['college'];
			$_email = $row['email'];
			$_password = $row['password'];
		}
}	

?>
