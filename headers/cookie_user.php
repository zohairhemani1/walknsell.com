<?php
	
	$cookie = $_COOKIE['remember'];
	
	if(isset($cookie))
	{
		include 'connect_database.php';
		$query_cookie = "SELECT * FROM users WHERE cookie like '$cookie' ";
		$result_cookie = mysqli_query($con,$query_cookie);
		$row_cookie = mysqli_fetch_array($result_cookie);
		if(mysqli_num_rows($result_cookie)==1)
		{
			$username = $row_cookie['username'];
		}
		
		
		
	}
?>