<?php
	
		header('Access-Control-Allow-Origin: *');
		include 'headers/connect_database.php';   // Connection to Mysql Database.
		//require_once('PHP/recaptchalib.php');   // Captcha Library.
		$typeAcc = $_POST['typeAcc'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_md5 = md5($password);
		$fname = $_POST['firstName'];
		$lname = $_POST['lastName'];
		$email = $_POST['email'];
		$college = $_POST['college'];
		$activationKey = md5(microtime().rand());
		
		
		
		
		//checking if username exists.
		
		
		$query = "SELECT count(*) from users WHERE username=:username";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':username',$username);
		$sth->execute();
		$rows = $sth->fetch(PDO::FETCH_NUM);
		
		//fetching college ID
		
		
		$query = "SELECT ID from colleges WHERE name = :cname";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':cname','IBA INSTITUTE OF BUSINESS ADMINISTRATION');
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		
		$collegeID=$result['ID'];
		
		// this condition checks if count(*) is 0 that means if username doesnot exist
		
		
		
		
		if($typeAcc=="fb"){
		
		
			if($rows[0] == 0)  
		{
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO users(username,fname,lname,email,collegeID,joinDate,active) VALUES (:username,:fname,:lname,:email,:collegeID,:joinDate,:active)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':username',$username);
			$sth->bindValue(':fname',$fname);
			$sth->bindValue(':lname',$lname);
			$sth->bindValue(':email',$email);
			$sth->bindValue(':collegeID',$collegeID);
			$sth->bindValue(':active',1);
			$sth->bindValue(':joinDate',date('Y/m/d H:i:s'));
			
			//$sth ->execute();
			 if($sth ->execute() > 0)
			 {
				  echo "success";
			 }
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo " Error Code: " . $errorCode; 
			 }
			
			
		} // Ending bracket of IF($rows[0]==0)
		
		else
		{
			echo "You are already registered, Logging you in!";
		}
		
		}else{
		
		
		if($rows[0] == 0)  
		{
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO users(username,password,fname,lname,email,collegeID,activationKey,joinDate,profilePic) VALUES (:username,:password,:fname,:lname,:email,:collegeID,:activationKey,:joinDate,:profilePic)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':username',$username);
			$sth->bindValue(':password',$password_md5);
			$sth->bindValue(':fname',$fname);
			$sth->bindValue(':lname',$lname);
			$sth->bindValue(':email',$email);
			$sth->bindValue(':collegeID',$collegeID);
			$sth->bindValue(':activationKey',$activationKey);
			$sth->bindValue(':joinDate',date('Y/m/d H:i:s'));
			$sth->bindValue(':profilePic','profile_pic.png');
			//$sth ->execute();
			 if($sth ->execute())
			 { 
				echo "success";
				$to = $email;
				include 'newsletters/activation.php';
				//$msg = "http://www.fajjemobile.info/korkster.com/account-activation.php?activate=$activationKey";
				mail($to, $subject, $message, $headers);
			  }
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo "ErrorCode: " . $errorCode ." ".$sth->getMessage();  
			  }
			
			
		} // Ending bracket of IF($rows[0]==0)
		
		else
		{
			echo "username already exist";
		}
		
		}
		
			
		
		$dbh = null;   // setting the database connection to null
		
		
?>