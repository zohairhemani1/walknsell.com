<?php
session_start();
	include 'headers/_user-details.php';
	$korkID = $_GET['korkID'];
	//$korkName_Hypens = $_GET['kork'];
	//$korkName = str_replace('-', ' ', $korkName_Hypens);	
	
  	$stmt = $dbh->prepare("SELECT k.*, kc.category, u.username, u.profilePic, u.joinDate, c.name, c.city FROM korks k INNER JOIN kork_categories kc ON k.catID = kc.cat_id INNER JOIN users u ON k.userID = u.ID INNER JOIN colleges c ON u.collegeID = c.id WHERE k.id = :korkid");
    $stmt->bindParam(':korkid', $korkID);
    $stmt->execute();
    $result = $stmt->fetchAll();
	$row = $result[0];
	
	if($row['userID'] != $_userID){
		$dbh->exec("UPDATE korks SET visitors=visitors+1 WHERE id=$korkID");
		$visitors = $row['visitors']+1;
	}else{
		$visitors = $row['visitors'];
	}

    $id  = $row['id'];
	$title = $row['title'];
	$detail = $row['detail'];
	$status = $row['status'];
	$kork_category = $row['category'];
	$dateOfCreation = $row['expirydate'];
	
	/* Checking to see how many days have passed since the gig created */
	
	$now = time(); // or your date as well
    $dateOfCreation = strtotime($dateOfCreation);
    $datediff = $now - $dateOfCreation;
    $daysPassed = floor($datediff/(60*60*24));
	
	
 	$date = DateTime::createFromFormat("Y-m-d", $dateOfCreation);
	
	$image = $row['image'];
	$userID = $row['userID'];
	$userPic = $row['profilePic'];
	$userDate = $row['joinDate'];
	$korkUser = $row['username'];
	$korkCollege = $row['name'].', '. $row['city'];
	
	/* 
		Calculating number of days ago username joined.
	*/
	$userDate = strtotime($userDate);
    $datediff_user = $now - $userDate;
    $joinedAgo = floor($datediff_user/(60*60*24));
	
	/** Bids **/
	$stmt = $dbh->prepare("SELECT count(ID) FROM inbox WHERE korkID = :korkid");
	$stmt->bindParam(':korkid', $id);
	$stmt->execute();
		
	$result = $stmt->fetchAll();
	$bidnum=$result[0][0];
	
	$stmt = $dbh->prepare("SELECT message, bid, dateM FROM inbox WHERE korkID = :korkid AND senderID = :userid");
    $stmt->bindParam(':korkid', $korkID);
	$stmt->bindParam(':userid', $_userID);
    $stmt->execute();
    $userBid = $stmt->fetch(PDO::FETCH_ASSOC);
	$hasBid = ($userBid == null) ? false : true;
	
	$justInserted = false;
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$bid = $_POST['bid'];
		$message = $_POST['msg'];
		if($hasBid === false){			
			// inserting user details if username doesnot exist
			$query = "INSERT INTO inbox(senderID,receiverID,message,bid,dateM,korkID) VALUES (:senderID, :receiverID, :message, :bid, :dateM, :korkID)";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':senderID',$_userID);
			$sth->bindValue(':receiverID',$userID);
			$sth->bindValue(':message',$message);
			$sth->bindValue(':bid',$bid);
			$sth->bindValue(':dateM',date('Y/m/d H:i:s'));
			$sth->bindValue(':korkID',$id);
			$justInserted = true;
		}else{
			$query = "UPDATE inbox SET message = :message, bid = :bid WHERE korkID = :korkID AND senderID = :senderID";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':korkID',$id);
			$sth->bindValue(':senderID',$_userID);
			$sth->bindValue(':message',$message);
			$sth->bindValue(':bid',$bid);
		}
		$sth ->execute();
		//updating php variables.
		$hasBid = true;
		$userBid['message'] = $message;
		$userBid['bid'] = $bid;
		$userBid['dateM'] = date('Y/m/d H:i:s');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php echo $title ?> | WalknSell</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/jquery.bxslider.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<style>
.modal-dialog {
	padding-top: 180px;
}
.modal-body {
	border-bottom: 0px;
}
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
vertical-align: top;
}
</style>

<?php
	
echo "<script>

var sender = $_userID;
var korkid = $id;
var receiver = $userID;

</script>";

?>

<script src="js/modern.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>




<script src="js/jquery.fitvids.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});

$(document).ready(function() {
   $(window).bind('scroll', function(e){
	   parallax();
	  });
});

function parallax(){
	var scrollposition = $(window).scrollTop();
	$('article.header_bg_para').css('top',(0-(scrollposition * 0.2))+'px');
	$('.full_article_bg').css('top',(0-(scrollposition * 1.1))+'px');
	}
</script>



<!--<script>


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
		
		
    
		//alert(sender+receiver);
		
			request = $.ajax({
				url: "catlog_sendmsg.php",
				type: "post",
				data: {msg:$('#msg').val(),bid:$('#bid').val(),sender:sender,receiver:receiver,korkid:korkid}
			});
			
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// log a message to the console
				
				
					if(response=="Message Sent!"){
						alert('Bid noted');
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



</script>-->



<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="cate_desc">
<div class="header_bg static_top">
  <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
    <?php include 'headers/menu-top-navigation.php';?>
  </header>
  <?php include 'headers/subhead.php' ?>
  <div class="clear"></div>
    
  <div class="submenu_wrap">
    <div class="category_submenu">
      <nav>
        <ul class="topic-list">
          <li><a href="#">Advertising</a></li>
          <li><a href="#">Video &amp; Animation</a></li>
          <li><a href="#">Graphics &amp; Design</a></li>
          <li><a href="#">Programming &amp; Tech</a></li>
          <li><a href="#">Music &amp; Audio</a></li>
          <li><a href="#">Gifts</a></li>
          <li><a href="#">Fun &amp; Bizarre</a></li>
          <li><a href="#">Online Marketing</a></li>
          <li><a href="#">Writing &amp; Translation</a></li>
        </ul>
      </nav>
    </div>
  </div>
</div>
<!--/.header_bg-->
<!-- <article class="header_bg_para">

</article> -->
<div id="backgroundPopup"></div>
<div class="full_article_bg" style="top:140px;">
<div class="kork_desc" style="top:140px;">
  <div class="left_kork">
    <ul class="bxslider">
      <!-- <li>
   					 <iframe src="http://player.vimeo.com/video/17914974" width="610" height="425" frameborder="0" 		webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  				</li> -->
      <li><img src="img/korkImages/<?php echo $image; ?>" /></li>
      <li><img src="img/korkImages/<?php echo $image; ?>" /></li>
    </ul>
  </div>
  <div class="right_kork">
    <h3><?php echo $title;	?></h3>
    <h4> Created <span class="orange"><?php echo $daysPassed > 1 ? "$daysPassed days ago" : ($daysPassed == 0 ? "today" : "$daysPassed day ago");?></span><br>
      in <span class="orange"><?php echo $kork_category; ?> category</span> </h4>
    <p><?php echo $detail; ?></p>
    <?php if($userID != $_userID) { echo "<a href='#' class='btn_signup' data-toggle='modal' data-target='#message'>",($hasBid === true) ? 'Update Bid' : 'Bid Now',"</a>";}?></div>
  <div class="clear"></div>
</div>
<div class="kork_option">
<ul>
<li>
  <div class="first_dt"> <span> <img src="img/users/<?php echo $userPic; ?>" width="50" height="50" alt=""> </span>
    <h2>By <?php echo "<a href='$korkUser'> $korkUser"; ?></a></h2>
    <p>From: <?php echo "$korkCollege (joined ",$joinedAgo > 1 ? "$joinedAgo days ago" : ($joinedAgo == 0 ? "today $joinedAgo" : "$joinedAgo day ago");?>)</p>
  </div>
</li>
<li>
  <div class="second_dt">
    <p>Number of bids: <span><?php echo $bidnum;?></span></p>
  </div>
</li>
<li>
  <div class="third_dt">
    <p>Visitors : <span><?php echo $visitors; ?></span></p>
  </div>
</li>
<li>
  <div class="share_dt">
    <p>Share this</p>
  </div>
  <ul class="share-buttons">
	<li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwalknsell.com%2F&t=WalknSell%20share%20kro%20babes%20%3AP" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="img/Facebook.png"></a></li>
	<li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fwalknsell.com%2F&text=WalknSell%20share%20kro%20babes%20%3AP:%20http%3A%2F%2Fwalknsell.com%2F" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="img/Twitter.png"></a></li>
	<li><a href="https://plus.google.com/share?url=http%3A%2F%2Fwalknsell.com%2F" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="img/Google+.png"></a></li>
</ul>
</li>
</ul>
<div class="clear"></div>
</div>
<?php
	if($userID == $_userID || $hasBid == true){
		echo '<div class="kork_bidding">
				<div class="bidding_header">
					<ul><li>
					<div class="first_dt">
					<h2>Bidders</h2></div></li>

					<li><div class="second_dt">
					<h2>Message</h2>
					</div></li>

					<li><div class="third_dt">
					<h2>Bid</h2>
					</div></li></ul>
				</div>
			</div>';
		try {
			if($userID == $_userID){
				if($bidnum != 0){
					include 'headers/connect_database.php';
					/*** The SQL SELECT statement ***/
					$sql = "SELECT u.username, u.profilePic, i.senderID, i.message, i.bid, i.dateM FROM inbox i INNER JOIN users u ON i.senderID = u.ID WHERE i.korkID = $korkID";
					$result = mysqli_query($con,$sql);
						 
				
					foreach ($dbh->query($sql) as $row)
					{
						$profilePic = $row['profilePic'];
						$sender = $row['username'];
						$senderID = $row['senderID'];
						$message = $row['message'];
						$bid = $row['bid'];
						$bidDate = $row['dateM'];
						
						$now = time(); // or your date as well
						$creationDate = strtotime($bidDate);
						$diff = $now - $creationDate;
						$daysPassed = floor($diff/(60*60*24));
						
						echo "<div class='kork_message'><ul><li><div class='first_dt'> <span> <img src='img/users/$profilePic' width='50' height='50' alt=''> </span>
							<h2><a href='$sender'>$sender</a> (sent ",$daysPassed > 1 ? "$daysPassed days ago" : ($daysPassed == 0 ? "today" : "$daysPassed day ago"),")</h2>
							</div></li>";
						echo "<li><div class='second_dt'>
							 <p>$message</p>
							 </div></li>";
						echo "<li><div class='third_dt'>
							 <p>$$bid</p>
							 </div></li></ul></div>";
					}
					$dbh = null;
				}else{				
				  echo '<div class="first_dt" style="width:100%; text-align:center;">
				  <p>No bids found.</p>
				  </div>';
				}
			}else{
				$message = $userBid['message'];
				$bid = $userBid['bid'];
				$bidDate = $userBid['dateM'];
				
				$now = time(); // or your date as well
				$creationDate = strtotime($bidDate);
				$diff = $now - $creationDate;
				$daysPassed = floor($diff/(60*60*24));
				if($justInserted === true){
					echo "<div class='kork_message alert-notice'><p>Your bid has been submitted. You can update the bid whenever you want bro! :p</p></div>";
				}
				echo "<div class='kork_message'><ul><li><div class='first_dt'><span><img src='img/users/$_profilePic' width='50' height='50' alt=''> </span>
					<h2><a href='$_username'>$_username</a> (sent ",$daysPassed > 1 ? "$daysPassed days ago" : ($daysPassed == 0 ? "today" : "$daysPassed day ago"),")</h2>
					</div></li>";
				echo "<li><div class='second_dt'>
					 <p>$message</p>
					 </div></li>";
				echo "<li><div class='third_dt'>
					 <p>$bid$</p>
					 </div></li></ul></div>";
			}
		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	include 'headers/menu-bottom-navigation.php' ?>
</div>
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h1 class="modal-title" id="myModalLabel"><?php echo ($hasBid === true) ? "Update Bid" : "Bid Now"; ?></h1>
        <p>Please enter your message!</p>
      </div>
      <div class="modal-body">
        <form id="msg-form" method="post" action="cate_desc.php?korkID=<?php echo $korkID; ?>">
          <input type="text" name="msg" id="msg" <?php echo ($hasBid === true) ? "value='{$userBid['message']}'" : ""; ?> class="form-control txt_boxes" placeholder="Enter Your Message" />
          <div style="width:80%;margin-left:30px">
            <table>
              <tr>
                <td ><label>Your Bid</label></td>
                <td><input type="number" name="bid" id="bid" <?php echo ($hasBid === true) ? "value='{$userBid['bid']}'" : ""; ?> style="margin-bottom:0px;padding:0px;width:40%;line-height:1px;height:30px" class="form-control txt_boxes" />
                  </td>
                <td><input type="submit" id="msgsend" style="margin-right:10px" class="btn_signup" value="send" /></td>
              </tr>
            </table>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    
$('.bxslider').bxSlider({
  video: true,
  useCSS: false
});
  });
</script> 
<script>
function getlist(x){
    $(".hidee").hide();
    $("#veiwlist"+x).show();
}
</script> 




<script src="js/nav-admin-dropdown.js"></script>
<script src="js/school-list.js"></script>
</body>
</html>
