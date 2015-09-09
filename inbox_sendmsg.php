<?php
	
		header('Content-Type: application/json');
		include 'headers/connect_database.php';      // Connection to Mysql Database.
		 date_default_timezone_set("Asia/Karachi");

		$sender = $_POST['sender'];
		$receiver = $_POST['receiver'];
		$message = $_POST['msgText'];

		// inserting user details if username doesnot exist
        if($_FILES['FileUpload']['tmp_name'][0] == "" && $_FILES['FileUpload']['error'] !== 0){
            $query = "INSERT INTO inbox(senderID,receiverID,message,dateM) VALUES (:senderID,:receiverID,:message,:dateM)";
            $sth = $dbh->prepare($query);
            $sth->bindValue(':senderID',$sender);
            $sth->bindValue(':receiverID',$receiver);
            $sth->bindValue(':message',$message);
            $sth->bindValue(':dateM',date('Y/m/d H:i:s'));

            if($sth ->execute()){ 
                die(json_encode(array('request' => 'Message Sent!',)));
            }else{	
                die(json_encode(array('request' => 'failed',)));
            }
        }else{
            //$display_names = array();
            $attachments = array();
            for($i=0; $i<count($_FILES['FileUpload']['name']); $i++) {
                //$display_names[] = $_FILES['FileUpload']['name'][$i];
                $file_extn = strtolower(end(explode('.', $_FILES['FileUpload']['name'][$i])));
				$file_name = substr(md5(time()), 0, 10) . '.' . $file_extn;
                move_uploaded_file($_FILES["FileUpload"]["tmp_name"][$i], 'assets/inboxData/' . $file_name);
                $attachments[] = $file_name;
            }

            $query = "INSERT INTO inbox(senderID,receiverID,message,dateM) VALUES (:senderID,:receiverID,:message,:dateM)";
            $sth = $dbh->prepare($query);
            $sth->bindValue(':senderID',$sender);
            $sth->bindValue(':receiverID',$receiver);
            $sth->bindValue(':message',$message);
            $sth->bindValue(':dateM',date('Y/m/d H:i:s'));
            $flag = $sth->execute();
            $id = $dbh->lastInsertId();
            if($flag && !empty($_FILES)){
                $sql = array();
                for($i=0; $i<count($_FILES['FileUpload']['name']); $i++) {
                    $sql[] = '('.$id.', "'.$attachments[$i].'", "'.mysqli_real_escape_string($con, $_FILES['FileUpload']['name'][$i]).'")';
                }
                mysqli_query($con, 'INSERT INTO `inbox_attachments` (`inboxID`, `attachment`, `displayname`) VALUES '.implode(',', $sql));
            }
            //$sth ->execute();
             if($flag)
             { 
                die(json_encode(array('request' => 'Message Sent!', 'files' => $attachments)));
             }else{
                die(json_encode(array('request' => 'failed',)));
             }
        }
		
		$dbh = null;   // setting the database connection to null
		
		
?>