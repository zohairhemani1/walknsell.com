<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::Inbox::</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
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
<!--[if lte IE 10]>
    <style type="text/css">
    .content_inbox_inner .fixed_top{width:100%; margin:0 auto;}
    .content_inbox_inner .fixed_top:before, .content_inbox_inner .fixed_top:after{display:none;}
    </style>
<![endif]-->

<?php
	
	include 'headers/connect_to_mysql.php';
	include 'headers/_user-details.php';
	echo "<script>

var sender = $_userID;

var receiver = $_GET[id];
var fname='${_fname}';
var lname='${_lname}';
var img = '${_profilePic}';

</script>";
	?>
<script>


var error;

$(document).ready(function(e) 
{
    
sendMessage();

	
});


function sendMessage()
{
	
	
	
		// variable to hold request
		var request;
		// bind to the submit event of our form
		$("#msgsend").on('click',function(event){
		// show loading bar until the json is recieved
		
		
    
				
			request = $.ajax({
				url: "http://www.fajjemobile.info/korkster.com/inbox_sendmsg.php",
				type: "post",
				data: {msg:$('#reply_texts').val(),sender:sender,receiver:receiver}
			});
			
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// log a message to the console
				
				
					if(response=="Message Sent!"){
						//alert('Message Sent Successfully!');
						
						
					$( "<div class='msg_wrap_2'> <div class='messege_push'><span class='user-pict_50'><a href='#'>"
					+"<imgsrc='"+img+"' alt='$result[username]' width='50' height='50' class=''></a>"
               		+"</span><h4><a href='#'>"+fname + " "+lname+"</a></h4> <div class='msg_body'>"
                     +" <p>"+$('#reply_texts').val()+"</p> </div>   </div>"
				   +"<div class='clear'></div>" ).insertBefore( ".reply_box_22" );
						
						
						//location.reload();
						}
				
				//window.location.href = "your-questions.html";
			});
		
			// callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// log the error to the console
				
				alert('Request Failed!');
				console.error(
					"The following error occured: "+
					textStatus, errorThrown
				);
			});
	
			// callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// reenable the inputs
			});
			
			
	
	});
	
}



</script>
</head>

<body>
<div class="container inbox_des">
  <div class="header_bg">
    <header> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
      <div id="sidr">
        <ul class="sidr_menu">
          <li class="home"><a href="#">HOME</a></li>
          <li class="to_do"><a href="#">START SELLING</a></li>
          <li class="bubble"><a href="#"><img src="img/bubble.png" width="24" alt=""></a></li>
          <li id="admin"><a href="#">ZOHAIR HEMANI</a>
            <ul>
              <li><a href="#">First item</a></li>
              <li><a href="#">Second item</a></li>
              <li><a href="#">Third item</a></li>
              <div class="clear"></div>
            </ul>
          </li>
        </ul>
      </div>
      <div class="logo"><a href="#"><img src="img/logo.png" width="153" alt=""></a></div>
      <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
  <div id="backgroundPopup"></div>
  <div class="content_inbox">
    <div class="user_head">
      <h1 class="with-thumb">
      <?php


	if(isset($_GET['id']))
	{		
		$ID = $_GET['id'];
		$query = "SELECT * from users WHERE ID = :ID";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':ID',$ID);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$name=$result['fname']." " .$result['lname'];
		
	
	
    echo"            <span class='user-picture'>
                	<img src='$result[profilePic]' alt='$result[username]' width='50' height='50' class=''>
               	</span>
                Conversation with <a href='user/$result[username]'>$result[fname] $result[lname]</a>
            </h1>
		</div>
        <div class='conver_head'>
        	<h2 class='discuss'>discussion</h2>
            
            <div class='wrap-search'>
					<input id='query' maxlength='80' name='query' type='text' placeholder='SEARCH'>
		            <input type='image' src='img/glass_small.png' alt='Go'>
                  </div>
                     
               <div class='clear'></div>
        </div>
        
		
        <div class='conver_body'>
        	<div class='div_aside'>
            	<a href='inbox_des.php?id=$ID&mode=2' class='read_un unread'>unread</a>
		    	<a href='inbox_des.php?id=$ID&mode=1' class='read_un read'>read</a>
                <a href='inbox_des.php?id=$ID&mode=0' class='read_un'>All</a>
                <div class='clear'></div>      
            </div>";
			
		$readindex=0;
		if($_GET['mode']==1){
		$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title  from inbox i 
join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID)) && i.isRead=1 order by i.ID";
$readindex=1;
		}else if($_GET['mode']==2){
					$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title  from inbox i 
join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID))  && i.isRead=0 order by i.ID";
			$readindex=2;
			}else{
						$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title  from inbox i 
join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID)) order by i.ID";
				$readindex=0;
				}
		$sth = $dbh->prepare($query);
		$sth->bindValue(':sID',$ID);
		$sth->bindValue(':rID',$_userID);
		$sth->execute();
		
		
		
				
		while($result = $sth->fetch(PDO::FETCH_ASSOC)){
          
		  if($result['korkID']!=0){
			
		    echo"<div class='msg_wrap_11'>
            <div class='conv_action'>
            	<div class='messege_push_1'>
                

	
         <span class='user-pict_50'>
                		<a href='#'><img src='$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='#'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p>$result[message]</p>
                      </div>
                </div>
                <div class='clear'></div>
            </div>
            
            <div class='gig_related_to'>
            	<h4>THIS MESSAGE IS RELATED TO:</h4>
                <div class='msg-gig'>
                        <span class='gig-pict-74'><img src='korkImages/$result[image]' width='50px' class='related-gig-pict' alt=''></span>
                        <p class='gig-desc'><a href='#'>$result[title]</a></p>
                        <p class='gig-username'>by <a href='#'>$result[username]</a><span class='flag-in'></span></p>
                    </div>
            </div>
            <div class='clear'></div>
            </div>";  
			  }else if(($result['isRead']==0 && $readindex==0) || $readindex==2)  {
		  echo"
            <div class='msg_wrap_2'>
            <div class='messege_push'>
                	<span class='user-pict_50'>
                			<a href='#'><img src='$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='#'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p>$result[message]</p>
                      </div>
                </div>
				   <div class='clear'></div>
            </div> ";
		}else{
		  echo"
            <div class='msg_wrap_11'>
            <div class='messege_push'>
                	<span class='user-pict_50'>
                			<a href='#'><img src='$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='#'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p>$result[message]</p>
                      </div>
                </div>
				   <div class='clear'></div>
            </div> ";
		}
	
	}
	}
                
              echo"  <div class='reply_box_22' id='reply_box'>
                	<div class='reply_box_header'><h3>SEND <a href='#'>$name</a> A MESSAGE</h3></div>";
					
					
						$query = "UPDATE inbox i SET i.isRead=1 WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID)) order by i.ID";
								
		$sth = $dbh->prepare($query);
		$sth->bindValue(':sID',$ID);
		$sth->bindValue(':rID',$_userID);
		$sth->execute();
					
?>
      <div class="write_wrap">
        <textarea class="reply_text" id='reply_texts' cols="75" placeholder="Type your text here..." rows="3"></textarea>
        <div class="bottom_div">
          <button class="btn btn_file read_un"><span class="fa fa-file"> &nbsp;</span>ATTACH FILE</button>
          <p class="maxsize"> <span>Maxsize 30MB</span> <br>
            <span><a class="upload_prob" href="#">Problems with upload?</a></span> </p>
          <p class="char-count"><span>0</span><span> / 1200</span> CHARS MAX </p>
          <input class="button_send" type="button" id="msgsend" value="SEND" />
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
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
      <h4 class="f_logo">Korkster</h4>
      <p>Copyright 2013 Korkster.</p>
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
<script src="js/school-list.js"></script>
</body>
</html>
