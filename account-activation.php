<?php
	
	include 'headers/connect_to_mysql.php';
	$activationKey = $_GET['activate'];
	
	if($dbh->exec("UPDATE users SET active = '1' WHERE activationKey = '$activationKey'"))
	{
		echo "Your account has been successfully activated";
	}
	else
	{
		echo "Account cannot be activated!";
	}
?>