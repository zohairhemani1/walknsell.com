<?php
session_start();	
	
	include 'headers/_user-details.php';
	$korkID = $_GET['korkID'];
	//$korkName_Hypens = $_GET['kork'];
	//$korkName = str_replace('-', ' ', $korkName_Hypens);
	
  	$stmt = $dbh->prepare("SELECT * FROM korks WHERE id = :korkid");
    $stmt->bindParam(':korkid', $korkID);
    $stmt->execute();
    $result = $stmt->fetchAll();
	$result=$result[0];
	$row = $result;
	
    $id  = $row['id'];
	$title = $row['title'];
	$detail = $row['detail'];
	$status = $row['status'];
	$dateOfCreation = $row['expirydate'];
	
	/* Checking to see how many days have passed since the gig created */
	
	$now = time(); // or your date as well
    $dateOfCreation = strtotime($dateOfCreation);
    $datediff = $now - $dateOfCreation;
    $daysPassed = floor($datediff/(60*60*24));
	
	
 	$date = DateTime::createFromFormat("Y-m-d", $dateOfCreation);
	
    $_joinDate = strtotime($_joinDate);
    $datediff_user = $now - $_joinDate;
    $joinedAgo = floor($datediff_user/(60*60*24));
	
	/* 
		Calculating number of days ago username joined.
	*/
	
	
	
	
	
	$image = $row['image'];
	$userID = $row['userID'];

	

/*
	if($_POST){
		
		
			
		$name = $_POST['name'];
		$phoneEmail = $_POST['phoneEmail'];
		$message = $_POST['message'];
		$headers = "From: info@korkster.com" . "\r\n" . "CC: zohairhemani1gmail.com";
		$msg_email = "Name: {$name} <br /> Phone/Email: {$phoneEmail} <br /> Message: {$message} ";
		
		
	    $stmt = $dbh->prepare(" SELECT email FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR,15);

    	$stmt->execute();

    	$result = $stmt->fetchAll();
		$row=$result[0];

		$email = $row['email'];
		
		
		$privatekey = "6LcEDukSAAAAADGKIJhTfbItJBsTTw9vk7TvslPR";    // Captcha's Private Key
		$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
		if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			echo "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				 "(reCAPTCHA said: " . $resp->error . ")";
		  }
		else{
			
			mail($email,"Kork Contact Email",$message,$headers);
			echo "Email Sent Successfully to the Seller.";
		
		}
				
			
	}
	
	*/
	
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php echo $title; ?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.bxslider.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">

<script src="js/modern.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.fitvids.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/bootstrap.min.js"></script>

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
	var scrollposition = $(window).scrollTop();
	$('article.header_bg_para').css('top',(0-(scrollposition * 0.2))+'px');
	$('.full_article_bg').css('top',(0-(scrollposition * 1.1))+'px');
	}
</script>




<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="container cate_desc">
	<div class="header_bg static_top">
        <header>
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>

        <div id="sidr">
          <ul>
            <li class="home"><a href="#">HOME</a></li>
             <li class="to_do"><a href="#">START SELLING</a></li>
              <!-- <li class="bubble"><a href="#"><img src="img/bubble.png" width="24" alt=""></a></li> -->
              <li class="shopping"><a href="#">SIGN IN</a></li>
              <li id="sales"><a href="#">JOIN</a></li>
              <!-- <li class="admin"><a href="#">ZOHAIR HEMANI</a></li> -->
          </ul>
		</div>
            <div class="logo"><a href="#"><img src="img/logo.png" width="153" alt=""></a></div>
            <?php include 'headers/menu-top-navigation.php';?>
        </header>
       <nav class="category_nav main-category-search">
        	<div class="category_inner">
            	<div class="fake-dropdown fake-dropdown-double">
                   <a href="#" class="dropdown-toggle category" data-toggle="dropdown" data-autowidth="true" rel="nofollow">CATEGORIES</a>
                            <div class="dropdown-menu mega_menu" role="menu">
                                <div class="dropdown-inner">
                                    <span class="arr"></span>
                                    <span class="rightie"></span>
                                    <ul>
                                                <li><a href="#" onMouseOver="getlist(1)">Gifts</a></li>
                                                <li><a href="#"onmouseover="getlist(2)">Graphics & Design</a></li>
                                                <li><a href="#"onmouseover="getlist(3)">Video & Animation</a></li>
                                                <li><a href="#"onmouseover="getlist(4)">Online Marketing</a></li>
                                                <li><a href="#"onmouseover="getlist(5)">Writing & Translation</a></li>
                                                <li><a href="#"onmouseover="getlist(6)">Advertising</a></li>
                                                <li><a href="#"onmouseover="getlist(7)">Business</a></li>             
                                    </ul>
                                    <div class="side-menu">
                                                <ul class="hidee" id="veiwlist1">
                                                    <li><h5><a href="#">Gifts</a></h5></li>
                                                    <li><a href="#">Greeting Cards</a></li>
                                                    <li><a href="#">Video Greetings</a></li>
                                                    <li><a href="#">Unusual Gifts</a></li>
                                                    <li><a href="#">Arts & Crafts</a></li>

                                                </ul>
                                                <ul class="hidee"id="veiwlist2">
                                                 
                                                    <li><h5><a href="#">Graphics & Design</a></h5></li>
                                                    <li><a href="#">Cartoons & Caricatures</a></li>
                                                    <li><a href="#">Logo Design</a></li>
                                                    <li><a href="#">Illustration</a></li>
                                                    <li><a href="#">Ebook Covers & Packages</a></li>
                                                    <li><a href="#">Web Design & UI</a></li>
                                                    <li><a href="#">Photography & Photoshopping</a></li>
                                                    <li><a href="#">Presentation Design</a></li>
                                                    <li><a href="#">Flyers & Brochures </a></li>
                                                    <li><a href="#">Business Cards</a></li>
                                                    <li><a href="#">Banners & Headers</a></li>
                                                    <li><a href="#">Architecture</a></li>
                                                    <li><a href="#">Landing Pages</a></li>
                                                    <li><a href="#">Other</a></li>
                                             
                                                </ul>
                                                <ul class="hidee" id="veiwlist3">
                                                    <li><h5><a href="#">Video & Animation</a></h5></li>
                                                    <li><a href="#">Commercials</a></li>
                                                    <li><a href="#">Editing & Post Production</a></li>
                                                    <li><a href="#">Animation & 3D</a></li>
                                                    <li><a href="#">Testimonials & Reviews by Actors</a></li>
                                                    <li><a href="#">Puppets</a></li>
                                                    <li><a href="#">Stop Motion</a></li>
                                                    <li><a href="#">Intros</a></li>
                                                    <li><a href="#">Other</a></li>
                                                </ul>
                                                <ul class="hidee" id="veiwlist4">
                                                   <li><h5><a href="#">Online Marketing</a></h5></li>
                                                    <li><a href="#">Web Analytics</a></li>
                                                    <li><a href="#">Article & PR Submission</a></li>
                                                    <li><a href="#">Blog Mentions</a></li>
                                                    <li><a href="#">Domain Research</a></li>
                                                    <li><a href="#">Fan Pages</a></li>
                                                    <li><a href="#">Keywords Research</a></li>
                                                    <li><a href="#">SEO</a></li>
                                                </ul>
                                                <ul class="hidee" id="veiwlist5">
                                                    <li><h5><a href="#">Advertising</a></h5></li>
                                                    <li><a href="#">Hold Your Sign</a></li>
                                                    <li><a href="#">Flyers & Handouts</a></li>
                                                    <li><a href="#">Human Billboards</a></li>
                                                    <li><a href="#">Pet Models</a></li>
                                                    <li><a href="#">Outdoor Advertising</a></li>
                                                    <li><a href="#">Radio</a></li>
                                                </ul>
                                                <ul class="hidee" id="veiwlist6">
                                                    <li><h5><a href="#">Video & Animation</a></h5></li>
                                                    <li><a href="#">Commercials</a></li>
                                                    <li><a href="#">Editing & Post Production</a></li>
                                                    <li><a href="#">Animation & 3D</a></li>
                                                </ul>
                                    </div>
                                    
                                </div>
                                
                    
                </div>
            </div>
            <div class="wrap-search">
					<input id="query" maxlength="80" name="query" type="text" placeholder="SEARCH">
		            <input type="image" src="img/glass_small.png" alt="Go">
                  </div>
                <div class="clear"></div>  
           </div> 
        </nav>
        
        
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
    <!-- <article class="header_bg_para">
    	<img src="img/prod_img.png" width="1200" alt="">
    	
    </article> -->
    <div class="full_article_bg" style="top:140px;">
    	<div class="kork_desc">
        	  <div class="left_kork">
              	<ul class="bxslider">
 				 <!-- <li>
   					 <iframe src="http://player.vimeo.com/video/17914974" width="610" height="425" frameborder="0" 		webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  				</li> -->
  					<li><img src="korkImages/<?php echo $image; ?>" /></li>
                    <li><img src="korkImages/<?php echo $image; ?>" /></li>
				</ul>
              </div>
              <div class="right_kork">
              	<h3><?php echo $title;	?>
          
                
               </h3>
               <h4>
               	CREATED <span class="orange"><?php echo $daysPassed; ?> DAYS AGO</span><br>
				IN <span class="orange">CATEGORIES / SUB CATEGORIES</span>
               </h4>
               
              <p><?php echo $detail; ?></p>
              <a href="#" class="btn_signup">order now</a>	
              </div>                
        	<div class="clear"></div>
        </div>
        <div class="kork_option">
        	<ul>
            	<li>
                	<div class="first_dt">
                		<span>
                    		<img src="img/user_thumb_2.png" width="50" height="50" alt="">
                    	</span>
                        <h2>By <a href="#"><?php echo $username; ?></a></h2>
                        <p>FROM: Pakistan JOINED <?php echo $joinedAgo; ?> Days AGO</p>
                    </div>
                </li>
                <li>
                	<div class="second_dt">
                    	<p># OF Bids: <span>40</span></p>
                    </div>
                </li>
                <li>
                	<div class="third_dt">
                    	<p>Visitors : <span>68</span></p>
                    </div>
                </li>
                <li>
                	<div class="share_dt">
                    	<p>Share this</p>
                    </div>
                </li>
                <div class="clear"></div>
            </ul>
        </div>
    	<div class="clear"></div>
    </div>

    <?php include 'headers/menu-bottom-navigation.php' ?>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    
$('.bxslider').bxSlider({
  video: true,
  useCSS: false
});
  });
</script>

<script>
function getlist(x){
    $(".hidee").hide();
    $("#veiwlist"+x).show();
}
</script>
<script src="js/school-list.js"></script>

</body>
</html>
