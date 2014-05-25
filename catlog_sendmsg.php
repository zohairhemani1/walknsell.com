<?php
	
		header('Access-Control-Allow-Origin: *');
		include 'headers/connect_to_mysql.php';      // Connection to Mysql Database.
		//require_once('PHP/recaptchalib.php');   // Captcha Library.
		
		$sender = $_POST['sender'];
		$receiver = $_POST['reciever'];
		$korkid = $_POST['korkid'];
		$bid = $_POST['bid'];
		$message=$_POST['msg'];
		
		
			echo "<script>
			
			alert('$sender'+'$receiver'+'$bid'+'$message'+'$korkid');
			</script>";
			
			
			// inserting user details if username doesnot exist
			
			$query = "INSERT INTO inbox(username,fname,lname,email,collegeID,profilePic,joinDate,active) VALUES (:username,:fname,:lname,:email,:collegeID,:profilePic,:joinDate,:active)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':username',$username);
			$sth->bindValue(':fname',$fname);
			$sth->bindValue(':lname',$lname);
			
			//$sth ->execute();
			 if($sth ->execute())
			 { 
				}
			  
			 else 
			 {	
				$errorCode = $sth->errorCode();
				echo "ErrorCode: " . $errorCode; 
			  }
			
		
		
		
		
			
		
		$dbh = null;   // setting the database connection to null
		
		
?>