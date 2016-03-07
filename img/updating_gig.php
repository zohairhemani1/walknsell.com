<?php
    session_start();
    include 'headers/_user-details.php';

if(isset($_GET['id']))
	{	
		
        $korkID = $_GET['id']; 
		$korkname = urldecode($_POST['korkName']);
		$description = urldecode($_POST['korkDesc']);
		$price = $_POST['priceinput'];
		$category = $_POST['category'];
		$tags = $_POST['taginput'];
		$tagArr = explode("%2C", $tags);
        $publish = $_POST['publish'];
        if ($publish == "on"){
        $publish = "1";
        }
        if ($status == "on"){
        $status = "1";
        }
		
        $stmt = $dbh->prepare("UPDATE korks set userID = :userID,title=:korkTitle,
        detail=:desc,catID=:category,expirydate=:expirydate,price=:price,publish = :publish where ID = :korkID");
		$stmt->bindParam(':korkID', $korkID);
        $stmt->bindValue(':userID',$_userID);
		$stmt->bindValue(':korkTitle',$korkname);
		$stmt->bindValue(':desc',$description);
		$stmt->bindValue(':category',$category);
        $stmt->bindValue('publish',$publish);
		$stmt->bindValue(':expirydate',date('Y/m/d H:i:s'));
		$stmt->bindValue(':price',$price);
		$flag = $stmt->execute();
		

        $delete_tag = "DELETE FROM kork_tags where KorkId = $korkID";
        $result = mysqli_query($con,$delete_tag)
            or die('error');
        
		for($i = 0; $i < count($tagArr); $i++){
            $tag = urldecode($tagArr[$i]);
			$dbh->exec("INSERT INTO kork_tags(korkId, tag) VALUES($korkID ,'$tag')");
		}
    
        $profilePic = array();
    
		if(!empty($_FILES))
        {
			for($i=0; $i<count($_FILES['files']['name']); $i++) {
				//$file_extn = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
				//$file_name = substr(md5(time()+$i), 0, 10) . '.' . $file_extn;
				//move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'img/korkImages/' . $file_name);
				$profilePic[] = $file_name;
			}
        var_dump($profilePic);
        }
		}else
        {
			$profilePic[] = "kork.png";
		}
    
		/*
            if($flag)
            {
                header("Location: cate_desc.php?korkID=$korkID");
                die(json_encode(array('request' => 'Deal Updated!', 'id' => $korkID)));
            }else
            {
                die(json_encode(array('request' => 'failed',)));
            }
        */
		
} // ending if block of $_POST
?>