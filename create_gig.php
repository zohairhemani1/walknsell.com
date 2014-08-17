<?php
session_start();
include 'headers/_user-details.php';
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		include 'headers/image_upload.php';
		$korkname = $_POST['korkName'];
		//$korkname_hyphens = str_replace(' ', '-', $korkname);
		//$category = $_POST['korkLabel'];
		$description = $_POST['korkDesc'];
		//$attachment = $_POST['name3'];
		
	   // $attachment=substr($attachment,1);
		//$pieces = explode(",", $attachment);
		//echo $attachment;
	
		if($korkname==null)
		{
			echo "Enter Korkname.";
		}
		elseif($description==null)
		{
			echo "Enter Description";
		}
		else{
			
			if(!isset($profilePic))
			{
				$profilePic = "kork.png";
			}

		$dbh->exec("INSERT INTO korks(userID,title,detail,image,status,expirydate) VALUES('$_userID','$korkname','$description','$profilePic','$category',now())");
		
		$stmt = $dbh->prepare("SELECT max(id) FROM korks WHERE userID = :username");
		$stmt->bindParam(':username', $_userID);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		$id=$result[0];
	


	
		foreach($pieces as &$arr)
		{
		  $dbh->exec("INSERT INTO kork_img(refId,attachment) VALUES('$id[0]' ,'$arr')");
		}
		  $dbh = null;
		}
		//echo "Result: {$result}";
		//echo "ID: {$id}";
		//header("Location: /korkster/kork/{$korkname}");
		header("Location: cate_desc.php?korkID={$id[0]}");
			
} // ending if block of $_POST
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>Create Gig</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<!--<script src="js/jquery.min.js"></script>-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
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
<div class="container inbox_des create_gig">
  <div class="header_bg">
    <header> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
     
      <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
  <div id="backgroundPopup"></div>
  <div class="content_inbox">
  
  <form name="create_gig" action="create_gig.php" method="post" enctype="multipart/form-data">
  
    <h2>Create a new gig</h2>
    <div class="left_gig">
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">Gig Title</label>
        </div> 
        <div class="input_wrap gig_title">
          <input class="gig_title_text" style="width:90%" maxlength="80"  name="korkName"/>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Describe your Gig.</h3>
              <p>This is your Gig title. Choose wisely, you can only use 80 characters.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
        </aside>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_category">Category</label>
        </div>
        <div class="input_wrap">
          <!--<div class="fake-dropdown fake-dropdown-double"> <a  class="dropdown-toggle category" data-toggle="dropdown" data-autowidth="true" >CATEGORIES</a>
            <div class="dropdown-menu mega_menu" >
              <div class="dropdown-inner">
                <ul>
                  <li>Gifts</li>
                  <li>Graphics & Design</li>
                  <li><a href="#">Video & Animation</a></li>
                  <li><a href="#">Online Marketing</a></li>
                  <li><a href="#">Writing & Translation</a></li>
                  <li><a href="#">Advertising</a></li>
                  <li><a href="#">Business</a></li>
                </ul>
              </div>
            </div>
            <div class="clear"></div>
          </div>-->
		<select class="fake-dropdown fake-dropdown-double dropdown-inner " style="width:90%">
        <option value="asdf">asdfasdf</option>
        <option value="asdf">qwerq</option>
        <option value="asdf">zxcvcv</option>
        
        </select>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Seledt a Category.</h3>
              <p>This is your Gig category. Choose wisely for better promotion.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
        </aside>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_gallery">gig gallery</label>
        </div>
        <div class="input_wrap" id="gig_gallery_wrap">
          <div class="file_input_inner">
            <!--  <button type="file" class="btn_signup" name="file" id="name">Browse</button>  -->
            
            <input type="file" value="File" name="file" id="file" />
            
            <p>JPEG file, 2MB Max, <span class="grey_c">you own the copyrights</span></p>
          </div>
        </div>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">Description</label>
        </div>
        <div class="input_wrap gig_title">
          <textarea class="gig_desc_text" rows="10" maxlength="200" name="korkDesc"></textarea>
        </div>
      </div>
     <!-- <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">instruction for buyer</label>
        </div>
        <div class="input_wrap gig_title">
          <textarea class="gig_desc_text" rows="2" maxlength="80"></textarea>
        </div>
      </div> -->
    </div>
    <div class="bottom_save_block">
      <button type="submit" class="btn_signup">Submit &amp; Continue</button>
      <button class="btn_signup btn_cancel">Cancel</button>
    </div>
    
    
    
    </form>
    
    <div class="clear"></div>
  </div>
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
<script src="js/school-list.js"></script>
</body>
</html>
