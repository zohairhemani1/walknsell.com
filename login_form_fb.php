<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	include 'headers/connect_database.php';      // Connection to Mysql Database.
	
	$username = $_POST['userID'];
	
	$query = "SELECT count(*) from users WHERE username=:username";
	$sth = $dbh->prepare($query);
	$sth->bindValue(':username',$username);
	$sth->execute();
	$rows = $sth->fetch(PDO::FETCH_NUM);
	
	if($rows[0]==1)
	{
		$_SESSION['username'] = $username;
		echo "success";
	}
	else
	{
		echo "incorrect credentials";
	}
	
?>