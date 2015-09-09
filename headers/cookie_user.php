<?php
    if(isset($_COOKIE['walknsell_remember']) === true && isset($_SESSION['username']) === false){
        $cookie = $_COOKIE['walknsell_remember'];
		$query_cookie = "SELECT username FROM users WHERE cookie like '$cookie' ";
		$result_cookie = mysqli_query($con,$query_cookie);
		$row_cookie = mysqli_fetch_array($result_cookie);
		if(mysqli_num_rows($result_cookie)==1)
		{
            echo $row_cookie['username'];
			$_SESSION['username'] = $row_cookie['username'];
		}
	}
?>