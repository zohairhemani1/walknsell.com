<?php
    header('Content-Type: application/json');
    session_start();
    include 'headers/_user-details.php';
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
		//$imgFrom = "korks"; // to upload the image in korkImages folder.
		
		//all text/strings from POST must be decoded.
		$korkname = urldecode($_POST['korkName']);
		$description = urldecode($_POST['korkDesc']);
		$price = $_POST['priceinput'];
		$category = $_POST['category'];
		$tags = $_POST['taginput'];
		$tagArr = explode("%2C", $tags);
        $publish = $_POST['publish'];
        $status = $_POST['status'];
        if ($publish == "on"){
        $publish = "1";
        }
		/*if($korkname==null)
		{
			echo "Enter Korkname.";
		}
		elseif($description==null)
		{
			echo "Enter Description";
		}
		if(!isset($profilePic)){
			$profilePic = "kork.png";
		}*/
		
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
		$stmt = $dbh->prepare("INSERT INTO korks(userID,title,detail,image,catID,collegeID,expirydate,price,publish,status) VALUES(:userID,:korkTitle,:desc,:profilePic,:category,:collegeID,:expirydate,:price,:publish,'1')");
		$stmt->bindValue(':userID',$_userID);
		$stmt->bindValue(':korkTitle',$korkname);
		$stmt->bindValue(':desc',$description);
		$stmt->bindValue(':profilePic',$profilePic[0]);
		$stmt->bindValue(':category',$category);
        $stmt->bindValue(':collegeID',$_college);
		$stmt->bindValue(':expirydate',date('Y/m/d H:i:s'));
		$stmt->bindValue(':price',$price);
        $stmt->bindValue(':publish',$publish);
		$flag = $stmt->execute();
		
		$stmt = $dbh->prepare("SELECT max(id) FROM korks WHERE userID = :username");
		$stmt->bindParam(':username', $_userID);
		$flag = $stmt->execute();
		$id = $stmt->fetchColumn();
		
		if(!empty($_FILES)){
			$sql = array();
			foreach( $profilePic as $pic ) {
				$sql[] = '('.$id.', "'.$pic.'")';
			}
			mysqli_query($con, 'INSERT INTO `kork_img` (`korkID`, `attachment`) VALUES '.implode(',', $sql));
		}
		for($i = 0; $i < count($tagArr); $i++){
            $tag = urldecode($tagArr[$i]);
			$dbh->exec("INSERT INTO kork_tags(korkId, tag) VALUES($id ,'$tag')");
		}
		if($flag){
			die(json_encode(array('request' => 'Deal created!', 'id' => $id)));
		}else{
			die(json_encode(array('request' => 'failed',)));
		}
		//header("Location: cate_desc.php?korkID=$id[0]");
}

// ending if block of $_POST
?>