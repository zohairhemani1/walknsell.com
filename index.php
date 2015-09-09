<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
session_start();
if(isset($_GET['status']) && $_GET['status'] == 'logout')
	{
        unset($_SESSION);
        session_unset();
        session_destroy();
        if (isset($_COOKIE['walknsell_remember'])) {
            unset($_COOKIE['walknsell_remember']);
            setcookie('walknsell_remember', '', time() - 3600, '/'); // empty value and old timestamp
        }
	}
if(isset($_SESSION['username']) && isset($_GET['password'])){
    header('Location: index.php');
}
include 'headers/_user-details.php';
if(isset($_SESSION['username']) && isset($_GET['activate'])){
    header('Location: index.php');
}
include 'headers/_user-details.php';
	
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::WalknSell::</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel='shortcut icon' href='img/icon.ico' />
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<link href='css/font-open-sans.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/font-awesome.css" type='text/css'>
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
	if(isset($_GET['password']))
	{
			echo "<div class='main-flashes'>
                            <div style='height: 49px;padding-top: 0px;background-color:#ff9326' class='flash-message flash-success'>
                                <p>Success! Your password has been changed successfully.</p>
                            </div>
                </div>";
		}
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

    <?php include 'headers/popup.php';?>
  
  
  <article class="content">
    <div class="content_inner">
      <form method="post"  id="search" name="search">
        <label for="search">Find Your School</label>
        <div id="tfheader">
          <input type="text" class="tftextinput" name="search_text" id="search" placeholder="" onKeyUp="findmatch();" autocomplete="off" >
            <input type="hidden" value="" id="search_url" />  
        <ul id ="results" name="school">
            </ul>
            <input value="Search" type="button" class="tfbutton">
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
		$sth = $dbh->query("Select id, title, detail, price, expirydate, status, image, bids, username, category from (Select k.id, k.title, k.detail, k.price, k.expirydate, k.status, k.image, count(i.korkID) bids, u.username, kc.category, k.catID FROM inbox i INNER JOIN korks k ON i.korkID = k.id INNER JOIN users u ON k.userID = u.ID INNER JOIN kork_categories kc ON k.catID = kc.cat_id GROUP BY i.korkID order by bids DESC) b where status = 1 GROUP BY catID LIMIT 4");
        $topresults = $sth->fetchAll(PDO::FETCH_ASSOC);
        /*$numRes = count($topresults);
        if($numRes == 0){
            $sth = $dbh->query("Select k.id, k.title, k.detail, k.price, k.expirydate, k.status, k.image, count(i.korkID) bids, u.username, kc.category, k.catID FROM inbox i INNER JOIN korks k ON i.korkID = k.id INNER JOIN users u ON k.userID = u.ID INNER JOIN kork_categories kc ON k.catID = kc.cat_id GROUP BY i.korkID order by k.expirydate DESC LIMIT 4");
            $topresults = $sth->fetchAll(PDO::FETCH_ASSOC);
        }else if($numRes < 4){
            $sth = $dbh->query("Select k.id, k.title, k.detail, k.price, k.expirydate, k.status, k.image, count(i.korkID) bids, u.username, kc.category, k.catID FROM inbox i INNER JOIN korks k ON i.korkID = k.id INNER JOIN users u ON k.userID = u.ID INNER JOIN kork_categories kc ON k.catID = kc.cat_id GROUP BY i.korkID order by bids DESC LIMIT 4");
            $restresults = $sth->fetchAll(PDO::FETCH_ASSOC);
            //$topresults = array_unique(array_merge($topresults, $restresults));
            for($j=0; $j<count($restresults); $j++){
                if($numRes == 4){
                    break;
                }
                if($topresults[$j]['id'] !== $restresults[$j]['id']){
                    echo $topresults[$j]['id'] . " " .$restresults[$j]['id'];
                    $topresults[] = $restresults[$j];
                    $numRes++;
                }
            }
        }*/
        foreach ($topresults as $row){
            $kork_id = $row['id'];
            $kork_title = $row['title'];
            $kork_detail = $row['detail'];
            $kork_price = nice_number($row['price']);
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
                            <img src='img/korkImages/$kork_image' width='234' alt='' class='img-responsive'>
                        </div>
                        <h3 class='block-ellipsis'>$kork_title</h3>
                        <p class='prod_cat_22'>$kork_category Category</p>
                        <p class='prod_cat_22'>By $kork_user</p>
                        <p class='attributes'>".date('m-d-Y | h:i A', strtotime($kork_date))."</p>
                        <div class='price_tag_22'>
                            <span class='price_main'>Rs. $kork_price</span>
                            <span class='offer_dt'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
                        </div>
                   </div>
                </a></li>";
        }
		$dbh = null;
		?>
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
<script src="js/school-list.js"></script>
<script src="js/nav-admin-dropdown.js"></script>
</body>
</html>
