<?php
session_start();
include 'headers/_user-details.php';
	$school_hypens = $_GET['schoolName'];
	$school = str_replace('-', ' ', $school_hypens);
	$school_id = $_GET['schoolID'];	
	if(isset($_POST['query'])){
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
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css" type="text/css">
<script src="/js/jquery-1.10.2.min.js"></script>
	<script>
// 	$(document).ready(function () {
// 	$('.imgae-loader').css("display","none");
// 	$('.result-text').css("display","none");
//     var size_div = $("#prod_desc").size();	
//   	console.log(size_div);
//     x=10;

//  	$(window).scroll(function() {
//    if($(window).scrollTop() + $(window).height() == $(document).height()) {
// 		console.log($(window).height()+"<window height");
// 		console.log($(document).height()+"<document height");
// 		console.log($(window).scrollTop()+"<window scroll top");
	    
// 	   if(x != size_div){
// 		$('.imgae-loader').css("display","block");

// 	   var myVar = setInterval(myTimer, 3000);
// 	   function myTimer() {
// 	   x = (x+6 <= size_div) ? x+6 : size_div;
// 		$('.imgae-loader').css("display","none");
//         $('#prod_desc:lt('+x+')').show();
// 		   window.scrollBy(0, -25);
// 		   clearInterval(myVar);
// 	   }
// 					}
// 	else{
// 			$('.result-text').css("display","block");
// 	}	

// }
// });

// });
</script>

<script src="/js/modern.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.sidr.min.js"></script>
<script src="/js/custom.js"></script>
<script src="/js/nav-admin-dropdown.js"></script>
<!-- <script src="/js/fb.js"></script> -->
<script src ="/js/register.js"></script> 
<link rel="stylesheet" href="/css/media.css" type="text/css">
<link rel="stylesheet" href="/css/fontello.css" type="text/css">
<link rel="stylesheet" href="/css/jquery.sidr.dark.css" type="text/css">
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">



  <link rel="stylesheet" href="/css/reset.css"> <!-- CSS reset -->
  <link rel="stylesheet" href="/css/slide.css"> <!-- Resource style -->
  <script src="/js/modernizr.js"></script> <!-- Modernizr -->

<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>-->
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
<div>
	    <div class="header_bg">
      <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
        <?php include 'headers/menu-top-navigation.php';?>
      </header>
    </div>
      <?php 
    if(isset($_SESSION['username'])){
    include 'headers/subhead.php';}
     ?>
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
  <article>
  <section class="cd-hero">
    <ul class="cd-hero-slider autoplay">

      <li class="selected">
      <div class="banner_static">
          <div class="left_alpha">
            <h2>Over 2 Thousand Services</h2>
          <p>WalknSell is a social website that helps students and teachers like you post classifieds related to your school or university.</p>
            </div>
            <div class="right_link"><a href="#"></a></div>
            <div class="clear"></div>
        </div>
      </li>

      <li>
      <div class="banner_static">
          <div class="left_alpha">
            <h2>Over 2 Thousand Services</h2>
          <p>WalknSell is a social website that helps students and teachers like you post classifieds related to your school or university.</p>
            </div>
            <div class="right_link"><a href="#"></a></div>
            <div class="clear"></div>
        </div>
      </li>
    </ul> <!-- .cd-hero-slider -->
  </section> <!-- .cd-hero -->

  </article>

  <?php include 'headers/popup.php';?>
     <div class="full_article_bg featured_prod">
    
    <?php
		include 'headers/connect_database.php';
			
			
		try {
			/*** The SQL SELECT statement ***/
			if(isset($_GET['category']) == true || isset($_POST['query']) == true){
				if(isset($_GET['category']) == true && isset($_POST['query']) == true){
						$cat_id = $_GET['category'];
						$sql = "SELECT k.id,k.publish,k.status, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.id IN ((Select kt.korkId FROM kork_tags kt where kt.tag like '%".mysqli_real_escape_string($con, $searchq)."%')) OR k.title Like '%".mysqli_real_escape_string($con, $searchq)."%' AND k.catID = $cat_id   AND k.collegeID = $school_id and k.status = 1 and k.publish = 1 group by k.id ORDER BY k.id DESC";
				}else{
					if(isset($_GET['category'])){
						$cat_id = $_GET['category'];
						$sql = "SELECT k.id,k.publish,k.status, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.collegeID = $school_id AND k.catID = $cat_id and k.status = 1 and k.publish = 1 group by k.id ORDER BY k.id DESC";
					}else {
						$sql = "SELECT k.id,k.publish,k.status, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.id IN ((Select kt.korkId FROM kork_tags kt where kt.tag like '%".mysqli_real_escape_string($con, $searchq)."%')) OR k.title Like '%".mysqli_real_escape_string($con, $searchq)."%' AND k.collegeID = $school_id and k.status = 1 and k.publish = 1 group by k.id ORDER BY k.id DESC";
                        
                        //$searchRows = implode(',',$searchRows);    
                        /*"SELECT k.id, k.title, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where u.collegeID = $school_id AND k.status = 0 AND k.userID IN ($searchRows) group by k.id ORDER BY k.id DESC";*/
					}
				}
			}else{
				$sql = "SELECT k.id, k.title,k.publish,k.status, k.userID, k.detail, k.price, k.image, k.expirydate, u.ID, u.username, u.collegeID, count(i.ID) as `bids` FROM `korks` k join `users` u on u.ID = k.userID left outer join `inbox` i on k.id = i.korkID where k.collegeID = $school_id and k.status = 1 and k.publish = 1 group by k.id ORDER BY k.id DESC";
			}
			$result = mysqli_query($con,$sql);
			$count = mysqli_num_rows($result);
			
            if(isset($_POST['query'])){
                    echo "<div class='searchmsg'><p class='alert-notice'>$count search result",($count == 1) ? "" : "s"," found for '$searchq'.</p>
                    </div>";
            } ?>
        
    <article  class="prod_detail col-lg-12">
      	<ul class="row">			
    <?php if($count==0){
				echo "<div id='contentSub' class='clearfix'>
						  <div class='contentBox'>
							  <p class='fontelico-emo-unhappy noKorks'> No Deal found.</p>";
                            if(isset($_SESSION['username']) && $_college == $school_id){
							  echo "<p class='noKorksCreate'>Are you looking to buy or sell something at ".ucwords(strtolower($school))."?</p>
                              <p class='noKorksCreate'><a href='/manage_deals/new' class='entypo-pencil'> Create Your Deal!</a></p>";
                            }
						  echo" </div>
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
					$price=nice_number($row['price']);
					$bids=$row['bids'];
                    $username = $row['username'];
					$status = $row['status'];
                    $publish = $row['publish'];
                    if($publish == "1"){
                    if($status == "1"){
                    $status = "available";
                    }    
            echo "<li id='prod_desc' class='col-lg-3 col-md-6 col-sm-6' id=''>
            <a href='/$username/{$title_withDashes}/{$id}' id='gig_link'>
                   
                    <div class='col-lg-12 single_product' style='width:234px;height: 260px;'>
                        <p style='position:absolute;top: 4px;padding-top: 6px;font-size: 12px;' class='prod_cat_22'><b>By:</b> $username</p>
                        <div class='img_wrap'>
                            <img src='/img/korkImages/$image' width='234' alt='' class='img-responsive'>
                        <h3 style='margin-top: 143px;position: absolute;' class='block-ellipsis'>$title</h3>
             <p class='gig_avialable'>Available</p>
                        </div>
              <div class='price'>
                            <span class='price_first'>Rs. $price</span>
                            <span class='prod_scheme'>$bids BID",($bids > 1) ? "S" : "","</span>
                        </div>
                     </div>
                </a></li>
";

     //                echo "<div class='prod_desc'><a href='/$username/$title_withDashes/{$id}'>";
					// echo "<span class='$status korkbadge'></span>";
					// echo "<img class='main-prod-pic' src='/img/korkImages/$image' width='247px' height='194px' alt=''>";
					// echo "<div class='details'>";
					// echo "<h3 class='block-ellipsis' style='font-weight:bold;'>$title</h3>";
					// echo "<h3 class='details-block-ellipsis'> $detail </h3></a>";
     //                echo "<p>By: <a href='/$username'>$username</a></p>
					// 	 <div class='price'><span class='price_first'>Rs. {$price}</span><span class='prod_scheme'>&nbsp;&nbsp; {$bids} <span class='off'>BID",$bids > 1 ? "S" : "","</span></span></div>
					
					// 	</div>
						
                    }
                }


                    }
// <p class='detail_timestamp'><span> ".date('m-d-Y | h:i A', strtotime($expiryDate))." </span></p>
			/*** close the database connection ***/
//				$dbh = null;
			
			
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}

	?>
    <div class="clear"></div>
<!-- 	<div class='imgae-loader'><img src='/img/bx_loader.gif' /></div>
	<div class="result-text"><p>No More Deals Found!</p></div> -->
 		</ul>
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
<script type="text/javascript">
$(document).ready(function() {

  $(".single_product").hover(

    function () {

       $(this).find(".img_wrap img ,.img_wrap h3,.gig_avialable").stop().animate({
            top: '36px'
        }, 'fast');
      $(this).find('.gig_avialable').slideDown('normal');
      $(this).find('.block-ellipsis').css('color','#00b22d');
      $(this).find('.block-ellipsis').css('text-decoration','underline'); 
    },

    function () {
        $(this).find(".img_wrap img ,.img_wrap h3,.gig_avialable").stop().animate({
            top: '6'
        }, 'normal');
	      // $(this).find('.gig_avialable').slideUp('fast');
          $(this).find('.block-ellipsis').css('color','#030303');
	      $(this).find('.block-ellipsis').css('text-decoration','none');
  });

});

</script> 


<script src="/js/school-list.js"></script>
<script src="/js/slide.js"></script>
</body>
</html>
