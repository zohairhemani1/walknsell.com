<?php 
    session_start();
    include 'headers/_user-details.php';
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
                $korkID = $_GET['id']; 
        		$korkname = urldecode($_POST['korkName']);
        		$description = urldecode($_POST['korkDesc']);
        		$price = $_POST['priceinput'];
        		$category = $_POST['category'];
        		$tags = $_POST['taginput'];
        		$tagArr = explode("%2C", $tags);
                $publish = $_POST['publish'];
                if ($publish == "on")
                {
                    $publish = "1";
                }


if(isset($_GET['id']))
{
        $korkID = $_GET['id'];
            $stmt = $dbh->prepare("UPDATE korks set userID = :userID,title=:korkTitle,detail=:desc,catID=:category,expirydate=:expirydate,price=:price,publish = :publish where ID = :korkID");
        		$stmt->bindParam(':korkID', $korkID);
                $stmt->bindValue(':userID',$_userID);
        		$stmt->bindValue(':korkTitle',$korkname);
        		$stmt->bindValue(':desc',$description);
        		$stmt->bindValue(':category',$category);
                $stmt->bindValue(':publish',$publish);
        		$stmt->bindValue(':expirydate',date('Y/m/d H:i:s'));
        		$stmt->bindValue(':price',$price);
                $flag = $stmt->execute();


                $delete_tag = "DELETE FROM kork_tags where KorkId = $korkID";
                $result = mysqli_query($con,$delete_tag)
                    or die('error');
                
        		for($i = 0; $i < count($tagArr); $i++)
                {
                    $tag = urldecode($tagArr[$i]);
        			$dbh->exec("INSERT INTO kork_tags(korkId, tag) VALUES($korkID ,'$tag')");
        		}
    
    
                $profilePic = array();
                if(!empty($_FILES)){
                for($i=0; $i<count($_FILES['files']['name']); $i++) {

                    $explode_file = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
                    $file_extn = $explode_file;
                    $file_name = substr(md5(time()+$i), 0, 10) . '.' . $file_extn;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'img/korkImages/' . $file_name);
                    $profilePic[] = $file_name;
                }
            }else{
                $profilePic[] = "kork.png";
            }

    		$stmt = $dbh->prepare("SELECT id FROM korks WHERE userID = :username AND id  = '$korkID'");
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
			die(json_encode(array('request' => 'Deal Updated!', 'id' => $id)));
		}else{
			die(json_encode(array('request' => 'failed',)));
		}
    
    var_dump($flag);

    

    }
}
?>