<?php
	
	
		include 'headers/connect_to_mysql.php';      // Connection to Mysql Database.
		require_once('recaptchalib.php');   // Captcha Library.
		
		$username = $_POST['username'];
		
		
		$password = $_POST['password'];
		$password_md5 = md5($password);
		$fname = $_POST['firstName'];
		$lname = $_POST['lastName'];
		$email = $_POST['email'];
		$college = $_POST['search_text'];
		$email_validation = False;
		$privatekey = "6LcEDukSAAAAADGKIJhTfbItJBsTTw9vk7TvslPR";    // Captcha's Private Key
		$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
									
	
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				
				if(strpos($email,'edu')  == true ){
    				echo "This ($email) email address is considered valid. <br>";
					$email_validation = True;
				}
				else{
					echo "Only .EDU email addresses are allowed to register <br>";
				}	
			}
			
			else{
				echo "Email Format Incorrect. ";	
			}
	
									
		if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			echo "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				 "(reCAPTCHA said: " . $resp->error . ")";
		  } 
		  
		elseif($username == null || $password == null || $fname == null || $lname == null || $college == null ){
				echo "Please fill all the required fields<br>";
				}
				
		elseif(mysql_num_rows(mysql_query("SELECT username FROM users WHERE username like '$username'"))==1){
					echo "Username already in use. Please choose a different username.";
		}
		elseif($email_validation==False){
			
		}
		
		  else {
			$activationKey = md5(microtime().rand());
			
				
			    $dbh->exec("INSERT INTO users(username,password,fname,lname,email,college,activationKey) VALUES ('$username','$password_md5','$fname','$lname','$email','$college','$activationKey')");
			
			echo "Thanks for registering, please click on the activation link in your email.";
			 $dbh = null;
			
			$to = $email;
			$subject = "New User Registration.";
			$headers = "From: info@korkster.com" . "\r\n" .
			"CC: zohairhemani1@gmail.com";
			
			
			
			//$msg = "http://www.lol-ism.com/korkster/account-activation.php?activate=$activationKey";
			$msg = "http://www.lol-ism.com/korkster/activate/$activationKey";
			mail($to, $subject, $msg, $headers);
			
			
		
	  }
	
	
	
?>