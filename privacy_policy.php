<?php
session_start();
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
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/modern.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/nav-admin-dropdown.js"></script>
<script src="js/fb.js"></script>
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

</head>

<body id="policy">
<div>
	<div class="header_bg ">
        <header>
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>

       
            <?php include 'headers/menu-top-navigation.php';?>
        </header>
       <nav class="category_nav main-category-search">
        	<div class="category_inner">
            	<h1>Privacy Policy</h1>

                <div class="clear"></div>  
           </div> 
        </nav>
        
        
        <div class="clear"></div>
       
    </div><!--/.header_bg-->
	<?php
           include 'headers/popup.php';?>
    <article class="privacy">
    	
        <div id="contentSub" class="clearfix">
			<div class="contentBox">
				<p>This Privacy Policy governs the manner in which WalknSell collects, uses, maintains and discloses information collected from users (each, a "User") of the www.WalknSell.com website ("Site"). This privacy policy applies to the Site and all products and services offered by WalknSell.</p>

				<h3>Personal identification information</h3>

				<p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p>

				<h3>Non-personal identification information</h3>

				<p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>

				<h3>Web browser cookies</h3>

				<p>Our Site may use "cookies" to enhance User experience. User's web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p>

				<h3>How we use collected information</h3>

				<p>WalknSell may collect and use Users personal information for the following purposes:</p>
				
				<ul class="listNormal">
					<li><strong>To improve customer service</strong><br>
					Information you provide helps us respond to your customer service requests and support needs more efficiently.</li>
					<li><strong>To personalize user experience</strong><br>
					We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</li>
					<li><strong>To improve our Site</strong><br>
					We may use feedback you provide to improve our products and services.</li>
					<li><strong>To run a promotion, contest, survey or other Site feature</strong><br>
					To send Users information they agreed to receive about topics we think will be of interest to them.</li>
					<li><strong>To send periodic emails</strong><br>
					We may use the email address to respond to their inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</li>
				</ul>	

				<h3>How we protect your information</h3>

				<p>We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.</p>

				<h3>Sharing your personal information</h3>

				<p>We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.We may use third party service providers to help us operate our business and the Site or administer activities on our behalf, such as sending out newsletters or surveys. We may share your information with these third parties for those limited purposes provided that you have given us your permission.</p>

				<h3>Changes to this privacy policy</h3>

				<p>WalknSell has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>

				<h3>Your acceptance of these terms</h3>

				<p>By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p>

				<h3>Contacting us</h3>

				<p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at:</p>
				
				<p><strong>WalknSell</strong><br>
				www.WalknSell.com<br>
				info [at] WalknSell.com</p>

				<p><em>This document was last updated on January 20, 2014</em></p>
			</div>
		</div>
        
    </article>
    
    <!-- <div class="full_article_bg">
    <article  class="prod_detail">
    
    
    
   
    </article>
    <div class="clear"></div>
    </div> -->

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
