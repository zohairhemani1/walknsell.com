<?php
session_start();
	include 'headers/_user-details.php';
	$username = $_GET['username'];
	
	/* getting user details */
	$stmt = $dbh->prepare("SELECT u.ID, u.username, u.profilePic, u.fname, u.lname, u.active, u.joinDate, u.description, c.name, c.city FROM users u INNER JOIN colleges c ON u.collegeID = c.id WHERE u.username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
	if($row = $stmt->fetch()){
		$userID = $row['ID'];
		$username = $row['username'];
		$profilePic = $row['profilePic'];
		$fullname = $row['fname'].' '.$row['lname'];
        $activeFlag = $row['active'];
		$joinDate = $row['joinDate'];
		$description = $row['description'];
		
		$college_name = $row['name'];
		$city = $row['city'];
	}else{
		header("Location: 404");
		exit();
	}
	
	/* getting korks details */
	$stmt = $dbh->prepare("SELECT k.id, k.title,k.publish, k.detail, k.price, k.image, k.status, k.expiryDate, kc.category, COUNT(i.korkID) as `bids` FROM korks k INNER JOIN kork_categories kc ON k.catID = kc.cat_id left outer join `inbox` i on k.id = i.korkID WHERE k.userID = :userID  GROUP BY k.id ORDER BY k.id DESC");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $allKorks = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	/*$now = time(); // or your date as well
    //$date = DateTime::createFromFormat("Y-m-d", $dateOfCreation);
    $joinDate = strtotime($joinDate);
    $datediff_user = $now - $joinDate;
    $joinedAgo = floor($datediff_user/(60*60*24));*/
	
	/** Number of Products **/
	$stmt = $dbh->prepare("SELECT count(id) FROM korks WHERE userID = :userID AND status > -1");
	$stmt->bindParam(':userID', $userID);
	$stmt->execute();
		
	$result = $stmt->fetchAll();
	$prod_num=$result[0][0];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php echo $username; ?> | WalknSell</title>
<link href="css/copied.css" media="all" rel="stylesheet" />
<link href="css/copied1.css" media="all" rel="stylesheet" />
<link href="css/copied2.css" media="all" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/jquery.bxslider.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<link href='css/font-open-sans.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/font-awesome.css" type='text/css'>
<style>
.modal-dialog {
	padding-top: 180px;
}
.modal-body {
	border-bottom: 0px;
}
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
vertical-align: top;
}
</style>
    
<?php
if(!empty($_SESSION['username'])){
    echo "<script>
        var sender = $_userID;
        var receiver = $userID;
        </script>";
}
?>

<script src="js/modern.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>




<script src="js/jquery.fitvids.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
</script>



<script>


var error;

$(document).ready(function(e) 
{
    
sendMessage();

	
});


function sendMessage()
{
    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#msgsend").on('click',function(event){
    // show loading bar until the json is recieved



    //alert(sender+receiver);

        request = $.ajax({
            url: "catlog_sendmsg.php",
            type: "post",
            data: {msg:$('#msg').val(),sender:sender,receiver:receiver}
        });

            // callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // log a message to the console
            $('.genload').css("padding-top", "0px");
            $('.genload').css("padding-bottom", "0px");
            if(response=="Message Sent!"){
                $('#shoading').html('<div class =\'alert alert-success\'><strong>Your message has been sent successfully! </strong>.');
            }else {
                $('#shoading').html('<div class=\'alert alert-danger\'>Sorry, There has been an error in our system!' + response+'</div>');
            }

            //window.location.href = "your-questions.html";
        });

        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console

            alert('Request Failed!');
            console.error(
                "The following error occured: "+
                textStatus, errorThrown
            );
        });

        // callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // reenable the inputs
        });
	});
	
}



</script>



<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="wrapper">
    <div class="header_bg">
      <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
        <?php include 'headers/menu-top-navigation.php';?>
      </header>
    </div>
      <?php
	if(isset($_SESSION['username']))
    {
    include 'headers/subhead.php'; 
    }
    
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
<!--/.header_bg-->
<!-- <article class="header_bg_para">

</article> -->
<?php include 'headers/popup.php';?>
<div class="main-content">
                    



                <div class="mp-box mp-hero-new hero-small mp-user-hero" itemscope="" itemtype="http://schema.org/Organization">

                    <div class="hero-slide sel" style="background-image: url('img/header_bg.jpg');">
                    </div>

	<div class="box-row hero-text">
		<h1>
			
			<span itemprop="name"><?php echo $username; ?></span>
				<small>
					<span class="js-user-one-liner"><?php echo $college_name; ?></span>
				</small>
		</h1>
		<div class="error-container js-user-one-liner-error"></div>
        <!--<div class="hero-rating js-hero-rating" data-user-rating="97" data-user-ratings-count="1175" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		<meta itemprop="reviewCount" content="1175">
		<meta itemprop="ratingValue" content="4.9">    
        <i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		1175 Reviews</div>-->
	</div>

                    <div class="hero-profile-image">
                        <div class="box-row cf">
                            <span class="user-data rf">Member since <?php echo date('F, Y', strtotime($joinDate))?></span>
                            <span class='user-pict-130'><img src="img/users/<?php echo $profilePic; ?>" class='user-pict-img' alt='umaisdesigns' itemprop='logo' width='130' height='130' data-reload='inprogress'></span>
                        </div>
                    </div>

                    <div class="box-row mp-hero-connector-slim noborder">&nbsp;</div>

                    <img alt="Bg hero small spacer" class="trans-img" src="//cdnil21.fiverrcdn.com/assets/v2_backgrounds/bg-hero-small-spacer-7c831c845101e6082cb60043c5c3be49.png">

                </div>

	<article class="mp-box mp-box-grey mp-user-info p-b-40">
		<div class="box-row bordered p-b-30">

                        <header>
                            <h2><?php echo $fullname; ?>
                                <span class="user-is-online js-user-is-online" data-user-id="umaisdesigns"><em></em>online</span>
                            </h2>
                            <div class="desc">
                                <textarea class="user-edit-desc js-edit-desc" maxlength="300" name="user-edit-desc" tabindex="2" rows="1" data-org="Expert in Graphics Designing, Photography, Photoshopping, Logo Designing, Business cards, Advertisements, Flyer, Booklet, Book Covers, Illustrations and Company Branding. " readonly style="overflow: hidden; word-wrap: break-word; height: 72px;"><?php echo ($description == NULL) ? "$fullname has no description." : $description; ?></textarea>
                            </div>
                        </header>

                        <ul class="user-stats cf">
                                <li class="icn-country">From: <em><?php echo $city; ?></em></li>
                            <li class="icn-speaks">
                                Number of Deals:
                                    <em><?php echo $prod_num; ?></em>
                            </li>
<!--
                            <li class="icn-response">Avg. Response Time: <em>1 Day</em></li>
                            <li class="icn-recent">Recent Delivery: <em>1 day ago</em></li>
-->
                            <li class="<?php echo ($activeFlag == 0) ? "icn-cross" : "icn-verified" ?>">Email Verified</li>
                            
                            
                        </ul>

                        <footer class="cf">
                                <?php
                                if(!empty($_SESSION['username'])){
                                    if($username == $_username){
                                        // echo '<a class="btn-standard btn-edit js-btn-edit-user" href="/'.$_username .'/edit" rel="nofollow"><i></i>Edit</a>';
                                        echo '<a class="btn-standard btn-green-grad btn-contact js-btn-user-contact js-gtm-event-auto" href="/'.$_username .'/edit" rel="nofollow"><i></i>Edit</a>';
                                    }
                                    else {
                                        echo "<a href='#' class='btn-standard btn-green-grad btn-contact js-btn-user-contact js-gtm-event-auto' data-toggle='modal' data-target='#message'><i></i>Contact</a>";
                                    }
                                }
                                    else if(empty($_SESSION['username'])){
                                    echo "<a href='#' class='btn-standard btn-green-grad btn-contact js-btn-user-contact js-gtm-event-auto' data-toggle='modal' data-target='#login'><i></i>Contact</a>";
                                                                        }
								?>
                        </footer>
        <?php
                if(!empty($allKorks)){
                    $kork_id = $allKorks[0]['id'];
                    $kork_title = $allKorks[0]['title'];
                    $kork_detail = $allKorks[0]['detail'];
                    $kork_price = nice_number($allKorks[0]['price']);
                    $kork_image = $allKorks[0]['image'];
                    $kork_status = $allKorks[0]['status'];
                    $kork_date = $allKorks[0]['expiryDate'];
                    $kork_bids = $allKorks[0]['bids'];
                    $kork_cat = $allKorks[0]['category'];
                    echo "<aside class='user-bundle js-user-bundle'>
                        <h4>$username's Best Seller</h4>
                        <a href='cate_desc.php?korkID=$kork_id' class='bundle-item js-gtm-event-auto' data-gtm-category='new-user-page' data-gtm-action='click' data-gtm-label='top-package-with-extras'>
                        <span class='bundle-badge'>$kork_cat</span>
                        <span class='gig-pict-290'><img src='img/korkImages/$kork_image' data-reload='inprogress'></span>
                        <h1 class='truncate'>$kork_title</h1>
                        <h3 class='details-block-ellipsis'>$kork_detail</h3>
                        <div class='bundle-sub cf'>
                            <span class='bundle-price'>RS. $kork_price</span>
                        </div></a>
                    </aside>";
                 
                }
                ?>
                    </div>
                </article>
		<?php
        if(!empty($allKorks)){
            echo "<div class='mp-box mp-box-grey'>
                    <div class='featured_prod'>
					<header style='width: 71%; margin: auto;'>
						<h2>$username's Deals</h2>
					</header>		
					<article  class='prod_detail' style='background:#eee;' col-lg-12'>
      	            <ul class='row' style='margin-left:0px;margin-right:0px;'>";
			foreach ($allKorks as $row){
			$kork_id = $row['id'];
			$kork_title = $row['title'];
			$kork_detail = $row['detail'];

			$kork_price = nice_number($row['price']);
			$kork_date = $row['expiryDate'];
			$kork_status = $row['status'];
            $kork_publish = $row['publish'];    
			$kork_image = $row['image'];
			$kork_category = $row['category'];
			$kork_bids = $row['bids'];
			if($kork_status == 0 || $kork_status == 1 && $kork_publish == 1){
				($kork_status == 0) ? $kork_status = "sold" : $kork_status = "available";

            echo "<li class='col-lg-3 col-md-6 col-sm-6' id='main_deals' style='width: 255px;'>
            <a href='$kork_user/{$title_withDashes}/{$kork_id}' id='gig_link'>                   
                    <div class='col-lg-12 single_product' style='width:234px;height: 260px;'>
                        <div class='img_wrap'>
                            <img src='img/korkImages/$kork_image' width='234' alt='' class='img-responsive'>
                        <h3 style='margin-top: 143px;position: absolute;' class='block-ellipsis'>$kork_title</h3>
                     ";
                echo "<p class='gig_avialable'>Available</p>";
              echo "   
                        </div>
              <div class='price'>
                            <span class='price_first'>Rs. $kork_price</span>
                            <span class='prod_scheme'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
                        </div>     
                   </div>
                </a></li>";


     //            echo "<li class='col-lg-3 col-md-6 col-sm-6'><a href='cate_desc.php?korkID=$kork_id'>
					// 	<div class='col-lg-12 single_product'>
					// 		<div class='img_wrap'>
					// 			<img src='img/korkImages/$kork_image' alt='' class='img-responsive'>
					// 		</div>
     //                        <h3 class='block-ellipsis'>$kork_title</h3>
					// 		<p class='prod_cat_22'>$kork_category Category</p>
					// 		<div class='price_tag_22'>
					// 			<span class='price_main'>Rs. $kork_price</span>
					// 			<span class='offer_dt'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
					// 		</div>
					//    </div>
					// </a></li>";
			}
			}
            echo "</ul>
                <div class='clear'></div>
                </article>
                </div></div>";
        }else if(!empty($_SESSION['username']) && $_username == $username){
            echo "<div id='contentSub' class='clearfix'>
              <div class='contentBox'>
                  <p class='fontelico-emo-unhappy noKorks'> You have no deals to sell.</p>
                  <p class='noKorksCreate'><a href='manage_deals/new' class='entypo-pencil'> Do you want to start selling today?</a></p>
              </div>
            </div>";
        }
		?>
    </div>
    <?php include 'headers/menu-bottom-navigation.php'; ?>
    <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            <h1 class="modal-title" id="myModalLabel">Contact Now</h1>
            <p>Please enter your message!</p>
          </div>
          <div class="modal-body">
            <form id="msg-form" method="post">
            <div id="shoading" class="genload"></div>
                <textarea id="msg" class="form-control txt_boxes" style="height: 54px;padding-top: 11px;font-size: 22px;resize:none;width:95%;" placeholder="Enter Your Message"></textarea>
              <div style="width: 0%;    margin-left: 31%;"><input type="button" id="msgsend" style="margin-left: 0px;margin-top: 26px;width: 169px;height: 42px;font-size: 22px;" class="btn_signup" value="send" />
              </div>
            </form>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<script src ="js/register.js"></script>
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




<script src="js/nav-admin-dropdown.js"></script>
<script src="js/school-list.js"></script>
</body>
</html>
