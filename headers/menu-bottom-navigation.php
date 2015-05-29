<footer class="main_footer">

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

                	<li class=""><a href="index.php">Home</a></li>
                    <li class=""><a href="create_gig.php">Start selling</a></li>
				</ul>
                <ul class="second">
                	 <?php
	              	if(!isset($_SESSION['username'])) 
	{
                  
                   echo"<li class=''><a href='#'  data-toggle='modal' data-target='#login'>Sign in</a></li>";
	}
	?> 
    <?php
	              	if(!isset($_SESSION['username'])) 
	{
    
                    echo "<li class=''><a href='#' data-toggle='modal' data-target='#register'>Join</a></li>";
	}
	?>
                	
                </ul>
    
             <ul class="third">
             	<li class=""><a href="privacy_policy.php">Policy</a></li>
                <li class=""><a href='#' data-toggle='modal' data-target='#contactus'>Contact us</a></li>

             </ul>    

               

                <div class="clear"></div>

            </div>

            <div class="copyright">
            	<h4 class="f_logo">WalknSell</h4>
                	<p>Copyright 2015 WalknSell.</p>
					<p>All Rights Reserved</p> 
            </div
            <div class="clear"></div>
        </div>
</footer>