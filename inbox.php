<?php
session_start();
include 'headers/_user-details.php';
	if(isset($_GET['username'])){
		$usernmae = $_GET['username'];
	} 
    if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
        (!empty($_SERVER['QUERY_STRING'])) ? header("Location: inbox.php?type={$_SERVER['QUERY_STRING']}&page=$page") : header("Location: inbox.php?page=$page");
	}
	$perpage = 10;
	$start = (($page - 1)*$perpage);

    //$myurl = basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'];
	/*marking checked message*/
	if (isset($_GET['action'])){
		if (isset($_POST['allChecks'])){
			$allChecks = implode(',', $_POST['allChecks']);
			switch($_GET['action']){
				case 'archive':
					$sql = "Update inbox set isArchive = 1 where ID IN ($allChecks)";
					$dbh->exec($sql);
				break;
                case 'unarchive':
                    $sql = "Update inbox set isArchive = 0 where ID IN ($allChecks)";
					$dbh->exec($sql);
				break;
				case 'read':
					$sql = "Update inbox set isRead = 1 where ID IN ($allChecks)";
					$dbh->exec($sql);
				break;
				case 'unread':
					$sql = "Update inbox set isRead = 0 where ID IN ($allChecks)";
					$dbh->exec($sql);
				break;
			}
			
		}
	}
	
	if(isset($_GET['type'])){
		$type = $_GET['type'];
		if($type=='archive'|| $type=='unarchive'){
            $temp=($type=='unarchive') ? 0 : 1;
			$stmt = $dbh->prepare("SELECT COUNT(ID) FROM inbox WHERE isArchive = :isarch and ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`)");
            $stmt->bindParam(':isarch', $temp);
			$stmt->bindParam(':user', $_userID);
			$stmt->execute();
			$records = $stmt->fetch(); $records = $records[0];
			$pages = ceil($records[0]/$perpage);
			
            if(isset($_GET['query']) && !empty($_GET['query'])){
            $query = '%'.$_GET['query'].'%';
            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`, i.ID, i.isRead,i.message, i.dateM, u.profilePic,u.username, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE (i.message LIKE :search OR u.lname LIKE :search OR u.fname LIKE :search) AND i.isArchive = :isarch and i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
			$stmt->bindParam(':user', $_userID);
            $stmt->bindParam(':isarch', $temp);
            $stmt->bindParam(':search', $query);
            $stmt->execute();
            }else{
			$stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`, i.ID, i.isRead, i.message, i.dateM, u.profilePic, u.fname,u.username, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE i.isArchive = :isarch and i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
			$stmt->bindParam(':user', $_userID);
            $stmt->bindParam(':isarch', $temp);
			$stmt->execute();
            }
		}else if($type=='starred' || $type=='unstarred'){
			$temp=($type=='unstarred') ? 0 : 1;
			$stmt = $dbh->prepare("SELECT COUNT(ID) FROM inbox WHERE isStarred = :isStarred and ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`)");
			$stmt->bindParam(':user', $_userID);
			$stmt->bindParam(':isStarred', $temp);
			$stmt->execute();
			$records = $stmt->fetch(); $records = $records[0];
			$pages = ceil($records[0]/$perpage);
			
            if(isset($_GET['query']) && !empty($_GET['query'])){
            $query = '%'.$_GET['query'].'%';

            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`, i.ID, i.message,i.isRead, i.dateM, u.profilePic,u.username, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE (i.message LIKE :search OR u.lname LIKE :search OR u.fname LIKE :search) AND i.isStarred = :isStarred and i.isArchive = 0 and i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
            $stmt->bindParam(':user', $_userID);
            $stmt->bindParam(':isStarred', $temp);
            $stmt->bindParam(':search', $query);
            $stmt->execute();
            }else{
            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`, i.isRead,i.ID, i.message, i.dateM, u.profilePic, u.fname,u.username, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE i.isStarred = :isStarred and i.isArchive = 0 and i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
            $stmt->bindParam(':user', $_userID);
            $stmt->bindParam(':isStarred', $temp);
            $stmt->execute();
            }
		}else if($type=='read' || $type=='unread'){
			$readS=($type=='unread') ? 0 : 1;
			$stmt = $dbh->prepare("SELECT COUNT(ID) FROM inbox WHERE isRead = :isRead and ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`)");
			$stmt->bindParam(':user', $_userID);
			$stmt->bindParam(':isRead', $readS);
			$stmt->execute();
			$records = $stmt->fetch();$records = $records[0];
			$pages = ceil($records[0]/$perpage);
			
			/*$stmt = $dbh->prepare("SELECT i.senderID,i.message,i.dateM,u.profilePic,u.fname,u.lname FROM inbox i INNER JOIN users u ON i.senderID = u.ID WHERE i.receiverID = :user and i.isRead =:isread and i.ID IN (select max(ID) FROM inbox GROUP BY senderID) LIMIT $start, $perpage");*/
            if(isset($_GET['query']) && !empty($_GET['query'])){
            $query = '%'.$_GET['query'].'%';

            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`,i.isRead, i.ID, i.message, i.dateM, u.profilePic,u.username, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE (i.message LIKE :search OR u.lname LIKE :search OR u.fname LIKE :search) AND i.isRead = :isRead AND i.isArchive = 0 AND i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
			$stmt->bindParam(':user', $_userID);
			$stmt->bindParam(':isRead', $readS);
            $stmt->bindParam(':search', $query);
            $stmt->execute();
            }else{
			$stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`,i.isRead, i.ID, i.message, i.dateM, u.profilePic,u.username, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE i.isRead = :isRead and i.isArchive = 0 and i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
			$stmt->bindParam(':user', $_userID);
			$stmt->bindParam(':isRead', $readS);
			$stmt->execute();
            }
        }
    }else{
        $stmt = $dbh->prepare("SELECT count(ID) FROM (Select ID from (SELECT ID, concat(senderID,receiverID) as `ConversationID` FROM inbox WHERE receiverID =:user GROUP BY senderID UNION SELECT ID, concat(receiverID,senderID) as `ConversationID` FROM inbox WHERE senderID=:user GROUP BY receiverID) as b GROUP by `ConversationID`) as i");
		$stmt->bindParam(':user', $_userID);
		$stmt->execute();
		$records = $stmt->fetch(); $records = $records[0];
		$pages = ceil($records[0]/$perpage);
	   	
        if(isset($_GET['query']) && !empty($_GET['query'])){
            $query = '%'.$_GET['query'].'%';

            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`,i.isRead, i.ID, i.message, i.dateM, u.profilePic, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE (i.message LIKE :search OR u.lname LIKE :search OR u.fname LIKE :search) AND i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
            $stmt->bindParam(':user', $_userID);
            $stmt->bindParam(':search', $query);
            $stmt->execute();
        }else{
            $stmt = $dbh->prepare("SELECT (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) as `sender`,i.isRead, i.ID, i.message, i.dateM, u.profilePic,u.username, u.fname, u.lname FROM inbox i INNER JOIN users u ON (CASE WHEN (i.senderID=:user) THEN i.receiverID else i.senderID end) = u.ID WHERE i.ID IN (select max(ID) from (select senderID, receiverID, concat(senderID,receiverID) as `Conversation ID`, max(ID) as `ID` FROM inbox where receiverID = :user GROUP BY senderID union select senderID,receiverID,concat(receiverID,senderID) as `Conversation ID`, max(ID) as `ID` FROM inbox where senderID = :user GROUP BY receiverID) as `tab` group by `Conversation ID`) LIMIT $start, $perpage");
            $stmt->bindParam(':user', $_userID);
            $stmt->execute();
        }
    }
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>::Inbox:</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
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
<script type="text/javascript">
window.onload=function() {
   document.getElementById("btnArchive").onclick=function() {
     var myForm = document.getElementById("myForm");
     myForm.action=this.href;
     myForm.submit();
     return false; // cancel the actual link
   }
    document.getElementById("btnUnarchive").onclick=function() {
    var myForm = document.getElementById("myForm");
    myForm.action=this.href;
    myForm.submit();
    return false; // cancel the actual link
   }
   document.getElementById("btnUnread").onclick=function() {
     var myForm = document.getElementById("myForm");
     myForm.action=this.href;
     myForm.submit();
     return false; // cancel the actual link
   }
   document.getElementById("btnRead").onclick=function() {
     var myForm = document.getElementById("myForm");
     myForm.action=this.href;
     myForm.submit();
     return false; // cancel the actual link
   }
 }
</script>

<script src="js/school-list.js"></script>

</head>

<body>
<div class="wrapper">
	<div class="header_bg">
        <header class="main-header">
        <a id="simple-menu" class="icon-menu" href="#sidr"></a>
           <?php include "headers/menu-top-navigation.php"; ?>
        </header>
        <div class="clear"></div>
    </div><!--/.header_bg-->
<?php include 'headers/popup.php';?>
    <div class="content_inbox">
    	<h1>Inbox</h1>
        <a href="#" class="search_icon"><img src="/img/magnifying.png" width="30" alt="search"></a>
        <div class="content_inbox_inner">
        	<div class="conversation_top">
            	<div class="mail_selector">
                	<div class="dropdown">
                		<a data-toggle="dropdown" href="#"><input type="checkbox" id="mail_select">
                    	<label for="mail_select"><img src="/img/arrow.png" width="14" alt=""></label></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    						<li><a href="/">ALL</a></li>
                            <li><a href="conversation/read">READ</a></li>
                            <li><a href="Conversation/unread">UNREAD</a></li>
							<li><a href="Conversation?type=archive">ARCHIVE</a></li>
                            <li><a href="Conversation?type=unarchive">UNARCHIVE</a></li>
  						</ul>
                    </div>
  		

                </div>
                  <p style="display:none;" class="mark">mark as</p>
                  <div class="btn-group">
        	<div class='div_aside'>
            	<a href='/inbox.php?type=unread&page=<?php echo $page; ?>' class='read_un unread'>unread</a>
		    	<a href='/inbox.php?type=read&page=<?php echo $page; ?>' class='read_un read'>read</a>
                <a href='/inbox.php?page=<?php echo $page; ?>' class='read_un'>All</a>
                <div class='clear'></div>      
            </div>
                  	<a href="Conversation?<?php echo (isset($_GET['type']) == true) ? "type=$type&" : "","action=archive&page=$page" ?>"  id="btnArchive" class="btn_top archive">ARCHIVE</a>
                      <a href="Conversation?<?php echo (isset($_GET['type']) == true) ? "type=$type&" : "","action=unarchive&page=$page" ?>"  id="btnUnarchive" class="btn_top unarchive">UNARCHIVE</a>
                  	<a href="Conversation?<?php echo (isset($_GET['type']) == true) ? "type=$type&" : "","action=unread&page=$page" ?>" id="btnUnread" class="btn_top unread">UNREAD</a>
                  	<a href="Conversation?<?php echo (isset($_GET['type']) == true) ? "type=$type&" : "","action=read&page=$page" ?>" id="btnRead" class="btn_top read">READ</a>
                    <div class="clear"></div>
                  </div>
                    
                  <div id="search-inbox" class="wrap-search">
					<form method="GET" action="inbox.php">
                        <?php
                        foreach($_GET as $name => $value) {
                          $name = htmlspecialchars($name);
                          $value = htmlspecialchars($value);
                          echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
                        }
                        ?>
                        <input id="query" maxlength="80" name="query" type="text" value="<?php echo (isset($_GET['query'])) ? $_GET['query'] : ""; ?>" placeholder="SEARCH">
                        <input type="image" src="/img/glass_small.png" alt="Go">
                    </form>
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
                                        <td class="update_head">UPDATED</td>
                                    </tr>
                                </table>
                            </td>
                    	</tr>
                    </thead>
                    <tbody>
					<form id="myForm" action="" method="POST">
                    <?php
					$count = 0;
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$count++;
						$messageID=$row['ID'];
						$date=$row['dateM'];
						$lastmessage=$row['message'];
						$senderID = $row['sender'];
						$sender = $row['fname'].' '.$row['lname'];
						$profileImg = $row['profilePic'];
                        $Readtrue = $row['isRead'];
                        $senderUsenrname = $row['username'];

						echo "<tr class='",($Readtrue == 0) ? "inbox_unread" : "","'>
							<td class='inbox_mail_row '>
								<table class='ellip'>
                            
									<tr>
										<td style='display:none;' class='checkbox'><input class='msgChecks' type='checkbox' name='allChecks[]' value='$messageID'></td>
										<td class='star'></td>
										<td class='sender_dt'><img src='/img/users/$profileImg' width='42' alt='sender'>${sender}</td>
										<td class='messege_subject'><a href='/conversation/$senderUsenrname/All'>${lastmessage}</a></td>
										<td class='update'>${date}</td>
								   </tr>
								</table>
							</td>
						</tr>" ;
					}
	                ?>
                    </tbody></form>
                </table>
                <p class="summary_para">Showing <?php echo $count.' of '.$records; ?> messages</p>
                <nav style="text-align: center;">
                <ul class="pagination">
                    <li>
                      <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php
                        for($number = 1; $number <= $pages; $number++){
                            echo "<li><a href='Conversation?",(isset($_GET['type']) == true) ? "type=$type&" : "","page=$number'>$number</a></li>";
                        }
                    ?>
                    <li><a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                </ul>
                </nav>
            </div><!--/.main_table-->
        	<div class="clear"></div>
        </div>
        <a href="#" class="load_more_btn">OLDER CONVERSATIONS</a>
        <div class="clear"></div>
        
    </div>
    
    <?php include 'headers/menu-bottom-navigation.php'; ?>

</div>

</body>
</html>