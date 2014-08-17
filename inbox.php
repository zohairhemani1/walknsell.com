<?php
session_start();
include 'headers/_user-details.php';


	

	
	if($_GET)
	{	
	$type = $_GET['type'];
	if($type=='archive'){
		  $stmt = $dbh->prepare("SELECT max(i.ID),i.*,u.profilePic,u.fname,u.lname FROM inbox i,users u WHERE i.senderID = u.ID and i.receiverID  = :user and i.isArchive=:isarchive GROUP BY i.senderID");
   $readS=1;
    $stmt->bindParam(':user', $_userID);
	 $stmt->bindParam(':isarchive', $readS);
    $stmt->execute();
     
		}
		else if($type=='unread'){
			  $stmt = $dbh->prepare("SELECT max(i.ID),i.*,u.profilePic,u.fname,u.lname FROM inbox i,users u WHERE i.senderID = u.ID and i.receiverID  = :user and i.isRead =:isread GROUP BY i.senderID");
			  $readS=0;
    $stmt->bindParam(':user', $_userID);
	 $stmt->bindParam(':isread', $readS);
    $stmt->execute();
    
			}
			else if($type=='read'){
				  $stmt = $dbh->prepare("SELECT max(i.ID),i.*,u.profilePic,u.fname,u.lname FROM inbox i,users u WHERE i.senderID = u.ID and i.receiverID  = :user and i.isRead =:isread GROUP BY i.senderID");
     $readS=1;
    $stmt->bindParam(':user', $_userID);
	 $stmt->bindParam(':isread', $readS);
    $stmt->execute();
   
				}
	
	}else{
	

	$stmt = $dbh->prepare("SELECT max(i.ID),i.*,u.profilePic,u.fname,u.lname FROM inbox i,users u WHERE i.senderID = u.ID and i.receiverID  = :user GROUP BY i.senderID");
    $stmt->bindParam(':user', $_userID);
    $stmt->execute();
   
	
	
	

	}
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::Inbox:</title>
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


<script src="js/school-list.js"></script>

</head>

<body>
<div class="container">
	<div class="header_bg">
        <header>
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>

           <?php include "headers/menu-top-navigation.php"; ?>
        </header>
        <div class="clear"></div>
    </div><!--/.header_bg-->
     <div id="backgroundPopup"></div>
    <div class="content_inbox">
    	<h1>Inbox</h1>
        <a href="#" class="search_icon"><img src="img/magnifying.png" width="30" alt="search"></a>
        <div class="content_inbox_inner">
        	<div class="fixed_top">
            	<div class="mail_selector">
                	<div class="dropdown">
                		<a data-toggle="dropdown" href="#"><input type="checkbox" id="mail_select">
                    	<label for="mail_select"><img src="img/arrow.png" width="14" alt=""></label></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    						<li><a href="#">ALL</a></li>
            				<li><a href="#">NONE</a></li>
                            <li><a href="#">READ</a></li>
                            <li><a href="#">UNREAD</a></li>
                            <li><a href="#">STARRED</a></li>
                            <li><a href="#">UNSTARRED</a></li>
  						</ul>
                    </div>
  		

                </div>
                  <p class="mark">mark as</p>
                  <div class="btn-group">
                  	<a href="inbox.php?type=archive" class="btn_top archive">ARCHIVE</a>
                  	<a href="inbox.php?type=unread" class="btn_top unread">UNREAD</a>
                  	<a href="inbox.php?type=read" class="btn_top read">READ</a>
                    	<div class="clear"></div>
                  </div>
                    
                  <div class="wrap-search">
					<input id="query" maxlength="80" name="query" type="text" placeholder="SEARCH">
		            <input type="image" src="img/glass_small.png" alt="Go">
                  </div>
            </div>
            <div class="main_table">
            	<table>
                	<thead>
                		<tr>
                    		<td>
                            	<table>
                                	<tr>
                                    	<td>&nbsp;</td>
                            			<td class="sender_td">SENDER</td>
                                        <td class="last_messege_td">LAST MESSEGE</td>
                                        <td class="update_head">UPDATE</td>
                                    </tr>
                                </table>
                            </td>
                    	</tr>
                    </thead>
                    <tbody>
                    
                    <?php
             
                    
					
					
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 					
					$date=$row['dateM'];
					$lastmessage=$row['message'];
					$sender=$row['fname'].' '.$row['lname'];
					$profileImg=$row['profilePic'];
					if($profileImg==""){
						$profileImg="img/sender_img.png";
						}
                    	echo "<tr>
                        	<td class='inbox_mail_row'>
                            	<table class='ellip'>
                                	<tr>
                                    	<td class='checkbox'><input type='checkbox'></td>
                                        <td class='star'><img src='img/star.png' width='23' alt='star'></td>
                                        <td class='sender_dt'><img src='$profileImg' width='26' alt='sender'>${sender}</td>
                                        <td class='messege_subject'><a href='inbox_des.php?id=$row[senderID]&mode=0'>${lastmessage}</a></td>
                                        <td class='update'>${date}</td>
                                   </tr>
                                </table>
                            </td>
                        </tr>" ;
						}
	                ?>   
       					
            
                    </tbody>
                </table>
                <p class="summary_para">Showing 8 of 200 messeges</p>
            </div><!--/.main_table-->
            
            
        	<div class="clear"></div>
        </div>
        <a href="#" class="load_more_btn">OLDER CONVERSATIONS</a>
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

</body>
</html>