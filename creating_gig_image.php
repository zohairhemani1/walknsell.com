<?php	
    session_start();
	include 'headers/connect_database.php';
    include 'headers/_user-details.php';
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
		$profilePic = array();
		if(!empty($_FILES)){
			for($i=0; $i<count($_FILES['files']['name']); $i++) {
				$file_extn = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
				$file_name = substr(md5(time()+$i), 0, 10) . '.' . $file_extn;
				move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'img/korkImages/' . $file_name);
				$profilePic[] = $file_name;
			}
		}else{
			$profilePic[] = "kork.png";
		}
    
		$stmt = $dbh->prepare("SELECT max(id) FROM korks WHERE userID = :username");
		$stmt->bindParam(':username', $_userID);
		$flag = $stmt->execute();
        var_dump($flag);
		$id = $stmt->fetchColumn();
		
		if(!empty($_FILES)){
			$sql = array();
			foreach( $profilePic as $pic ) {
				$sql[] = '('.$id.', "'.$pic.'")';
			}
			mysqli_query($con, 'INSERT INTO `kork_img` (`korkID`, `attachment`) VALUES '.implode(',', $sql));
		}
		if($flag){
			die(json_encode(array('request' => 'Deal created!', 'id' => $id)));
		}else{
			die(json_encode(array('request' => 'failed',)));
		}
		header("Location: cate_desc.php?korkID=$id[0]");
    }
?>