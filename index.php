<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
session_start();
if(isset($_GET['status']) && $_GET['status'] == 'logout')
	{	
	
	unset($_SESSION);
    session_unset();
    session_destroy();
	}

include 'headers/_user-details.php';
	
?>
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
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/fb.js"></script>
</head>

<body>
<?php
	if(isset($_GET['activate']))
	{
		include 'headers/connect_database.php';
		$activationKey = $_GET['activate'];
		
		if($dbh->exec("UPDATE users SET active = '1' WHERE activationKey = '$activationKey'"))
		{
			echo "<div class='main-flashes'>
                            <div class='flash-message flash-success'>
                                <p>Your account is activated.</p>
                            </div>
                </div>";
		}
		else
		{
			echo "<div class='main-flashes'>
                            <div class='flash-message flash-warning'>
                                <p>Uh-oh! We are sorry but something did not go well with your activation.<br>To fix, please contact our <a href='#'>support.</a></p>
                            </div>
                </div>";
		}	
	}
?>
<div class="wrapper">
  <div class="header_bg">
    <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
      <?php
           include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->

    <?php
           include 'headers/popup.php';?>
  
  
  <article class="content">
    <div class="content_inner">
      <form method="get" action="#" id="search" name="search">
        <label for="search">Find Your School</label>
        <div id="tfheader">
          <input type="text" class="tftextinput" name="search_text" size="" id="search" placeholder="" onKeyUp="findmatch();" autocomplete="off" >
          <ul id ="results" name="school">
          </ul>
          <input type="submit" value="Search" class="tfbutton">
          <div class="clear"></div>
        </div>
      </form>
    </div>
    <div class="clear"></div>
  </article>
  <div class="full_article_bg featured_prod">
    <article  class="prod_detail col-lg-12">
      	<ul class="row">
		<?php
		/*$sql = "Select a.id, a.title, a.detail, a.price, a.expirydate, a.status, a.image, COUNT(b.korkID), u.username, kc.category from korks a INNER JOIN inbox b ON a.id = b.korkID INNER JOIN kork_categories kc ON a.catID = kc.cat_id INNER JOIN users u ON a.userID = u.ID where b.bid IN (select max(i.bid) from inbox i, korks k where k.id = i.korkID GROUP BY k.catID) LIMIT 4";*/
		
		/*$sql = "Select catID, korkID, bids from (Select k.catID, i.korkID, count(i.korkID) bids FROM inbox i INNER JOIN korks k ON i.korkID = k.id GROUP BY i.korkID order by bids DESC) tabs GROUP BY catID";*/
		$sql = "Select id, title, detail, price, expirydate, status, image, bids, username, category from (Select k.id, k.title, k.detail, k.price, k.expirydate, k.status, k.image, count(i.korkID) bids, u.username, kc.category, k.catID FROM inbox i INNER JOIN korks k ON i.korkID = k.id INNER JOIN users u ON k.userID = u.ID INNER JOIN kork_categories kc ON k.catID = kc.cat_id GROUP BY i.korkID order by bids DESC) b GROUP BY catID";
		
		foreach ($dbh->query($sql) as $row){
			$kork_id = $row['id'];
			$kork_title = $row['title'];
			$kork_detail = $row['detail'];
			$kork_price = $row['price'];
			$kork_date = $row['expirydate'];
			$kork_status = $row['status'];
			$kork_image = $row['image'];
			$kork_category = $row['category'];
			$kork_user = $row['username'];
			$kork_bids = $row['bids'];
			
			echo "<li class='col-lg-3 col-md-6 col-sm-6'><a href='cate_desc.php?korkID=$kork_id'>
					<span class='available korkbadge'></span>
					<div class='col-lg-12 single_product'>
						<div class='img_wrap'>
							<img src='img/korkImages/$kork_image' width='134' alt='' class='img-responsive'>
						</div>
						<h3>$kork_title</h3>
						<p class='prod_cat_22'>$kork_category Category</p>
						<p class='prod_cat_22'>By $kork_user</p>
						<p class='attributes'>2014-05-24  | 05:26:51  | 12:03 PM</p>
						<div class='price_tag_22'>
							<span class='price_main'>$$kork_price</span>
							<span class='offer_dt'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
						</div>
				   </div>
				</a></li>";
		}
		$dbh = null;
		?>
        	<!--<li class="col-lg-3 col-md-6 col-sm-6">
            	<span class="featured_tag"></span>
            	<div class="col-lg-12 single_product">
                	<div class="img_wrap">
                		<img src="img/mobile_img.png" width="134" alt="" class="img-responsive">
                	</div>
                    <h3>Android Cell Phone</h3>
                    <p class="prod_desc_22">I want to sell my android phone</p>
                    <p class="attributes">2014-05-24  | 05:26:51  | 12:03 PM</p>
                    <div class="price_tag_22">
                    	<span class="price_main">$200</span>
                        <span class="offer_dt">10% OFF</span>
                    </div>
               </div>
            </li>
            <li class="col-lg-3 col-md-6 col-sm-6">
            <span class="featured_tag"></span>
            	<div class="col-lg-12 single_product">
                	<div class="img_wrap">
                		<img src="img/mobile_img.png" width="134" alt="" class="img-responsive">
                	</div>
                    <h3>Android Cell Phone</h3>
                    <p class="prod_desc_22">I want to sell my android phone</p>
                    <p class="attributes">2014-05-24  | 05:26:51  | 12:03 PM</p>
                    <div class="price_tag_22">
                    	<span class="price_main">$200</span>
                        <span class="offer_dt">10% OFF</span>
                    </div>
               </div>
            </li>
            <li class="col-lg-3 col-md-6 col-sm-6">
            <span class="featured_tag"></span>
            	<div class="col-lg-12 single_product">
                	<div class="img_wrap">
                		<img src="img/mobile_img.png" width="134" alt="" class="img-responsive">
                	</div>
                    <h3>Android Cell Phone</h3>
                    <p class="prod_desc_22">I want to sell my android phone</p>
                    <p class="attributes">2014-05-24  | 05:26:51  | 12:03 PM</p>
                    <div class="price_tag_22">
                    	<span class="price_main">$200</span>
                        <span class="offer_dt">10% OFF</span>
                    </div>
               </div>
            </li>
            <li class="col-lg-3 col-md-6 col-sm-6">
            <span class="featured_tag"></span>
            	<div class="col-lg-12 single_product">
                	<div class="img_wrap">
                		<img src="img/mobile_img.png" width="134" alt="" class="img-responsive">
                	</div>
                    <h3>Android Cell Phone</h3>
                    <p class="prod_desc_22">I want to sell my android phone</p>
                    <p class="attributes">2014-05-24  | 05:26:51  | 12:03 PM</p>
                    <div class="price_tag_22">
                    	<span class="price_main">$200</span>
                        <span class="offer_dt">10% OFF</span>
                    </div>
               </div>
            </li>-->
		</ul>
        <div class="clear"></div>
    </article>
    <div class="clear"></div>
  </div>
  <article class="lower_content">
    <div class="lower_content_inner">
      <div class="detail"> 
        
        <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">

</fb:login-button> -->
        
        <h2>What is WalknSell?</h2>
        <p>WalknSell is a social website that helps students and teachers
          
          like you post classifieds related to your school or university. </p>
        <p>We take multiple security measures to ensure that only legitimate
          
          classifieds are shown and spam is minimized. </p>
        <p>WalknSell is safe and simple.</p>
      </div>
      <div class="how_it_works">
        <h2>How it Works</h2>
        <ul>
          <li class="register"> <img src="img/register.png" width="58" alt="">
            <p>Register an account</p>
            </figcaption>
          </li>
          <li class="post_classified"> <img src="img/post_classified.png" width="65" alt="">
            <p>Post a classified<br>
              related to your school</p>
          </li>
          <li class="messege"> <img src="img/messege.png" width="80" alt="">
            <p>Interested students or teachers will contact you via email.</p>
          </li>
          <li class="enjoy"> <img src="img/enjoy.png" width="52" alt="">
            <p>Enjoy Life</p>
          </li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
  </article>
  <?php include 'headers/menu-bottom-navigation.php' ?>
  </div>
<script src ="js/register.js"></script> 
<script type="text/javascript">

$(document).ready(function() {

  $('#simple-menu').sidr();

});

</script> 
<script src="js/nav-admin-dropdown.js"></script>
<script src="js/school-list.js"></script>
</body>
</html>
