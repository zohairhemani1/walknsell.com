<?php
	include 'connect_database.php';
    include 'cookie_user.php';

	if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $query = "SELECT *,u.email as useremail FROM users u, colleges c WHERE u.collegeID = c.ID and u.username like '$username'";
		$result = mysqli_query($con,$query);
		while ($row = mysqli_fetch_array($result)){
			$_userID = $row['ID'];
			$_username = $row['username'];
			$_fname = $row['fname'];
			$_fname_uppercase = strtoupper($_fname);
			$_lname = $row['lname'];
			$_lname_uppercase = strtoupper($_lname);
			$_college = $row['collegeID'];
			$_useremail = $row['useremail'];
            $_password = $row['password'];
			$_joinDate = $row['joinDate'];
			$_description = $row['description'];
			$_profilePic = $row['profilePic'];
			$_collegeName=$row['name'];
			$name_hypens = str_replace(' ', '-', $_collegeName);
			$collegeURL="school-category.php?schoolID={$_college}&schoolName={$name_hypens}";
			
			//echo "<script>var collegeURL='${collegeURL}';</script>";
		}
    }
    date_default_timezone_set("Asia/Karachi"); 

    /* General rules and functions */
    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        /*if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';*/
        if ($n > 1000000) return round(($n/1000000), 2).'M';
        elseif ($n > 1000) return round(($n/1000), 2).'K';

        return number_format($n);
    }
    
        /* END - General rules and functions */
?>