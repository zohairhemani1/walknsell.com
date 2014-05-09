<?php
	
		header('Access-Control-Allow-Origin: *');
		include 'headers/connect_to_mysql.php';      // Connection to Mysql Database.
		//require_once('PHP/recaptchalib.php');   // Captcha Library.
		
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
		
		
		// this condition checks if count(*) is 0 that means if username doesnot exist
		
		if($rows[0] == 0)  
		{
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO users(username,password,fname,lname,email,college,activationKey) VALUES (:username,:password,:fname,:lname,:email,:college,:activationKey)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':username',$username);
			$sth->bindValue(':password',$password_md5);
			$sth->bindValue(':fname',$fname);
			$sth->bindValue(':lname',$lname);
			$sth->bindValue(':email',$email);
			$sth->bindValue(':college',$college);
			$sth->bindValue(':activationKey',$activationKey);
			//$sth ->execute();
			 if($sth ->execute())
			 { 
				echo "success";
				$to = $email;
				$subject = "SchoolBook: Verify Account";
				$headers = "From: info@schoolbook.com" . "\r\n" .
							"CC: zohairhemani1@gmail.com";
			  }
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo "ErrorCode: " . $errorCode;  
			  }
			
			
		} // Ending bracket of IF($rows[0]==0)
		
		else
		{
			echo "username already exist";
		}
		
		
		
			
		
		$dbh = null;   // setting the database connection to null
		
		
		
		
		
		$msg = "http://www.lol-ism.com/korkster/account-activation.php?activate=$activationKey";
		//$msg = "http://www.lol-ism.com/korkster/activate/$activationKey";
		mail($to, $subject, $msg, $headers);
	
?>