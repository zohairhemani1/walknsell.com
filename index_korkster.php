<!doctype html>
<html lang="en">
<head>
	<title>WalknSell</title>
	<meta name="description" content="">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<style type="text/css">
@import url("assets/css/grid.css");
@import url("assets/css/reset.css");
@import url("assets/css/styles.css");
</style>


</head>
<body>
	<div id="wrapper">
		<header>
			<div id="header" class="clearfix">
				<a href="#" id="logo">WalknSell</a>
				<nav>
					<ul class="clearfix">
						<li><a href="register.php">Register</a></li>
						
						<li><a href="/korkster/my-account.php">My Account</a></li>
                        <li><a href="/korkster/my-account-edit-info.php">My Acc edit info</a></li>
                        <li><a href="/korkster/reset-password.php">Reset Password</a></li>
                        <li><a href="/korkster/my-account-change-password.php">Change Password</a></li>
                        <li><a href="/korkster/login.php">Login</a></li>
                        <li><a href="/korkster/post-kork.php">POST KORK</a></li>
					</ul>
				</nav>
			</div>
		</header> <!-- End Header -->
		<div id="heroWrapper">
			<div id="hero" class="home">
				<h1>Find Your School</h1>
               
				<form id ="search" name="search" action="school/ <?php echo $name_hypens; ?>" method="get" class="clearfix" >
					<input id="uni" type="text" name="search_text" autocomplete="off" class="textField" onKeyUp="findmatch();">
					<input type="submit" value="Search" class="submitButton">
                    <!-- <div> <li class="naslov"><b> Hello World </b></li></div> -->
            		<div id="listview" class = "listview" style="height:200px;">
                		<ul id ="results" name="school" style="margin-left:0px; margin-top:70px;">
                        	<!-- <li id="unilist"><a href="#"> My name is Zohair</a> </li>
                            <li id="unilist"><a href="#"> My name is Salman</a> </li>
                            <li id="unilist"><a href="#"> My name is Ammar</a> </li> -->
                        </ul>
                    </div>
				</form>
				
			</div> 
		</div> <!-- End Hero Wrapper -->
		<div id="content" class="clearfix">
			<div class="container_18">
				<div class="grid_9 alpha">
					<h2>What is WalknSell?</h2>				
					<p>WalknSell is a social website that helps students and teachers like you post classifieds related to your school or university.</p>
					<p>We take multiple security measures to ensure that only legitimate classifieds are shown and spam is minimized.</p>
					<p>WalknSell is safe and simple.</p>
				</div>
				<div class="grid_9 omega">
					<h2>How It Works</h2>
					<ul class="homepageList">
						<li>
							<span class="listNumber">1</span>
							Register an account.
						</li>
						<li>
							<span class="listNumber">2</span>
							Post a classified related to your school.
						</li>
						<li>
							<span class="listNumber">3</span>
							Interested students or teachers will contact you via email.
						</li>
						<li>
							<span class="listNumber">4</span>
							Enjoy life.
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="push"></div>
	</div> <!-- End Wrapper -->
	<footer>
		<p>&copy; <?php echo date("Y"); ?> WalknSell, LLC. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
	</footer>
	
	
	
	<script type="text/javascript">

		function findmatch(){
		
		document.getElementById('results').innerHTML = 'Loading..';
		
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
			}
			else{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}

			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				
				//var ul = document.getElementById("results");
				//var li = document.createElement("li");
				//li.appendChild(document.createTextNode(xmlhttp.responseText));
				//ul.appendChild(li);
				
				document.getElementById('results').innerHTML = xmlhttp.responseText;
				}
			}
			
			xmlhttp.open('GET','search_list.inc.php?search_text='+document.search.search_text.value,true);
			xmlhttp.send();
			
		}

	</script>
   
	
    <script>
		$(document).on('click','#results li' , function() {
			$('#uni').val($(this).text());

		});

	</script>
	
	
</body>
</html>