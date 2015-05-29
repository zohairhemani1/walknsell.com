<?php
session_start();
include 'headers/_user-details.php';
	$school_hypens = $_GET['schoolName'];
	$school = str_replace('-', ' ', $school_hypens);
	$school_id = $_GET['schoolID'];
	
	if(isset($_POST['query'])){
		$searchq = $_POST['query'];
		preg_replace("#[^0-9a-z]#i","",$searchq);
		$stmt = $dbh->prepare("SELECT ID FROM users WHERE username like :q");
		$stmt->bindValue(':q', "%$searchq%");
		$stmt->execute();
		$searchRows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		/*foreach($dbh->query("SELECT * FROM users WHERE username like '%$searchq%'") as $row){
			echo $row['ID'];
		}*/
	}
	
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

function parallax(){
	//var scrollposition = $(window).scrollTop();
	//$('article.header_bg_para').css('top',(0-(scrollposition * 0.2))+'px');
	//$('.full_article_bg').css('top',(0-(scrollposition * 0.5))+'px');
	}
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
		<?php include 'headers/subhead.php' ?>
        <div class="clear"></div>
        
        <div class="submenu_wrap">
        <div class="category_submenu">
        	<nav>
            	<ul class="topic-list">
                                <li><a href="#">Advertising</a></li>
                                <li><a href="#">Video &amp; Animation</a></li>
                                <li><a href="#">Graphics &amp; Design</a></li>
                                <li><a href="#">Programming &amp; Tech</a></li>
                                <li><a href="#">Music &amp; Audio</a></li>
                                <li><a href="#">Gifts</a></li>
                                <li><a href="#">Fun &amp; Bizarre</a></li>
                                <li><a href="#">Online Marketing</a></li>
                                <li><a href="#">Writing &amp; Translation</a></li>
                            </ul>
            </nav>
        </div>
        </div>
    </div><!--/.header_bg-->
    <article class="header_bg_para">
    	<div class="banner_static">
        	<div class="left_alpha">
            <h2>Over 2 Thousand Services</h2>
        	<p>WalknSell is a social website that helps students and teachers like you post classifieds related to your school or university.</p>
            </div>
            <div class="right_link"><a href="#"></a></div>
            <div class="clear"></div>
        </div>
    	
        <?php
           include 'headers/popup.php';?>
    </article>
    
    <div class="full_article_bg">
    <article  class="prod_detail">
    
    
    
    <?php
		
		include 'headers/connect_database.php';
			
			
		try {
			/*** The SQL SELECT statement ***/
			if(isset($_GET['category']) == true || empty($searchRows) == false){
				if(isset($_GET['category']) == true && empty($searchRows) == false){
						$cat_id = $_GET['category'];
						$searchRows = implode(',',$searchRows);
						$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.catID = $cat_id AND k.status = 0 AND k.userID IN ($searchRows) group by k.id ORDER BY k.id DESC";
				}else{
					if(isset($_GET['category'])){
						$cat_id = $_GET['category'];
						$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.catID = $cat_id AND k.status = 0 group by k.id ORDER BY k.id DESC";
					}else {
						$searchRows = implode(',',$searchRows);
						$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.status = 0 AND k.userID IN ($searchRows) group by k.id ORDER BY k.id DESC";
					}
				}
			}else{
				$sql = "SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.status = 0 group by k.id ORDER BY k.id DESC";
			}
			$result = mysqli_query($con,$sql);
			$count = mysqli_num_rows($result);
			
			if($count==0){
				echo "<div id='contentSub' class='clearfix'>
						  <div class='contentBox'>
							  <p class='fontelico-emo-unhappy noKorks'> No Korks found.</p>
							  <p class='noKorksCreate'>Are you looking to buy or sell something at ".ucwords(strtolower($school))."?</p>
							  <p class='noKorksCreate'><a href='create_gig.php' class='entypo-pencil'> Create Your Kork!</a></p>
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
					$bids=$row['bids'];
					$status = "available";
					
					echo "<div class='prod_desc'>";
					echo "<span class='$status korkbadge'></span>";
					echo "<img class='main-prod-pic' src='img/korkImages/$image' width='247' style='max-height:172px;' alt=''>";
					echo "<div class='details'>";
					echo "<a href='cate_desc.php?korkID={$id}'><h3 style='font-weight:bold;height:2.5em;overflow:hidden;'>$title</h3></a>";
					echo "<a href='cate_desc.php?korkID={$id}'><div class='kork_text_wrap'><h3> $detail </h3></div></a>";					
					echo"<p><span> $expiryDate <span> | <span>12:03 PM<span></p>
						 <div class='price'><span class='price_first'>$ {$price}</span><span class='prod_scheme'>&nbsp; {$bids} <span class='off'>BID",$bids > 1 ? "S" : "","</span></span></div>
					
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
