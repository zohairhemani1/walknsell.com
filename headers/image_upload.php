<?php

include "connect_database.php";

if (mysql_error()) {  
    //echo "<h2>Failure:</h2><em>" . mysql_error() . "</em>";  
} else {  
    //echo "<h1>Success in database connection.</h1>";  
} 

$con=mysqli_connect("$db_host","$db_username","$db_pass","$db_name");

/*$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 20000000) && in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
        //echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else {
        //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        //echo "Type: " . $_FILES["file"]["type"] . "<br>";
        //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        //echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }
} else {
    //echo "Invalid file Restriction";
}*/
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES['file']["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 20000000) && in_array($extension, $allowedExts)) {
		if ($_FILES["file"]["error"] > 0) {
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} else {
					
					$file_extn = strtolower(end(explode('.', $_FILES['file']['name'])));
					$file_name = substr(md5(time()), 0, 10) . '.' . $file_extn;
					if($imgFrom == "korks"){
						move_uploaded_file($_FILES["file"]["tmp_name"], 'img/korkImages/' . $file_name);
					}else if($imgFrom == "users"){
						move_uploaded_file($_FILES["file"]["tmp_name"], 'img/users/' . $file_name);
					}
					$profilePic = $file_name;
		}
	} else {
		//echo "Invalid file Saving";
	}
?>