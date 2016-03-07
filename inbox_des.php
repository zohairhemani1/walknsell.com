<?php
	session_start();
	include 'headers/_user-details.php';
	if(empty($_SESSION['username'])) {
    header('Location: /404.php');
    }
    $username = $_GET['username'];

    $query_sender  = "SELECT ID from users where username = '$username'";
    $result_sender = mysqli_query($con,$query_sender);
    $row_sender = mysqli_fetch_array($result_sender);
    $ID = $row_sender['ID'];
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::Inbox::</title>
<link rel="stylesheet" href="/css/style.css" type="text/css">
<link rel="stylesheet" href="/css/media.css" type="text/css">
<link rel="stylesheet" href="/css/fontello.css" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/css/jquery.sidr.dark.css" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap-dropdonw.css">
<!--<script src="js/jquery.min.js"></script>-->
<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.sidr.min.js"></script>
    <script src="/js/moment.min.js"></script>
<script src="/js/custom.js"></script>

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
	

	echo "<script>

var sender = $_userID;
var receiver = $ID;
var fname='${_fname}';
var lname='${_lname}';
var username='${_username}';
var img = '/${_profilePic}';

</script>";
	?>
<script>


var error;

$(document).ready(function(e) 
{
// console.log('sender--> '+sender);
// console.log('receiver-->'+ receiver);
// console.log('fname-->'+ fname);
// console.log('lname-->'+ lname);
// console.log('username-->'+ username);
// console.log('img-->'+ img);
sendMessage();
});


function sendMessage()
{
		// variable to hold request
		var request;
		// bind to the submit event of our form
		//$("#msgsend").on('click',function(event){
        $("#msgForm").on('submit',function(){
		// show loading bar until the json is recieved
		if(msgLength() >= 4){
        $(document).ajaxSend(function(e, jqXHR){
            $('#msgForm *').attr('disabled', true);
            $('.gif_image').show();
            });
            var formData = new FormData($(this)[0]);
            formData.append("sender",sender);
            formData.append("receiver",receiver);
			request = $.ajax({
				url: "/inbox_sendmsg.php",
                contentType: false,
                processData: false,
				type: "post",
                cache: false,
                data: formData
				//data: {msg:$('#reply_texts').val(),sender:sender,receiver:receiver}
			});
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){

                   $('#msgForm *').attr('disabled', false);
                  $(".error-alert").html("");
                $('.gif_image').hide();
					if(response.request=="Message Sent!"){
                        $(document).ajaxComplete(function(e, jqXHR){
                        //remove the div here
                        });
                        var files = $('#FileUpload')[0].files;
                        var filenames = [];
                         
                        var datetime = moment().format('HH:mm MMMM,Do,YYYY');
                        for (var i = 0; i < files.length; i++) {
                            filenames.push(files[i].name);
                        }
                        if (filenames.length === 0){
                            $( "<div class='msg_wrap_2'> <div class='messege_push'><span class='user-pict_50'>"
                            +"<a href='/"+username+"'><img src='/img/users/"+img+"' width='50' height='50' /></a></span>"
                            +"<h4><a href='/"+username+"'>"+fname + " "+lname+"</a></h4> <div class='msg_body'>"
                             +" <p class='texttype'>"+$('#reply_texts').val()+"</p></div></div>"
                              +"<div class='msgtime'>"
			                 +"<p>"+datetime+"</p></div>"
			                 +"<div class='clear'></div></div>"
                           +"<div class='clear'></div>" ).insertBefore( ".reply_box_22" );
                        }else{
                            filenames_final = response.files;
                            var filename = "";
                            for (var i = 0; i < filenames.length; i++) {

                                filename += "<p class='attachment-para'><a class='attachment-anchor' href='assets/inboxData/"+filenames_final[i]+"' download>"+filenames[i]+"</a></p>";
                            }
                            
                            $( "<div class='msg_wrap_2'> <div class='messege_push'><span class='user-pict_50'>"
                            +"<a href='/"+username+"'><img src='/img/users/"+img+"' width='50' height='50' /></a></span>"
                            +"<h4><a href='/"+username+"'>"+fname + " "+lname+"</a></h4> <div class='msg_body'>"
                             +" <p class='texttype'>"+$('#reply_texts').val()+"</p>"+filename+"</div></div>"
                           +"<div class='clear'></div>" ).insertBefore( ".reply_box_22" );
                        }
							
						//location.reload();
						$('#reply_texts').val('');
                        $("#FileUpload").replaceWith($("#FileUpload").val('').clone(true));
                        $('#fileAttach').html("<span class='fa fa-file'> &nbsp;</span>ATTACH FILE");
					}else{
                        alert(response);
                    }
				//window.location.href = "your-questions.html";
			});
		
			// callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// log the error to the console
				alert('Request Failed!');
				console.error("The following error occured: "+textStatus, errorThrown);
			});
	
			// callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// reenable the inputs
			});
			}
      else{
				$(".error-alert").text("Your message should contain atleast 4 characters.");
			}
	       return false;
	});
	
}
</script>
<script>
	$(document).ready(function() {
	var maxchar = 1200;
	$("#reply_texts").keyup(function(){
		if($(this).val().length > maxchar){
			$(this).val($(this).val().substr(0, maxchar));
		}else if($(this).val().length == maxchar){
			$(".char-count").css("color", "red");
		}else if($(this).val().length < maxchar){
			$(".char-count").css("color", "black");
		}
		$(".count-num").text($(this).val().length);
	});
	});
	function msgLength(){
		return $("#reply_texts").val().length;
	}
</script>
</head>

<body>
<div class="container inbox_des">
  <div class="header_bg">
    <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
           <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
<?php include 'headers/popup.php';?>
  <div class="content_inbox">
    <div class="user_head">
      <h1 class="with-thumb">
      <?php


	if(isset($_GET['username']))
	{		
		$username = $_GET['username'];
		$query = "SELECT * from users WHERE username = :username";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':username',$username);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$id_recieve = $result['ID'];
		$name = $result['fname']." ".$result['lname'];
	
    echo"<span class='user-picture'>
                	<img src='/img/users/$result[profilePic]' alt='$result[username]' width='50' height='50' class=''>
               	</span>
                Conversation with <a href='/$result[username]'>$result[fname] $result[lname]</a>
            </h1>
		</div>
        <div class='conver_head'>
        	<h2 class='discuss'>discussion</h2>
            
            <div class='wrap-search'>
					<input id='query' maxlength='80' name='query' type='text' placeholder='SEARCH'>
		            <input type='image' src='/img/glass_small.png' alt='Go'>
                  </div>
                     
               <div class='clear'></div>
        </div>
        
		
			<div class='conver_body'>
        	<div class='div_aside'>
            	<a href='unread' class='read_un unread'>unread</a>
		    	<a href='read' class='read_un read'>read</a>
                <a href='all' class='read_un'>All</a>
                <div class='clear'></div>      
            </div>";
			
			$readindex=0;
		if($_GET['mode']=='read'){
			$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title from inbox i join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = 	:sID)) && i.isRead=1 order by i.dateM";
			$readindex=1;
		}else if($_GET['mode']=='unread'){
			$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title from inbox i join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID))  && i.isRead=0 order by i.dateM";
			$readindex=2;
		}else{
			$query = "SELECT i.*, u.fname,u.username,u.lname,u.profilePic,k.image,k.title  from inbox i join users u on u.ID = i.senderID left outer join korks k on k.ID = i.korkID WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID)) order by i.dateM ";
			$readindex=0;
		}
		$sth = $dbh->prepare($query);
		$sth->bindValue(':sID',$result[ID]);
		$sth->bindValue(':rID',$_userID);
		$sth->execute();
		
		
		
		$now = time();	
		while($result = $sth->fetch(PDO::FETCH_ASSOC)){
			
        $nth = $dbh->prepare("SELECT attachment, displayname FROM inbox_attachments WHERE inboxID = :inboxID");
        $nth->bindValue(':inboxID', $result['ID']);
        $nth->execute();
        $attachments = $nth->fetchAll(PDO::FETCH_ASSOC);
            
		  if($result['korkID']!=0){
			echo"<div class='msg_wrap_11'>
            <div class='conv_action'>
            	<div class='messege_push_1'>
				<span class='user-pict_50'>
                		<a href='/$result[username]'><img src='/img/users/$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='/$result[username]'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p class='texttype'>$result[message]</p>
                      </div>
                </div>
                <div class='clear'></div>
            </div>
            
            <div class='gig_related_to'>
            	<h4>THIS MESSAGE IS RELATED TO:</h4>
                <div class='msg-gig'>
                        <span class='gig-pict-74'><a href='cate_desc.php?korkID=$result[korkID]'><img src='/img/korkImages/$result[image]' width='50px' class='related-gig-pict' alt=''></a></span>
                        <p class='gig-desc'><a href='#' style='display:block;overflow:hidden;'>$result[title]</a></p>
                        <p class='gig-username'>by <a href='/$result[username]'>$result[username]</a><span class='flag-in'></span></p>
                    </div>
            </div>
			<div class='msgtime'>
			<p>",date('H:i F, d, Y', strtotime($result['dateM'])),"</p></div>
			<div class='clear'></div>
            </div>";
			  }else if(($result['isRead']==0 && $readindex==0) || $readindex==2)  {
		  echo"
            <div class='msg_wrap_2'>
            <div class='messege_push'>
                	<span class='user-pict_50'>
                			<a href='#'><img src='/img/users/$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='/$result[username]'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p class='texttype'>$result[message]</p>";
                        if(!empty($attachments)){
                            foreach($attachments as $attach){
                                echo "<p class='attachment-para'><a class='attachment-anchor' href='assets/inboxData/$attach[attachment]' download>$attach[displayname]</a></p>";
                            }
                        }
                    echo "</div>
                </div>
                <div class='msgtime'>
				<p>",date('H:i F, d, Y', strtotime($result['dateM'])),"</p></div>
				   <div class='clear'></div>
            </div> ";
		}else{
		  echo"
            <div class='msg_wrap_3'>
            <div class='messege_push'>
                	<span class='user-pict_50'>
                			<a href='#'><img src='/img/users/$result[profilePic]' alt='$result[username]' width='50' height='50' class=''></a>
               		</span>
                    <h4><a href='/$result[username]'>$result[fname] $result[lname]</a></h4>
                      <div class='msg_body'>
                      <p class='texttype'>$result[message]</p>";
                        if(!empty($attachments)){
                            foreach($attachments as $attach){
                                echo "<p class='attachment-para'><a class='attachment-anchor' href='assets/inboxData/$attach[attachment]' download>$attach[displayname]</a></p>";
                            }
                        }
                    echo "</div>
                </div>
				<div class='msgtime'>
				<p>",date('H:i F, d, Y', strtotime($result['dateM'])),"</p></div>
				   <div class='clear'></div>
            </div> ";
		}
	
	}
	
    }
              echo"  <div class='reply_box_22' id='reply_box'>
                	<div class='reply_box_header'><h3>Send <font color='#0084a6'>$name</font> a message.</h3></div>";
   
						//$query = "UPDATE inbox i SET i.isRead=1 WHERE ((i.senderID = :sID && i.receiverID = :rID) || (i.senderID = :rID && i.receiverID = :sID)) order by i.ID";
						$query = "UPDATE inbox i SET i.isRead=1 WHERE (i.senderID = :sID && i.receiverID = :rID) order by i.ID";						
                        $sth = $dbh->prepare($query);
                        $sth->bindValue(':sID',$id_recieve);
                        $sth->bindValue(':rID',$_userID);
                        $sth->execute();
?>
      <div class="write_wrap">
      <form id="msgForm" method="post" enctype="multipart/form-data">
        <textarea class="reply_text" id='reply_texts' name="msgText" cols="75" placeholder="Type your text here" rows="3"></textarea>
        <div class="bottom_div">
          <a class="btn btn_file read_un" id="fileAttach" onclick='$("#FileUpload").click()'><span class="fa fa-file"> &nbsp;</span>ATTACH FILE</a>
          <input type="file" style="display:none;" name="FileUpload[]" id="FileUpload" multiple="multiple" />
          <p class="maxsize"> <span>Max Size 30MB <img class="gif_image" src="/img/loading.gif" /></span> <br>
          <span><span class="upload_prob" href="#">Multiple File Select</span></span> </p>
		  <p class="error-alert"></p>
            <button class="button_send" id="msgsend">SEND</button></form>
		  <p class="char-count"><span class="count-num">0</span><span> / 1200</span> Characters Limit</p>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<?php include 'headers/menu-bottom-navigation.php' ?>
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
    <script src="/js/nav-admin-dropdown.js"></script>
<script src ="/js/register.js"></script> 
    <script>
    
    $("#FileUpload").trigger('click');
    $('#FileUpload').bind('change', function() {
    var fileSelectEle = document.getElementById('FileUpload');
        if(fileSelectEle.value.length == 0) {
        $('#fileAttach').html("<span class='fa fa-file'> &nbsp;</span>ATTACH FILE");
         $(".error-alert").html("");
        } 
        var filesize = this.files[0].size/(1024*1024);
      if(filesize > 0 && filesize < 30){
        $('#fileAttach').html("<span class='fa fa-file'> &nbsp;</span>ATTACHED");
      }
        else{
          $(".error-alert").html("The file attachment is not acceptable. Please try again.");
      }

    });
</script>


</body>
</html>
