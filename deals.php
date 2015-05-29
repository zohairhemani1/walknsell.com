<?php
session_start();
include 'headers/_user-details.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::WalknSell::</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style>
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
	vertical-align: top;
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

$(document).ready(function() {
   $(window).bind('scroll', function(e){
	   parallax();
	  });
});
</script>
<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div >
	<div class="header_bg static_top">
        <header class="main-header">
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>

       
            <?php include 'headers/menu-top-navigation.php';?>
        </header>

<div class="full_article_bg">
    <article  class="prod_detail">
    
    
    
    <?php
		
	include 'headers/connect_database.php';
		
		
	try {
		/*** The SQL SELECT statement ***/
		$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, k.status, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.ID = $_userID group by k.id ORDER BY k.id DESC";
		$result = mysqli_query($con,$sql);
		$count = mysqli_num_rows($result);
		
		if($count==0){
			echo "<div id='contentSub' class='clearfix'>
					  <div class='contentBox'>
						  <p class='fontelico-emo-unhappy noKorks'> No Korks found.</p>
						  <p class='noKorksCreate'>Are you looking to buy or sell something at Southern Polytechnic State University?</p>
						  <p class='noKorksCreate'><a href='/create-kork' class='entypo-pencil'> Create Your Kork!</a></p>
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
				$price=$row['price'];
				$price=$row['price'];
				$bids=$row['bids'];
				$status = $row['status'];
				if($status == 0){
					$status = "available";
				}else if($status == 1){
					$status = "sold";
				}else{
					$status = "expired";
				}
				echo "<div class='prod_desc'>";
				echo "<span class='$status korkbadge'></span>";
				echo "<img class='main-prod-pic' src='img/korkImages/$image' width='247' style='max-height:172px;' alt=''>";
				echo "<div class='details'>";
				echo "<a href='cate_desc.php?korkID={$id}'><h3 style='font-weight:bold;height:2.5em;overflow:hidden;'>$title</h3></a>";
				echo "<a href='cate_desc.php?korkID={$id}'><div class='kork_text_wrap'><h3> $detail </h3></div></a>";
				
				
				echo"<p><span> $expiryDate <span> | <span>12:03 PM<span></p>
					 <div class='price'><span class='price_first'>$ {$price}</span><span class='prod_scheme'>&nbsp; {$bids} <span class='off'>BIDS																	</span></span></div>
				
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

    <?php include 'headers/menu-bottom-navigation.php' ?>
</div>
<script>
function getlist(x){
    $(".hidee").hide();
    $("#veiwlist"+x).show();
}
</script>

<script src="js/school-list.js"></script>

</body>
</html>