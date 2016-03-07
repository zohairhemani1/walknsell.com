<?php 
ob_start();
session_start();
include 'headers/connect_database.php';
include 'headers/_user-details.php';
	$korkID = $_GET['id'];
    if(isset($_GET['id'])){
    $korkID = $_GET['id'];
    $stmt = $dbh->prepare("UPDATE korks set status = 0 where id = :korkID");
    $stmt->bindParam(':korkID', $korkID);
    $stmt->execute();
        
    // for fething deal title

    $query_deal  = "SELECT * FROM korks where id = '$korkID'";
    $result_deal =  mysqli_query($con,$query_deal);
    $row_deal  =mysqli_fetch_array($result_deal);
    $title = $row_deal['title'];
    $title_withDashes = str_replace(' ', '-', $title);



    $userID = $_POST['userID'];
    $price = $_POST['price'];
    $stmt = $dbh->prepare("INSERT INTO kork_sell (userID,price,korkID) VALUES ('$userID','$price','$korkID')");
    $stmt->bindValue(':userID', $_userID);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':korkID', $korkID);
     $stmt ->execute();
 
    $query_email =  "SELECT u.email,u.username FROM users u INNER JOIN inbox i on u.ID = i.senderID where i.korkID = '$korkID'"
    or die('error2');
    $result_query = mysqli_query($con,$query_email);
    
    while ($row = mysqli_fetch_array($result_query)) {
    $to = $row['email'];
    $username = $row['username'];
    include 'newsletters/bid_user.php';    
     mail($to, $subject, $message, $headers);

    header("Location: /$_username/{$title_withDashes}/{$korkID}");
    }

    }
?>