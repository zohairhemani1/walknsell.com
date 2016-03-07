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
<link rel="icon" type="image/png" href="img/icon.png" />  
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
<?php
if(isset($_COOKIE['video'])){
  // echo "cookie saved";
}
else{
echo"
   <script type='text/javascript'>
$(document).ready(function(e){

    $('#video').modal('show');
    document.getElementById('playerid').src='https://www.youtube.com/embed/kttOM-GurEU?autoplay=1';
});
    </script>
";
    setcookie('video', md5(rand()*1000000000), time()+3600 * 24 * 365, '/');
}
    ?>

<script type='text/javascript'>
$(document).ready(function(e){
    $('#video').on('hidden.bs.modal', function (e) {
    document.getElementById('playerid').src='';
    });
$('#demo').click(function(){
    $('#video').modal('show');
    document.getElementById('playerid').src='https://www.youtube.com/embed/kttOM-GurEU?autoplay=1';
});
});

</script>
<script>
$(document).ready(function() {
$('#mydeals').carousel({
  interval: 2500
});

$('.carousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  for (var i=0;i<2;i++) {
    next=next.next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    
    // next.children(':first-child').clone().appendTo($(this));
  }
});
});
    </script>
</head>

<body>
<!-- <a  href='#' onclick='return closeMenu();' data-toggle='modal' data-target='#video'>LOGIN</a> -->
<?php
	if(isset($_GET['password']))
	{
			echo "<div class='main-flashes'>
                            <div style='height: 49px;padding-top: 0px;background-color:#ff9326' class='flash-message flash-success'>
                                <p>Success! Your password has been changed successfully.</p>
                            </div>
                </div>";
		}
	if(isset($_GET['login']) == 'false')
	{
			echo "<div class='main-flashes'>
                            <div style='height: 49px;padding-top: 0px;background-color:#ff9326' class='flash-message flash-warning'>
                                <p>Warning! You must be logged in before creating a deal &nbsp;
								 <a href='#' data-toggle='modal' style='text-decoration:underline !important;' data-target='#login'>Click here to login</a></p>
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
                                <p>Uh-oh! We are sorry but something did not go well with your activation.<br>To fix, please contact our <a href='#'>support.                               </a></p>
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
      <form method="post"  id="searchSchool" name="search">
        <label for="search">Find Your School</label>
        <div id="tfheader">
          <input type="text" class="tftextinput" name="search_text" id="search" placeholder="" autocomplete="off" >
            <input type="hidden" value="" id="search_url" />  
        <ul id ="results" name="school">
            </ul>
            <input value="Search" id="school" onclick="schoolfield();" type="button" class="tfbutton">
          <div class="clear"></div>
        </div>
      </form>
    </div>
    <div class="clear"></div>
  </article>
  <div class="full_article_bg featured_prod">
                <article  class="prod_detail col-lg-12">
<!--               <h2 class="deal_type">Favourite Deals</h2> -->
                <ul class="row">
<div class="carousel slide" id="mydeals">
  <div class="carousel-inner">
		<?php
		$sth = $dbh->query("Select id, title, detail, price, expirydate, status, image, bids, username, category from (Select k.id, k.title, k.detail, k.price, k.expirydate, k.status, k.image, count(i.korkID) bids, u.username, kc.category, k.catID FROM inbox i RIGHT OUTER JOIN korks k ON i.korkID = k.id INNER JOIN users u ON k.userID = u.ID INNER JOIN kork_categories kc ON k.catID = kc.cat_id GROUP BY k.id order by bids DESC) b where status = 1 GROUP BY catID LIMIT 4");
        $topresults = $sth->fetchAll(PDO::FETCH_ASSOC);
        $count = 0;
        foreach ($topresults as $row){
            $kork_id = $row['id'];
            $kork_title = $row['title'];
            $title_withDashes = str_replace(' ', '-', $kork_title);
            $kork_detail = $row['detail'];
            $kork_price = nice_number($row['price']);
            $kork_date = $row['expirydate'];
            $kork_status = $row['status'];
            $kork_image = $row['image'];
            $kork_category = $row['category'];
            $kork_user = $row['username'];
            $kork_bids = $row['bids'];
            ++$count;
            if($count == 1){echo "<div class='item active'>";}
            else{echo "<div class='item'>";}
            echo "
            <li class='col-lg-3 col-md-6 col-sm-6'>
            <a href='$kork_user/{$title_withDashes}/{$kork_id}' id='gig_link'>
                   
                    <div class='col-lg-12 single_product' style='width: 234px;;height: 260px;'>
                        <p style='position:absolute;top: 4px;padding-top: 6px;font-size: 12px;' class='prod_cat_22'><b>By:</b> $kork_user</p>
                        <div class='img_wrap'>
                            <img src='img/korkImages/$kork_image' width='234' alt='' class='img-responsive'>
                        <h3 style='margin-top: 143px;position: absolute;' class='block-ellipsis'>$kork_title</h3>
                     ";
            if($kork_status == 1){
                echo "<p class='gig_avialable'>Available</p>";
              }          
              echo "   
                  </div>
              <div class='price'>
                            <span class='price_first'>Rs. $kork_price</span>
                            <span class='prod_scheme'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
                        </div>     
                   </div>
                </a></li></div>";
          }
      
          // remove after li 
         // <span class='available korkbadge'></span>
        // <p class='prod_cat_22'>$kork_category Category</p>
        // <p class='attributes'>".date('m-d-Y | h:i A', strtotime($kork_date))."</p>
              // <div class='price_tag_22'>
              //               <span class='price_main'></span>
              //               <span class='offer_dt'></span>
              //           </div>
		$dbh = null;
		?>
  </div>
  <a class="left carousel-control" href="#mydeals" data-slide="prev"><i id='arrow' class="fa fa-chevron-left"></i></a>
  <a class="right carousel-control" href="#mydeals" data-slide="next"><i id='arrow' class="fa fa-chevron-right"></i></a>
</div>
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
        <p>WalknSell is safe and simple. <a href='#' id="demo">Watch demo</a></p>
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

  </div>
</div>
    <?php include 'headers/menu-bottom-navigation.php' ?>
  
    <script src ="js/register.js"></script>
<script type="text/javascript">

$(document).ready(function() {

  $('#simple-menu').sidr();
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
    <script>
        function schoolfield(){
            if($('#search_url').val() == '' || $('#search_url').val() == null){
                e.preventDefault();
                return false;
            }
        }
        
    </script>

<script type="text/javascript">
$('#regsearch').keyup(function(e)
{
    var $listItems = $('#regresults li');

    var key = e.keyCode,
        $selected = $listItems.filter('.selected'),
        $current;

    if ( key != 40 && key != 38 ) return;

    $listItems.removeClass('selected');

    if ( key == 40 ) // Down key
    {
        if ( ! $selected.length || $selected.is(':last-child') ) {
            $current = $listItems.eq(0);
        }
        else {
            $current = $selected.next();
        }
    }
    else if ( key == 38 ) // Up key
    {
        if ( ! $selected.length || $selected.is(':first-child') ) {
            $current = $listItems.last();
        }
        else {
            $current = $selected.prev();
        }
    }
          $current.addClass('selected');
        $('#regsearch').val($('.selected').text());

        if(key == 13){
        if($('#regsearch').val() != null || $('#regsearch').val() != ''){
              $("#regresults").css("display", "block");
        }

      }
});
</script>

    <script type="text/javascript">

$('#search').keyup(function(e)
{

var $listItems = $('#results li');

var key = e.keyCode,
        $selected = $listItems.filter('.selected'),
        $current;

    if ( key != 40 && key != 38 ) return;

    $listItems.removeClass('selected');



    if ( key == 40 ) // Down key
    {
        if ( ! $selected.length || $selected.is(':last-child') ) {
            $current = $listItems.eq(0);
        }
        else {
            $current = $selected.next();
        }
    }
    else if ( key == 38 ) // Up key
    {
        if ( ! $selected.length || $selected.is(':first-child') ) {
            $current = $listItems.last();
        }
        else {
            $current = $selected.prev();
        }
    }

    $current.addClass('selected');
        $('.tftextinput').val($('.selected').text());
        $('#search_url').val($('.selected').attr('id'));

});
    </script>
<script src="js/school-list.js"></script>
<script src="js/nav-admin-dropdown.js"></script>
</body>
</html>
