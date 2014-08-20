<?php


	
	
		if(isset($_SESSION['username']))
		{
		$username = $_SESSION['username'];
		include 'connect_database.php';
		$query = "SELECT * FROM users u, colleges c WHERE u.collegeID = c.ID and u.username like '$username'";
		$result = mysqli_query($con,$query);
		
		while ($row = mysqli_fetch_array($result)){
			$_userID = $row['ID'];
			$_username = $row['username'];
			$_fname = $row['fname'];
			$_fname_uppercase = strtoupper($_fname);
			$_lname = $row['lname'];
			$_lname_uppercase = strtoupper($_lname);
			$_college = $row['collegeID'];
			$_email = $row['email'];
			$_password = $row['password'];
			$_joinDate = $row['joinDate'];
			$_profilePic = $row['profilePic'];
			$_collegeName=$row['name'];
			$name_hypens = str_replace(' ', '-', $_collegeName);
			$collegeURL="school-category.php?schoolID={$_college}&schoolName={$name_hypens}";
echo "<script>
var collegeURL='${collegeURL}';
</script>";
		}
		}
		
?>