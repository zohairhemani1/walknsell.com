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
    <header> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
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
