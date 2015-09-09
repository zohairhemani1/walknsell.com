<?php
session_start();
include 'headers/_user-details.php';
if(isset($_SESSION['username']) === false){
    header("Location: index.php");
    die();
}
else if(isset($_POST['query'])){
        $searchq = $_POST['query'];
		/*preg_replace("#[^0-9a-z]#i","",$searchq);
		$stmt = $dbh->prepare("SELECT ID FROM users WHERE username like :q");
		$stmt->bindValue(':q', "%$searchq%");
		$stmt->execute();
		$searchRows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);*/
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::WalknSell::</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<style>
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
	vertical-align: top;
}
.wrapper {
  min-height: 100%;
  margin-bottom: -118px; 
}
.wrapper:after {
  content: "";
  display: block;
}
.wrapper:after {
  height: 118px; 
}
</style>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/modern.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/nav-admin-dropdown.js"></script>
<script src="js/fb.js"></script>
<script src ="js/register.js"></script> 
<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
</script>
<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="wrapper">
    <div class="header_bg">
        <header class="main-header">
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>
           <?php include "headers/menu-top-navigation.php"; ?>
        </header></div>
        <?php include 'headers/subhead.php' ?>
        <div class="clear"></div>
    
<?php include 'headers/popup.php';?>
<div class="full_article_bg">
    <article  class="prod_detail">
        
    <?php
	include 'headers/connect_database.php';
	try {
		/*** The SQL SELECT statement ***/
	if(isset($_GET['category']) == true || isset($_POST['query']) == true){
				if(isset($_GET['category']) == true && isset($_POST['query']) == true){
						$cat_id = $_GET['category'];
						$sql = "SELECT k.status,k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where  k.catID = $cat_id AND k.status = 0 AND k.id IN ((Select kt.korkId FROM kork_tags kt where kt.tag like '%".mysqli_real_escape_string($con, $searchq)."%')) OR k.title Like '%".mysqli_real_escape_string($con, $searchq)."%' AND u.ID = $_userID group by k.id ORDER BY k.id DESC";
				}else{
					if(isset($_GET['category'])){
						$cat_id = $_GET['category'];
						$sql = "SELECT k.status,k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.catID = $cat_id AND k.status = 0 AND u.ID = $_userID  group by k.id ORDER BY k.id DESC";
					}else {
						$sql = "SELECT k.status,k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.status = 0 AND k.id IN ((Select kt.korkId FROM kork_tags kt where kt.tag like '%".mysqli_real_escape_string($con, $searchq)."%')) OR k.title Like '%".mysqli_real_escape_string($con, $searchq)."%' AND u.ID = $_userID  group by k.id ORDER BY k.id DESC";
                        
                        //$searchRows = implode(',',$searchRows);    
                        /*"SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.status = 0 AND k.userID IN ($searchRows) group by k.id ORDER BY k.id DESC";*/
					}
				}
			}
        else{$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, k.status, u.ID, u.collegeID, u.username, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.ID = $_userID group by k.id ORDER BY k.id DESC";
        }
         $result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		
		if($count==0){
			echo "<div id='contentSub' class='clearfix'>
					  <div class='contentBox'>
						  <p class='fontelico-emo-unhappy noKorks'> No Deals found.</p>
						  <p class='noKorksCreate'>Are you looking to buy or sell something at Walk n Sell?</p>
						  <p class='noKorksCreate'><a href='create_gig.php' class='entypo-pencil'> Create Your Deals!</a></p>
					  </div>
				  </div>";
		}
		
		$counter = 0;	 

		foreach ($dbh->query($sql) as $row)
		{		
				$counter++;
				$id = $row['id'];
				$title = $row['title'];
				$title_withDashes = str_replace(' ', '-', $title);
				$image = $row['image'];
				$expiryDate = $row['expirydate'];
				$detail = $row['detail'];
				$price = nice_number($row['price']);
				$bids = $row['bids'];
                $username = $row['username'];
				$status = $row['status'];
				if($status == 1){
					$status = "available";
				}else if($status == 0){
					$status = "sold";
				}else{
					$status = "expired";
				}
				echo "<div id='action'  class='prod_desc'><a href='cate_desc.php?korkID={$id}'>";
				echo "<span class='$status korkbadge'></span>";
				echo "<img class='main-prod-pic' src='img/korkImages/$image' width='247px' height='194px' alt=''>
                <a href='update_gig.php?id={$id}' target='_blank'><input title='Edit' class='update_button' type='button' value='' /></a>"
                    ;
				echo "<div class='details'>";
				echo "<h3 class='block-ellipsis' style='font-weight:bold;'>$title</h3></a>";
				echo "<h3 class='details-block-ellipsis'> $detail </h3></a>";
				echo "<p>By: <a href='/$username'>$username</a></p><p class='detail_timestamp'><span>".date('m-d-Y | h:i A', strtotime($expiryDate))."</p>
					 <div class='price'><span class='price_first'>Rs. {$price}</span><span class='prod_scheme'>&nbsp; {$bids} <span class='off'>BIDS</span></span></div>
				
					</div>
					<div class='clear'></div>
					</div>";
		}

		/*** close the database connection ***/
			$dbh = null;
		
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	?>
    <div class="clear"></div>
    </article>
    <div class="clear"></div>
    </div>

</div>
    <?php include 'headers/menu-bottom-navigation.php' ?>

    <script>    
function getlist(x){
    $(".hidee").hide();
    $("#veiwlist"+x).show();
}
</script>

<script src="js/school-list.js"></script>
    <script src="js/nav-admin-dropdown.js"></script>
<script src ="js/register.js"></script> 
</body>
</html>