<?php
	
		header('Access-Control-Allow-Origin: *');
		include 'headers/connect_database.php';      // Connection to Mysql Database.
		//require_once('PHP/recaptchalib.php');   // Captcha Library.
		
		$username = $_POST['username'];
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$email = $_POST['email'];
		$profilePic=$_POST['profilePic'];
		
		
		//checking if username exists.
		
		
		$query = "SELECT count(*) from users WHERE username=:username";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':username',$username);
		$sth->execute();
		$rows = $sth->fetch(PDO::FETCH_NUM);
		
		
		// this condition checks if count(*) is 0 that means if username doesnot exist
		
		if($rows[0] == 0)  
		{
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO users(username,fname,lname,email,collegeID,profilePic,joinDate,active) VALUES (:username,:fname,:lname,:email,:collegeID,:profilePic,:joinDate,:active)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':username',$username);
			$sth->bindValue(':fname',$fname);
			$sth->bindValue(':lname',$lname);
			$sth->bindValue(':email',$email);
			$sth->bindValue(':collegeID',0);
			$sth->bindValue(':active',1);
			$sth->bindValue(':profilePic',$profilePic);
			$sth->bindValue(':joinDate',date('Y/m/d H:i:s'));
			
			//$sth ->execute();
			 if($sth ->execute())
			 {
				  echo "success";
			 }
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo "ErrorCode: " . $errorCode; 
			 }
			
			
		} // Ending bracket of IF($rows[0]==0)
		
		else
		{
			echo "You are already registered, Logging you in!";
		}
		
		
		
			
		
		$dbh = null;   // setting the database connection to null
		
		
?>