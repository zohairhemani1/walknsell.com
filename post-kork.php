<?php
	
	include '_user-details.php';
	
	if($_POST)
	{
	
	$korkname = $_POST['korkname'];
	$korkname_hyphens = str_replace(' ', '-', $korkname);
	$category = $_POST['korkLabel'];
	$description = $_POST['korkdescription'];
	$attachment = $_POST['name3'];
	
           $attachment=substr($attachment,1);
	$pieces = explode(",", $attachment);
	//echo $attachment;
	
		if($korkname==null)
		{
			echo "Enter Korkname.";
		}
		elseif($category==null)
		{
			echo "Choose Category.";
		}
		elseif($description==null)
		{
			echo "Enter Description";
		}
		elseif($attachment == null)
		{
			echo "Upload Kork Image";
		}else{
	
	
	

	
  
  $dbh->exec("INSERT INTO korks(userID,title,detail,image,status,expirydate) VALUES('$_userID','$korkname','$description','$attachment','$category',now())");
	
    $stmt = $dbh->prepare("SELECT max(id) FROM korks WHERE username = :username");
    $stmt->bindParam(':username', $_username, PDO::PARAM_STR,15);

    $stmt->execute();
  
    $result = $stmt->fetchAll();
$id=$result[0];
	



foreach($pieces as &$arr){
  $dbh->exec("INSERT INTO kork_img(refId,attachment) VALUES('$id[0]' ,'$arr')");
	
}
 $dbh = null;
}


header("Location: /korkster/kork/{$korkname_hyphens}");
	
			
	}
?>



<!doctype html>
<html lang="en">
<head>
	<title>Post a Kork | WalknSell</title>
	<meta name="description" content="School Name Here">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,700,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="assets/css/reset.css">
	<link rel="stylesheet" href="assets/css/grid.css">
	<link rel="stylesheet" href="assets/css/styles.css">
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Bootstrap styles -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="assets/css/fileupload.css">
</head>
<body>
	<div id="wrapper">
		<header>
			<div id="header" class="clearfix">
				<a href="/korkster/" id="logo">WalknSell</a>
				<nav>
					<ul class="clearfix">
						<li><a href="register.php">Register</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</nav>
			</div>
		</header> <!-- End Header -->
		<div id="heroWrapper">
			<div id="hero" class="clearfix">
				<h1>Post a Kork</h1>
				<p class="changeSchool"><a href="#">Cancel</a></p>
			</div> 
		</div> <!-- End Hero Wrapper -->
		<div id="contentSub" class="clearfix">
			<div class="container_18">
				<div class="grid_18">
					<div class="contentBox"  id="uni">
						<p>Your Kork will be posted in <strong><?php echo $_college; ?></strong>.</p>
						<form action="post-kork.php" method="post" enctype="multipart/form-data" >
							<input type="text" name="korkname" placeholder="Kork Name" value="<?php echo $korkname;?>" >
							<select name="korkLabel">
								<option value=""> Select a category</option>
								<option value="forSale">For Sale</option>
								<option value="housing">Housing</option>
								<option value="tutoring">Tutoring</option>
								<option value="books">Books</option>
								<option value="other">Other</option>
							</select>
							<textarea name="korkdescription" placeholder="Describe Your Kork in Detail"><?php echo $description; ?></textarea>
							<span class="btn btn-success fileinput-button">
						        <i class="glyphicon glyphicon-plus"></i>
						        <span>Select photos...</span>
						        <!-- The file input field used as target for the file upload widget -->
						       <input id="fileupload" type="file" name="files[]" accept="image/*" >
						    </span><br>
							
							 <br>
							<br>
							<!-- The global progress bar -->
							<div id="progress" class="progress">
								<div class="progress-bar progress-bar-success"></div>
							</div>
							<!-- The container for the uploaded files -->
							<div id="files" class="files">
								<input type="hidden" name="name3" value="">
							</div>
                            
                           
							<br>
							
							
							<input type="submit" value="Post">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div> <!-- End Wrapper -->
	<footer>
		<p>&copy; <?php echo date("Y"); ?> WalknSell, LLC. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
	</footer>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/file-upload/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/file-upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/file-upload/jquery.fileupload.js"></script>



</body>
</html>