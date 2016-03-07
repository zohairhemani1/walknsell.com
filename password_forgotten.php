<?php
session_start();
include 'headers/_user-details.php';
function insertAtPosition($string, $insert, $position) {
    return implode($insert, str_split($string, $position));
}
if(isset($_SESSION['username'])){
    header('Location: /404.php');
}
if(isset($_GET['cre'])){
    $emailTo = $_GET['email'];
    $changePass = md5(substr($_GET['cre'],3,8));
    $sth = $dbh->prepare("UPDATE users SET password = :pass WHERE email = :email ");
    $sth->bindValue(':pass',$changePass);
    $sth->bindValue(':email',$emailTo);
    $flag = $sth->execute();
    if($flag){
        header('Location: /password=changed');
    }else{
        header('Location: forget_password?status=failed');
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::WalknSell::</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-tagsinput.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">

<script src="js/dropzone.js"></script>
<link href="css/dropzone.css" rel="stylesheet">

<style>
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
	vertical-align: top;
}
input[type="file"] {
display: initial;
}
p {
margin: initial;
}
</style>
<!--<script src="js/jquery.min.js"></script>-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap-tagsinput.js"></script>

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
<div class="inbox_des create_gig">
  <div class="header_bg">
    <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
      <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
  <?php include 'headers/popup.php';?>
  <div style="width:41%;margin-top: 114px;" class="content_inbox">
    <h2>Forgot password?</h2>
      <form action="forget_password" method="POST">
        <div style="width: 87%;" class="left_gig">
    <?php
    if($_POST){
        $newPass = substr(md5(rand(999,999999)), 0, 8);
        $email = $_POST['useremail'];
        $sth = $dbh->prepare("SELECT email from users WHERE email = :email");
        $sth->bindValue(':email',$email);
        $sth->execute();
        $flag = $sth->rowCount();
        $randomNum = md5(time());
        $randomNum = insertAtPosition($randomNum, $newPass, 3);
        $link = "http://www.walknsell.com/forget_password?email=$email&cre=$randomNum";
        if($flag){
            $to = $email;    
            include "newsletters/forgot_password.php";
            mail($to, $subject, $message, $headers);
            echo "<h3>Email has been successfully sent to you, please check and try loging in again.</h3>";
        }else{
                    echo '<p style="color:red;" class="paragraph">The email you entered is incorrect</p>
            <div class="form_row">
                <div class="input_wrap gig_title">
                    <input class="gig_text price" placeholder="Enter email address" type="email" style="width:100%;margin-left: -5px;padding-left: 13px;height: 32px;" maxlength="80" name="useremail" required>
                </div>
            </div>
            </div>
    <div class="bottom_save_block">
      <button style="width:166px;" id="submit-all" type="submit" class="btn_signup">Submit</button>
    </div>';
        }
        echo '</div>';
    }else if(isset($_GET['status'])){
        if($_GET['status'] == 'success'){
            echo "<h3>Account password reset instructions were emailed to you.Please check!s</h3>";
        }else{
            echo "<h3>Sorry! Something went wrong, the system could not recognize your password recovery. Please try again.</h3>";
        }
        echo '</div>';
    }else{
        echo '<p class="paragraph">Enter your email address.</p>
            <div class="form_row">
                <div style="width:94%" class="input_wrap gig_title">
                    <input class="gig_text price" placeholder="Enter email address" type="email" style="width:100%;margin-left: -5px;padding-left: 13px;height: 32px;" maxlength="80" name="useremail" required>
                </div>
            </div>
            </div>
    <div class="bottom_save_block">
      <button style="width:166px;" id="submit-all" type="submit" class="btn_signup">Submit</button>
    </div>';
    }
    ?>
	</form>
    <div class="clear"></div>
  </div>
    <div id="footer_responsive">
    <?php include 'headers/menu-bottom-navigation.php' ?>
</div>
    
<script>
$(function() {      
          $("nav.main_nav li#admin > ul").css("display","none");
        
			       
           			$("nav.main_nav li#admin").hover(function () {   
         							  $( "nav.main_nav li#admin > ul" ).css( "display", "block" );
	            },          
            	function () {      
						$( "nav.main_nav li#admin > ul" ).css( "display", "none" );
				        });   
				     });
					 
</script> 
<script>
	$(document).ready(function(e) {
        $('.input_wrap').on('focus', function(){
			$(this).find('.gig-tooltip').css('background','red');
        });
    });
</script> 
      <script src ="js/register.js"></script>
<script src="js/school-list.js"></script>
<!--multiple image upload starts here -->

</body>
</html>
