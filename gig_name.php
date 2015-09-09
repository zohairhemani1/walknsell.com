<?php 
if (isset($_GET['id'])){
	include 'headers/connect_database.php';
        $korkID = 228;//$_GET['id'];
        $stmt = $dbh->prepare("SELECT attachment FROM kork_img where KorkID = :korkID");
        $stmt->bindParam(':korkID', $korkID);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $kork_images = array();
    foreach($result as $row) {
        $kork_images[] = $row['attachment'];
    }
foreach($kork_images as $file){ //get an array which has the names of all the files and loop through it 
        $obj['name'] = $file; //get the filename in array
        $obj['size'] = filesize("img/korkImages/".$file); //get the flesize in array
        $result[] = $obj; // copy it to another array
      }
header('Content-Type: application/json');
      json_encode($result); // now you have a json response which you can use in client side 
}
?>