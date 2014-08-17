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

<script>

var _userID;
var _fname;
var _lname;
var _email;
var _profilePic;


 // This is called with the results from from FB.getLoginStatus().

  function statusChangeCallback(response) {

    console.log('statusChangeCallback');

    console.log(response);

    // The response object is returned with a status field that lets the

    // app know the current login status of the person.

    // Full docs on the response object can be found in the documentation

    // for FB.getLoginStatus().

    if (response.status === 'connected') {

      // Logged into your app and Facebook.

      testAPI();

    } else if (response.status === 'not_authorized') {

      // The person is logged into Facebook, but not your app.

     // document.getElementById('status').innerHTML = 'Please log ' +

       // 'into this app.';

    } else {

      // The person is not logged into Facebook, so we're not sure if

      // they are logged into this app or not.

      //document.getElementById('status').innerHTML = 'Please log ' +

        //'into Facebook.';

    }

  }



  // This function is called when someone finishes with the Login

  // Button.  See the onlogin handler attached to it in the sample

  // code below.

  function checkLoginState() {

    FB.getLoginStatus(function(response) {

      statusChangeCallback(response);

    });

  }



  window.fbAsyncInit = function() {

  FB.init({

    appId      : '1422834004652463',

    cookie     : true,  // enable cookies to allow the server to access 

     status     : true,                   // the session
	channelUrl : '//WWW.walknsell.COM/channel.html',

    xfbml      : true,  // parse social plugins on this page

    version    : 'v2.0' // use version 2.0

  });



  // Now that we've initialized the JavaScript SDK, we call 

  // FB.getLoginStatus().  This function gets the state of the

  // person visiting this page and can return one of three states to

  // the callback you provide.  They can be:

  //

  // 1. Logged into your app ('connected')

  // 2. Logged into Facebook, but not your app ('not_authorized')

  // 3. Not logged into Facebook and can't tell if they are logged into

  //    your app or not.

  //

  // These three cases are handled in the callback function.



  FB.getLoginStatus(function(response) {

    statusChangeCallback(response);

  });



  };



  // Load the SDK asynchronously

(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));



  // Here we run a very simple test of the Graph API after login is

  // successful.  See statusChangeCallback() for when this call is made.

  function testAPI() {

    console.log('Welcome!  Fetching your information.... ');

    FB.api('/me', function(response) {

      console.log('Successful login for: ' + response.name+response.email+response.id);

      //document.getElementById('status').innerHTML =

        //'Thanks for logging in, ' + response.name + '!';
		
		
	_userID=response.id;
	_fname=response.first_name;
	_lname=response.last_name;
	_email=response.email;
	_profilePic="http://graph.facebook.com/" + response.id + "/picture";
	

    });

  }

</script>

</head>



<body>

<div class="wrapper">

	<div class="header_bg">

        <header>

        <a id="simple-menu" class="icon-menu" href="#sidr"></a>



       

           <?php
           include 'headers/menu-top-navigation.php';?>

        </header>

        <div class="clear"></div>

    </div><!--/.header_bg-->
<div id="backgroundPopup"></div>
    

    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

              <div class="modal-dialog">

                <div class="modal-content">

                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>

                    <h1 class="modal-title" id="myModalLabel">WalknSell Login</h1>

                    <p>Please Enter valid Id and password for Signin!</p>

                  </div>

                  <div class="modal-body">

              		<form id="login-form" method="post">

                    <div id="error-login"></div>

                    	<input type="text" class="form-control txt_boxes" placeholder="Username" name="username-login" id="username-login" required>
                        <input type="password" class="form-control txt_boxes" placeholder="Password" name="password-login" id="password-login" required>

						<div id="loading-login"></div>

                        <input type="submit" class="btn_signup" value="login"/>

                        <div class="forg_pass">

                        	<input type="checkbox" name="remember" class="">

                            <p><a href="#">REMEMBER ME</a> / <a href="#">FORGET PASSWORD</a> ?</p>

                            <div class="clearfix"></div>

                        </div>

                    </form>

                     <div class="clearfix"></div>

                  </div>

                  <div class="modal-footer">

                  	<a href="#"><img src="img/join_via_fb.png" width="251" alt="join using facebook" id="login_fb"></a>
                    
						<script>
									(function ($) {
									$(function () {
										$("#login_fb").on("click", function () {
											FB.login(function(response) {
												if (response.authResponse) {
													//_wdfb_notifyAndRedirect();
													LoginFormFB(_userID);
												}
											});
										});
									});
									})(jQuery);
    					</script>

                    <p>IF PROBLEM SIGNING IN THEN <a href="#">CLICK HERE »</a></p>

                  </div>

                </div>

               

              </div>

</div>

    

    

    

    

    

    

    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

              <div class="modal-dialog">

                <div class="modal-content">

                  <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>

                    <h1 class="modal-title" id="myModalLabel">User Registration Form</h1>

                    <p>Register here to become a member of our website</p>

                  </div>

                  <div class="modal-body">

              		<form id="signup" method="post">

                    

                    <div id="error"></div>

                    

                    	<input type="text" class="form-control txt_boxes" placeholder="First Name" name="firstName" id="firstName" required>

                        <input type="text" class="form-control txt_boxes" placeholder="Last Name" name="lastName" id="lastName" required>

                        <input type="email" class="form-control txt_boxes" placeholder="Email Address" name="email" id="email" required>

                        	<input type="text" class="form-control txt_boxes" name="regcollege" placeholder="School" size="" id="regsearch" onKeyUp="regfindmatch();" autocomplete="off" required>

                     <ul id ="regresults" name="school" >

                    </ul>

                <div class="regclear"></div>

                        <input type="text" class="form-control txt_boxes" placeholder="Create your Username" name="username" id="username" required>

                        <input type="password" class="form-control txt_boxes" placeholder="Create a Password" name="password" id="password" required>

                        <input type="password" class="form-control txt_boxes" placeholder="Confirm Password" name="verifyPassword" id="verifyPassword" required>

                      

                        <center>

                        <div id="loading"></div>

                        <input type="submit" class="btn_signup" value="submit" />

                        <p class="terms">By signing up, I agree to WalknSell <a href="#" class="terms_link">terms of service.</a></p>
</center>
                    </form>

                     <div class="clearfix"></div>

                  </div>

                  <div class="modal-footer">

                  	<a href="#"><img src="img/join_via_fb.png" width="251" alt="join using facebook" id="register_fb"></a>
                    
                    <script>
									(function ($) {
									$(function () {
										$("#register_fb").on("click", function () 
										{
											FB.login(function(response) {
												if (response.authResponse) {
													//_wdfb_notifyAndRedirect();
													signupFormFB(_userID,_fname,_lname,_email,_profilePic);
												}
											});
										});
									});
									})(jQuery);
    					</script>

                    <p>ALREADY A MEMBER? <a href="#">SIGN IN »</a></p>

                  </div>

                </div>

               

              </div>

</div>

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



<div class="full_article_bg">
    <article  class="prod_detail">
    
    
    
    <?php
		
						try {
					include 'headers/connect_database.php';

							/*** The SQL SELECT statement ***/
							$sql = "SELECT k.id, k.title, k.userID, k.detail, k.image, k.expirydate, u.ID,u.collegeID FROM `korks` k, `users` u LIMIT 4";
							
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



    <article class="lower_content">

    	<div class="lower_content_inner">

            	<div class="detail">

                

                

                <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">

</fb:login-button> -->



             

                

                	<h2>What is WalknSell?</h2>

                    <p>WalknSell is a social website that helps students and teachers

                     like you post classifieds related to your school or university.

                     </p>

                     <p>We take multiple security measures to ensure that only legitimate

                      classifieds are shown and spam is minimized.

                      </p>

                      <p>WalknSell is safe and simple.</p>

                </div>

                <div class="how_it_works">

                	<h2>How it Works</h2>

                    <ul>

                    	<li class="register">

                        	<img src="img/register.png" width="58" alt="">

                            <p>Register an account</p></figcaption>

                        </li>

                        <li class="post_classified">

                        	<img src="img/post_classified.png" width="65" alt="">

                       		<p>Post a classified<br>related to your school</p>

                         </li>

                        <li class="messege">

                        	<img src="img/messege.png" width="80" alt="">

                            <p>Interested students or teachers will contact you via email.</p>

                        </li>

                        <li class="enjoy">

                        	<img src="img/enjoy.png" width="52" alt="">

                            <p>Enjoy Life</p>

                        </li>

                    </ul>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>

            </div>

    </article>

    

    <footer>

    	<div class="footer_inner">

        	<div class="social">

            	<h4>Lets Connect</h4>

                <ul>

                	<li><a class="twitter" href="#">twitter</a></li>

                    <li><a class="fb" href="#">facebook</a></li>

                    <li><a class="pin" href="#">pinterest</a></li>

                    <li><a class="linkedin" href="#">linkedin</a></li>

                    <li><a class="insta" href="#">instagram</a></li>

                </ul>

                <div class="clear"></div>

            </div>

            <div class="footer_nav">

            	<h4>General</h4>

                <ul>

                	<li class="f_home"><a href="#">Home</a></li>

                    <li class="f_sign"><a href="#">Sign in</a></li>

                    <li class="f_support"><a href="#">Support</a></li>

                </ul>    

                <ul class="second">    

                 	<li class="f_start"><a href="#">Start selling</a></li>

                    <li class="f_join"><a href="#">Join</a></li>

                    <li class="f_contact"><a href="#">Contact us</a></li>

                    

                </ul>

                <div class="clear"></div>

            </div>

            <div class="copyright">

            	<h4 class="f_logo">WalknSell</h4>

                	<p>Copyright 2013 WalknSell.</p>

					<p>All Rights Reserved</p> 

            </div>

            <div class="clear"></div>

        </div>

    </footer>

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

