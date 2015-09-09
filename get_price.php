<?php
include 'headers/connect_to_mysql.php';
if(!empty($_POST["senderID"])) {
    $senderID = $_POST['senderID'];
    $korkID = $_GET['korkID'];
	$query ="SELECT bid FROM inbox WHERE senderID = $senderID and korkID = $korkID";
    $results = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($results)){
        $bid = $row['bid'];
        echo $bid;
  }
}
?>