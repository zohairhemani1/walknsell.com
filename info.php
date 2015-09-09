<?php
	include 'headers/connect_to_mysql.php';
	include'session.php';
	include 'headers/image_cover.php';
	include 'headers/image_info.php';
	include 'image.php';
	$app_id = $_SESSION['app_id'];
	$query_user = "SELECT * FROM user WHERE app_id = '$app_id' ";
	$result_user = mysqli_query($con,$query_user)
	or die('error');
	$row = mysqli_fetch_array($result_user);
	$user_name = $row['user_name'];
	$password = $row['password'];
	$email = $row['email'];
	$image = $row['image'];
	$logo =  $row['logo'];
	$cover =  $row['cover'];
	$about_us =  $row['about_us'];
	$time_cone = $row['time_cone'];

?>
<!doctype html>
<html>
<head>
<title>UFCW 5</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="css/bootstrap.css" type="text/css" rel="stylesheet">
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" >
<link href="css/style.css" type="text/css" rel="stylesheet">
<link href="css/styles.css" type="text/css" rel="stylesheet">
<script src="jquery/bootstrap.min.js"></script>
<script src="jquery/jquery-1.11.1.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">// <![CDATA[
$(function(){
  $("change").each(function(i){
    len=$(this).text().length;
    if(len>19)
    {
      $(this).text($(this).text().substr(0,19)+'...');
    }
  });
});
// ]]></script>
       <script src="js/responsive-nav.js"></script>
</head>

<body>
	<div class="info">
		 	<div id="login">
             <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" id="nav" data-toggle="dropdown" role="button" aria-expanded="false">
          <img src="images/arbish.jpg" width="15px" height="20px"> &nbsp;<?php echo  strtoupper($username);?>
           <span class="caret"></span></a>
         
          <ul class="dropdown-menu" role="menu">
            <li><a href="info.php">Account info</a></li>
            <li><a href="help.php">Help</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>

      </ul>
</p>
</div>
		</div></div>	
			<div id="logo">
		    <header style="background-color:<?php echo $color;?>">
           <center>
      <div class='logo'><img class="size" src="images/logo/<?php echo $logo;?>" border="0" alt="Null"></div>
		  </center>
		  <?php include 'headers/header_navigation.php'; ?>
</div>
</div>
     </header>
<form id="form1">
	<br>
	<div class="change">Profile <span class="name"><img src="images/image/<?php echo $image?>"></span></div><br><br>
	<div class="change">User<span class="name"><?php echo $user_name?></span></div><br><br>
	<div class="change">Password<span class="passowrd"><?php echo $password?></span></div><br><br>
	<div class="change">Email<span class="email"><?php echo $email?></span></div><br><br>
	<div class="change">Joined<span class="time"><?php echo $time_cone?></span></div><br><br>
	<div class="change">About Us<span class="about_us">we do every thing..</span></div><br><br>
	<a href="update_info.php?app_id=<?php echo $app_id; ?>"><button type='button' class='info_button' >Update</button></a>	
		
    </form>
<div id="footer">
 <?php  include 'headers/header_footer.php'; ?>

</div>  
 <script src='js/fastclick.js'></script>
<script src='js/scroll.js'></script>
<script src='js/fixed-responsive-nav.js'></script>
 
    </body>
    </html>
 
    <script>
      var navigation = responsiveNav("#nav1", {
        customToggle: "#nav-toggle"
      });
    </script>


