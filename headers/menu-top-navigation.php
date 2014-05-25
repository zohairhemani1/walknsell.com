<?php
	session_start();
	include 'headers/_user-details.php';
	if(isset($_SESSION['username'])) 
	{
    	echo "<nav class='main_nav'>
                <ul class='inbox_menu'>
                    <li class='home'><a href='index.php'>HOME</a></li>
                    <li class='to_do'><a href='create_gig.php'>START SELLING</a></li>
                    <li class='bubble'><a href='#' class='topopup'><img src='img/bubble.png' width='24' alt=''></a>
                 <div id='toPopup'>     	
             		<div id='popup_content'>
                      <ul class='antiscroll-inner'>
                      	<li>
                        	<a href='#'>
                            	<em class='envelope envelope'></em>
                                    	threeiqs just sent you a message. Click to reply.
                            </a>
                        </li>
                        <li>
                        	<a href='#'>
                            	<em class='envelope envelope'></em>   	
                                    designhub just sent you a message. Click to reply.
                            </a>
                        </li>
                        <li>
                        	<a href='#'>
                            	<em class='envelope envelope'></em>
                                    designhub just sent you a message. Click to reply.
                            </a>
                        </li>
                        <div class='clear'></div>
                     </ul>
                     <a href='#' class='load_more'>LOAD MORE</a>
                   </div> <!--your content end-->
    </div> <!--toPopup end-->
                    </li>
                    <li id='admin'><a href='#'>
                    				<span class='user_pic_thumb'><img src='{$_profilePic}' width='24' alt='user pic'></span>
                    				{$_fname_uppercase} {$_lname_uppercase}</a>
                    	<ul>
                        	<li><a href='#' class='whats_new'><span class='info_circle fa fa-info-circle'>&nbsp;</span>What's New in V2?</a></li>
                            <li><a href='inbox.php' class='inbox'><span class='fa fa-inbox'>&nbsp;</span>Inbox</a></li>
                            <li><a href='#' class='collection'><span class='fa-heart-o'>&nbsp;</span>Collections</a></li>
                            <li><a href='#' class='settings'><span class='fa fa-gear'>&nbsp;</span>Settings</a></li>
                            <li><a href='index.php?status=logout' class='logout'><span class='fa fa-arrow-circle-o-left'>&nbsp;</span>Logout</a></li>
                            <div class='clear'></div>
                        </ul>
                    </li>
                </ul>
            </nav>";
	}
	
	else
	{
		echo "<nav class='main_nav'>
                <ul>
                    <li class='home'><a href='index.php'>HOME</a></li>
                    <li class='to_do'><a href=''>START SELLING</a></li>
                    <!-- <li class='bubble'><a href='#'><img src='img/bubble.png' width='24' alt=''></a></li> -->
                    <li class='shopping'><a href='#'  data-toggle='modal' data-target='#login'>SIGN IN</a></li>
                    <li id='sales'><a href='#' data-toggle='modal' data-target='#register'>JOIN</a></li>
                    <!-- <li class='admin'><a href='#'>ZOHAIR HEMANI</a></li> -->
                </ul>
			</nav>";
	}
	
?>

