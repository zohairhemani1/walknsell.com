<?php
session_start();
include 'headers/_user-details.php';
	$school_hypens = $_GET['schoolName'];
	$school = str_replace('-', ' ', $school_hypens);
	$school_id = $_GET['schoolID'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::WalknSell::</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<script src="js/modern.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
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
	$('.full_article_bg').css('top',(0-(scrollposition * 0.5))+'px');
	}
</script>




<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="container">
	<div class="header_bg static_top">
        <header>
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>

       
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
    <article class="header_bg_para">
    	<div class="banner_static">
        	<div class="left_alpha">
            <h2>Over 2 Thousand Services</h2>
        	<p>WalknSell is a social website that helps students and teachers like you post classifieds related to your school or university.</p>
            </div>
            <div class="right_link"><a href="#"></a></div>
            <div class="clear"></div>
        </div>
    	
    </article>
    
    <div class="full_article_bg">
    <article  class="prod_detail">
    
    
    
    <?php
		
							include 'headers/connect_database.php';
							
							
						try {
					

							/*** The SQL SELECT statement ***/
							$sql = "SELECT k.id, k.title, k.userID, k.detail, k.image, k.expirydate, u.ID,u.collegeID FROM `korks` k, `users` u WHERE u.ID = k.userID AND u.collegeID = $school_id";
							
							$find = $dbh->prepare('SELECT count(*) from korks');
							$find->execute();	
			
							if($find->fetchColumn() <= 0){
								echo "No Listings Found <br/ >";	
				
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
									echo "<div class='prod_desc'>";
        							echo "<span class='featured_bedge'>featured</span>";
        							echo "<img class='main-prod-pic' src='korkImages/$image' width='247' alt=''>";
            						echo "<div class='details'>";
            						echo "<a href='cate_desc.php?korkID={$id}'><h3 style='font-weight:bold;height:2.5em;overflow:hidden;'>$title</h3></a><br/>";
									echo "<a href='cate_desc.php?korkID={$id}'><div class='kork_text_wrap'><h3> $detail </h3></div></a>";
									
									
                    				echo"<p><span> $expiryDate <span> | <span>12:03 PM<span></p>
                    	 <div class='price'><span class='price_first'>$200</span><span class='prod_scheme'>10% <span class='off'>OFF																	</span></span></div>
                    
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
