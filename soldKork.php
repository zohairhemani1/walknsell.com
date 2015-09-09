<?php 
	include 'headers/_user-details.php';
	$korkID = $_GET['id'];
    if(isset($_GET['id'])){
    $korkID = $_GET['id'];
    $stmt = $dbh->prepare("UPDATE korks set status = 0 where id = :korkID");
    $stmt->bindParam(':korkID', $korkID);
    $stmt->execute();

    
    $userID = $_POST['userID'];
    $price = $_POST['price'];
    $stmt = $dbh->prepare("INSERT INTO kork_sell (userID,price,korkID) VALUES ('$userID','$price','$korkID')");
    $stmt->bindValue(':userID', $userID);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':korkID', $korkID);
    $stmt->execute();
    
    header("Location: cate_desc.php?korkID=$korkID");
    }
?>