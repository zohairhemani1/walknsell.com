<?php
session_start();
include 'headers/_user-details.php';
	if(isset($_SESSION['username'])){
        header('Location: index.php');  
    }
?>
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
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
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
	<div id='contentSub' class='clearfix'>
	  <div class='contentBox'>
		  <p class='fontelico-emo-happy noKorks'> Welcome to WalknSell</p>
		  <p class='noKorksCreate'>Are you looking to buy or sell something at WalknSell?</p>
		  <p class='noKorksCreate'><a  href="#" data-toggle="modal" data-target="#register" class='entypo-pencil'> To start selling within your school or university, sign up for WalknSell today!</a></p>
	  </div>
	</div>
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