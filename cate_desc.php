<?php
echo $sRoot;
session_start();
	include 'headers/_user-details.php';
	$korkID = $_GET['korkID'];
	//$korkName_Hypens = $_GET['kork'];
	//$korkName = str_replace('-', ' ', $korkName_Hypens);	
	
  	$stmt = $dbh->prepare("SELECT k.*, kc.category, u.username, u.profilePic, u.joinDate, c.name, c.city FROM korks k INNER JOIN kork_categories kc ON k.catID = kc.cat_id INNER JOIN users u ON k.userID = u.ID INNER JOIN colleges c ON k.collegeID = c.id WHERE k.id = :korkid");
    $stmt->bindParam(':korkid', $korkID);
    $stmt->execute();
    $result = $stmt->fetchAll();
	$row = $result[0];
    $publish = $row['publish'];
    if(empty($row) || $publish == "0"){
        header("Location: /404");
        die();
    }
	if(!empty($_SESSION['username']) && $row['userID'] != $_userID){
		$dbh->exec("UPDATE korks SET visitors=visitors+1 WHERE id=$korkID");
		$visitors = $row['visitors']+1;
	}else{
		$visitors = $row['visitors'];
	}

    $id  = $row['id'];
	$title = $row['title'];
    $title_url = str_replace(' ', '-', $title);
	$detail = $row['detail'];
	$status = $row['status'];
	$username = $row['username'];
    $kork_price = $row['price'];    
	$kork_category = $row['category'];
	$dateOfCreation = $row['expirydate'];
    $collegeID = $row['collegeID'];
    
        
    //fetching bid results
    $bid_query = "SELECT count(ID) as bidCount from inbox where korkID = $korkID"
        or die('error1');
    $bid_result = mysqli_query($con,$bid_query)
        or die('error2');
    while($row_count = mysqli_fetch_assoc($bid_result)){
        $bidCount = $row_count['bidCount'];
    }   
    // Selecting deal sold person name

    if($status == "0"){
    $stmt = $dbh->prepare("SELECT u.username,k.price FROM kork_sell k,users u where u.id = k.userID and korkID = $korkID");
    $stmt->bindParam(':korkid', $korkID);
    $stmt->execute();
    $result_username = $stmt->fetchAll();
	$row_username = $result_username[0];
    $user_name = $row_username['username'];
    $price = $row_username['price'];    
    
    }


	
	/* Checking to see how many days have passed since the gig created */
	
	/*$now = time(); // or your date as well
    $dateOfCreation = strtotime($dateOfCreation);
    $datediff = $now - $dateOfCreation;
    $daysPassed = floor($datediff/(60*60*24));*/
	function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
	if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
	
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
	/*$userDate = strtotime($userDate);
    $datediff_user = $now - $userDate;
    $joinedAgo = floor($datediff_user/(60*60*24));*/

	
	/** Bids **/
	$stmt = $dbh->prepare("SELECT count(ID) FROM inbox WHERE korkID = :korkid");
	$stmt->bindParam(':korkid', $id);
	$stmt->execute();
		
	$result = $stmt->fetchAll();
	$bidnum=$result[0][0];
	$stmt = $dbh->prepare("SELECT message, bid, dateM FROM inbox WHERE korkID = :korkid AND senderID = :userid " );
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
			$query = "UPDATE inbox SET message = :message, bid = :bid, isRead = 0, dateM = :dateM WHERE korkID = :korkID AND senderID = :senderID";
			$sth = $dbh->prepare($query);
			$sth->bindValue(':korkID',$id);
			$sth->bindValue(':senderID',$_userID);
			$sth->bindValue(':message',$message);
			$sth->bindValue(':bid',$bid);
            $sth->bindValue(':dateM',date('Y/m/d H:i:s'));
		}
		$sth ->execute();
		//updating php variables.
		$hasBid = true;
		$userBid['message'] = $message;
		$userBid['bid'] = $bid;
		$userBid['dateM'] = date('Y/m/d H:i:s');
	}
	
	//fetching all kork images
	$stmt = $dbh->prepare("SELECT attachment FROM kork_img WHERE korkID=:korkID");
	$stmt->bindParam(':korkID', $id);
	$stmt->execute();
	$korkImages = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!-- for Google -->
<meta name="description" content="<?php echo $detail; ?>" />
<meta name="keywords" content="" />

<meta name="author" content="" />
<meta name="copyright" content="" />
<meta name="application-name" content="" />

<!-- for Facebook -->          
<meta property="og:title" content="<?php echo $title;?> | WalknSell" />
<meta property="og:type" content="Product" />
<meta property="og:image" content="<?php echo "http://walknsell.com/img/korkImages/".$korkImages[0]?>" />
<meta property="og:url" content="<?php echo "http://walknsell.com".$_SERVER['REQUEST_URI']?>" />
<meta property="og:description" content="<?php echo $detail; ?>" />

<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php echo $title;?> | WalknSell" />
<meta name="twitter:description" content="<?php echo $detail; ?>" />
<meta name="twitter:image" content="<?php echo "http://walknsell.com/img/korkImages/".$korkImages[0]?>" />
<meta property="twitter:url" content="<?php echo "http://walknsell.com".$_SERVER['REQUEST_URI']?>" />
    
<title><?php echo $title ?> | WalknSell</title>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css" type="text/css">
<link rel="stylesheet" href="/css/jquery.bxslider.css" type="text/css">
<link rel="stylesheet" href="/css/media.css" type="text/css">
<link rel="stylesheet" href="/css/fontello.css" type="text/css">
<link rel="stylesheet" href="/css/jquery.sidr.dark.css" type="text/css">
<link href='/css/font-open-sans.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/font-awesome.css" type='text/css'>
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
var price = $kork_price;
</script>";

?>

<script src="/js/modern.js"></script>
<script src="/js/jquery-1.10.2.min.js"></script>

<script src="/js/jquery.fitvids.js"></script>
<script src="/js/jquery.bxslider.js"></script>
<script src="/js/jquery.sidr.min.js"></script>
<script src="/js/custom.js"></script>
<!-- <script src="/js/fb.js"></script> -->
<script src="/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
/*
$(document).ready(function() {
   $(window).bind('scroll', function(e){
	   parallax();
	  });
});

function parallax(){
	var scrollposition = $(window).scrollTop();
	$('article.header_bg_para').css('top',(0-(scrollposition * 0.2))+'px');
	$('.full_article_bg').css('top',(0-(scrollposition * 1.1))+'px');
	}*/
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
<div class="header_bg">
  <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
    <?php include 'headers/menu-top-navigation.php';?>
  </header>
    </div>
  <?php 
    if(isset($_SESSION['username'])){
    include 'headers/subhead.php'; }
    ?>
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
<!--/.header_bg-->
<!-- <article class="header_bg_para">

</article> -->
<?php include 'headers/popup.php';?>
<div class="full_article_bg">
<div class="kork_desc">
  <div class="left_kork">
    <ul class="bxslider">
      <!-- <li>
   					 <iframe src="http://player.vimeo.com/video/17914974" width="610" height="425" frameborder="0" 		webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  				</li> -->
	<?php
		foreach($korkImages as $img){
			echo "<li><img src='/img/korkImages/$img' /></li>";
		}
	?>
    </ul>
  </div>
  <div class="right_kork">
    <h3 style="word-wrap: break-word;"><?php echo $title;	?></h3>
    <h4>in <span class="orange"> <?php echo $kork_category ;//$daysPassed > 1 ? "$daysPassed days ago" : ($daysPassed == 0 ? "today" : "$daysPassed day ago");?> category</span><br>
        Created <span class="orange"><?php echo time_elapsed_string($dateOfCreation) ?></span><br><br><span class="l_bold">PRICE <span class="orange">Rs. <?php echo $kork_price; ?></span></span> </h4>
    <p style="word-wrap: break-word;"><?php echo $detail; ?></p>
    <?php
    if($status == "1"){
if(!empty($_SESSION['username']) && $userID != $_userID && $collegeID == $_college) { echo "<a href='#' class='btn_signup' data-toggle='modal' data-target='#message'>",($hasBid === true) ? 'Update Bid' : 'Bid Now',"</a>";}
       if (empty($_SESSION['username'])){ echo "<a href='#' id='login_error' class='btn_signup'>Bid Now</a>"; }
        if (!empty($_SESSION['username']) && $userID == $_userID && $bidCount == 0){ echo "<a class='btn_signup' href='/manage_deals/$title_url/$korkID'>Update Deal</a>";}
        else if($userID == $_userID && $bidCount != 0){echo "<span class='btn_signup' data-toggle='modal' data-target='#sell'>Sell Deal</span>";}
    }
      else{
        echo "<span class='sold_deal'><img src='/img/soldOut.png'></span>";
      }
        
      ?></div>
    <p class="btn_para" ><img src="/img/wait.GIF" /></p>
  <div class="clear"></div>
</div>
<div class="kork_option">
<ul>
<li>
  <div class="first_dt"> <span> <img src="/img/users/<?php echo $userPic; ?>" width="50" height="50" alt=""> </span>
    <h2>By <?php echo "<a href='/$korkUser'> $korkUser </a>"; ?></h2>
    <p> <?php //echo "$korkCollege (joined ",$joinedAgo > 1 ? "$joinedAgo days ago" : ($joinedAgo == 0 ? "today $joinedAgo" : "$joinedAgo day ago");
					echo $korkCollege; ?></p>
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
  <div class="share_dt"><span>
      <p>Share this</p></span>
  
  <ul class="share-buttons">
	<!--<li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwalknsell.com<?php echo urlencode($_SERVER['REQUEST_URI']);?>&t=<?php echo $title; ?>" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="img/Facebook.png"></a></li>
<li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fwalknsell.com%2F&text=WalknSell%20share%20kro%20babes%20%3AP:%20http%3A%2F%2Fwalknsell.com%2F" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="img/Twitter.png"></a></li>-->
      <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwalknsell.com<?php echo urlencode($_SERVER['REQUEST_URI']);?>" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL)); return false;"><img src="/img/Facebook.png"></a></li>
	<li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fwalknsell.com<?php echo urlencode($_SERVER['REQUEST_URI']);?>:%20http%3A%2F%2Fwalknsell.com%2F" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/share?text=Hello there! Check out my deal on WalknSell.&url=' + encodeURIComponent(document.URL)); return false;"><img src="/img/Twitter.png"></a></li>
	<li><a href="https://plus.google.com/share?url=http%3A%2F%2Fwalknsell.com<?php echo urlencode($_SERVER['REQUEST_URI']);?>" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="/img/Google+.png"></a></li>
</ul>
      </div>
</li>
</ul>
<div class="clear"></div>
</div>
<?php
	if($userID == $_userID || $hasBid == true){
		/*echo '<div class="kork_bidding">
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
			</div>';*/
		try {
          if($status == "0"){
          echo "<div class='first_dt' style='width:100%; text-align:center;'>
          <p>This Deal has been sell to $user_name in $price Rs</p>
          </div>";                    
            }
			if($userID == $_userID){
				if($bidnum != 0){
                    echo "<div id='no-more-tables' class='bid_wrapper'>
            <table class='table-bordered table-striped table-condensed cf kork_bid'>
                <thead class='cf bid_header'>
                    <tr>
                        <th style='width: 35%;'>Bidders</th>
                        <th style='width: 42%;'>Message</th>
                        <th class='numeric' style='width: 22%;'>Bid</th>
                    </tr>
                </thead>
                <tbody>";
                    
					include 'headers/connect_database.php';
					/*** The SQL SELECT statement ***/
					$sql = "SELECT u.username, u.profilePic, i.senderID, i.message, i.bid, i.dateM FROM inbox i INNER JOIN users u ON i.senderID = u.ID WHERE i.korkID = $korkID";
					$result = mysqli_query($con,$sql);
						 
				
					foreach ($dbh->query($sql) as $row){
						$profilePic = $row['profilePic'];
						$sender = $row['username'];
						$senderID = $row['senderID'];
						$message = $row['message'];
						$bid = $row['bid'];
						$bidDate = $row['dateM'];
                    
						echo "<tr><td data-title='Bidders'><div class='first_dt'><span><img src='/img/users/$profilePic' width='50' height='50'></span>
                    <h2><a href='/$sender'>$sender</a> (",time_elapsed_string($bidDate),")</h2>
                    </div></td>";
						echo "<td data-title='Message'>$message</td>";
						echo "<td data-title='Bid' class='numeric'>Rs. ".$bid."</td></tr>";
					}
					$dbh = null;
                    echo "</tbody></table></div>";
				}else{				
				  echo '<div class="first_dt" style="width:100%; text-align:center;">
				  <p>No bids found.</p>
				  </div>';
				}
			}else{
				$message = $userBid['message'];
				$bid = $userBid['bid'];
				$bidDate = time_elapsed_string($userBid['dateM']);
                
                echo "<div id='no-more-tables' class='bid_wrapper'>
                <table class='table-bordered table-striped table-condensed cf kork_bid'>
                <thead class='cf bid_header'>
                    <tr>
                        <th style='width: 35%;'>Bidders</th>
                        <th style='width: 42%;'>Message</th>
                        <th class='numeric' style='width: 22%;'>Bid</th>
                    </tr>
                </thead>
                <tbody>";
				
                if($justInserted === true){
					echo "<tr class='kork_message alert-notice'><p>Your bid has been submitted. You can update the bid anytime later.</p></tr>";
				}
				echo "<tr><td data-title='Bidders'><div class='first_dt'><span><img src='/img/users/$_profilePic' width='50' height='50'></span>
                    <h2><a href='/$_username'>$_username</a> ( $bidDate)</h2>
                    </div></td>";
                echo "<td data-title='Message'>$message</td>";
                echo "<td data-title='Bid' class='numeric'>Rs ".$bid."</td></tr></tbody></table></div>";
			}
		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	//include 'headers/menu-bottom-navigation.php' ?>
    <!--<div class="container">
    <div class="row">
        <div id="no-more-tables" style="width: 1018px; margin: 10px auto;">
            <table class="table-bordered table-striped table-condensed cf kork_bid">
                <thead class="cf bid_header">
                    <tr>
                        <th style="width: 35%;">Bidders</th>
                        <th style="width: 42%;">Message</th>
                        <th class="numeric" style="width: 22%;">Bid</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="Bidders"><div class="first_dt"><span><img src="/img/users/profile_pic.jpg" width="50" height="50" alt=""> </span>
                    <h2><a href="ShahrukhS">ShahrukhS</a> (sent today)</h2>
                    </div></td>
                        <td data-title="Message">AUSTRALIAN AGRICULTURAL COMPANY LIMITED.</td>
                        <td data-title="Bid" class="numeric">$1.38</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>-->
</div>
    
<!--pop up box for sell deal start here-->
    
       <div class="modal fade" id="sell" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
          <h1 class="modal-title" id="myModalLabel">WalknSell Sell Deal</h1>
          <p>Fill all item given below to sell your deal</p>
        </div>
        <div class="modal-body">
          <form id="contact-form" action="/soldKork.php?id=<?php echo $korkID ?>" method="post">
            <div id="error-login"></div>
            <select required name='userID' id="sellusername" class="form-control txt_boxes contact-form" onChange="getPrice(this.value);">
                <option value="Select Buyer Name">Select Buyer Name</option>
            <?php 
            $query_bid = "SELECT u.username,i.senderID FROM inbox i INNER JOIN users u ON i.senderID = u.ID WHERE i.bid > 0 and i.korkID = $korkID";
            $result_bid = mysqli_query($con,$query_bid);
            while($row_bid = mysqli_fetch_array($result_bid)){
            $username = $row_bid['username'];
            $sender_id = $row_bid['senderID'];    
            echo "<option value='$sender_id'>$username</option>";                        
            }
            ?>
            </select>  
            <input type="number" max="<?php echo $kork_price ?>" readonly="true" class="form-control txt_boxes contact-form" id="bid" placeholder="Deal Sell Price" name="price" required= "true">
            <div id="loading-contact" class="genload"></div>
            <input type="submit" id="soldDeal" class="btn_signup" value="Sell"/>
         </form>
          <div class="clearfix"></div>
        </div>
       
      </div>
    </div>
  </div>  
    
  <!--pop up box for sell deal end here-->  
    
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
        <h1 class="modal-title" id="myModalLabel"><?php if($hasBid == true) { echo "Update Bid"; } else{echo "Bid Now";}  ?></h1>
      </div>
      <div class="modal-body">
        <form id="msg-form" method="post" action="<?php echo "/$username/$title_url/$id" ; ?>">
          <input required maxlength="100"  type="text" name="msg" id="msg" <?php echo ($hasBid === true) ? "value='{$userBid['message']}'" : ""; ?> class="form-control txt_boxes" placeholder="Enter Your Message" />
          <div style="width:80%;margin-left:30px">
            <table>
              <tr>
                <td style="width:20%;"><label>Your Bid:</label></td>
                <td><input required type="number" style="width:93px;" min="1" max="<?php echo $kork_price ?>" name="bid" id="bid" <?php echo ($hasBid === true) ? "value='{$userBid['bid']}'" : ""; ?> class="form-control modal-bid" />
                  </td>
                <td><input type="submit" id="msgsend" style="margin-right:10px" class="btn_signup" 
                           value='<?php echo ($hasBid === true) ? "Update" : "Send";  ?>' /></td>
              </tr>
            </table>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
</div>
  
    <?php include 'headers/menu-bottom-navigation.php' ?>

    
    
<!--
<script>
    function sold(){
 var result = confirm("Once you click ok then you will not be able to UnSold, and will have to create a new Deal");

        if (result) {
        $('.btn_para').css('display','block');    
$.ajax({ url: 'soldKork.php?id=<?php echo $korkID ?>',
         data: {action: ''},
         type: 'post',
         success: function(output) {
         window.location.reload(true);
                  }
});
}
        else{
                $('.btn_para').css('display','none');   
        }
    }
    
</script>    
-->
<script>
function getPrice(val) {
	$.ajax({
	type: "POST",
	url: "/get_price.php?korkID=<?php echo $korkID ;?>",
	data:'senderID='+val,
	success: function(data){
		$("#bid").val(data);
            $('input[type="number"]').keyup(function(){
	    if($("#bid").val() > data){
		$(this).val(data);
       return false;
		}
            });
    }
	});
}
</script>
<script src ="/js/register.js"></script>
    <script>
        $('#login_error').click(function() {
            $('#login').modal('toggle');
            
        });
        
        
    </script>
    <script>
    $('input[type="number"]').keyup(function(){
        var scream = this.value;
        if ( scream.charAt( 0 ) == '0' ) {
            alert('You cannot start your bid at 0');
        document.getElementById('bid').focus();
        document.getElementById("bid").value = "";
        }
        else if ( scream.charAt( 0 ) == '-' ) {
        alert('Sorry you cant add your bid price in negative number');
        document.getElementById('bid').focus();
        document.getElementById("bid").value = "";        
        }
        if($(this).val() > price){
		$(this).val(price);
       return false;
		}
        });
</script>
<script>
$( '#soldDeal').click(function() {
        if($("#sellusername option:selected" ).text() == 'Select Buyer Name')
        {
		$('.genload').css("padding-top", "20px");
		$('.genload').css("padding-bottom", "20px");
		$('.genload').html('<span class=\'alert alert-danger\'><strong>Oops! </strong>Please Select any username to sell your Deal</strong></span>');
		return false;    
        }
});
</script>
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
<script src="/js/nav-admin-dropdown.js"></script>
<script src="/js/school-list.js"></script>
<script>
	$(document).ready(function() {
	$("#bid").keyup(function(){
		if($(this).val() > price){
			$(this).val(price);
            return false;
		}
	});
	});
</script>
</body>
</html>
