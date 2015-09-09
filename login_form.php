<?php

    setcookie('walknsell_remember', md5(rand()*1000000000), time()+3600 * 24 * 365, '/', 'www.walknsell.com');
    session_start();
	header('Access-Control-Allow-Origin: *');
	include 'headers/connect_database.php';      // Connection to Mysql Database.
	
	$username = $_POST['username-login'];
	$password = $_POST['password-login'];
	$password_md5 = md5($password);
	
    if(isset($_POST['remember'])){
        $varcookie = md5(rand()*1000000000);
        $query = "UPDATE users SET cookie = :cookie WHERE username=:username AND password =:password";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':cookie',$varcookie);
        $sth->bindValue(':username',$username);
        $sth->bindValue(':password',$password_md5);
        $sth->execute();
        $rows = $sth->rowCount();
         }
    $query = "SELECT active from users WHERE username=:username AND password =:password";
    $sth = $dbh->prepare($query);
    $sth->bindValue(':username',$username);
    $sth->bindValue(':password',$password_md5);
    $sth->execute();
    $rows = $sth->fetchColumn();
    if($rows==null && empty($rows))
	{
		echo "incorrect credentials";
	}
	else if($rows==1)
	{
		$_SESSION['username'] = $username;
		echo "success";
	}
	else
	{
		echo " Account not active";
	}
	// Validation 
	
	
	
?>