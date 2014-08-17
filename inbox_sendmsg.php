<?php
	
		header('Access-Control-Allow-Origin: *');
		include 'headers/connect_database.php';      // Connection to Mysql Database.
		//require_once('PHP/recaptchalib.php');   // Captcha Library.
		
		$sender = $_POST['sender'];
		$receiver = $_POST['receiver'];
		$message=$_POST['msg'];
		
		
		
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO inbox(senderID,receiverID,message,dateM) VALUES (:senderID,:receiverID,:message,:dateM)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':senderID',$sender);
			$sth->bindValue(':receiverID',$receiver);
			$sth->bindValue(':message',$message);
			$sth->bindValue(':dateM',date('Y/m/d H:i:s'));
					
			//$sth ->execute();
			 if($sth ->execute())
			 { 
			 echo "Message Sent!";
			 }
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo "ErrorCode: " . $errorCode; 
			  }
			
		
		
		
		
			
		
		$dbh = null;   // setting the database connection to null
		
		
?>