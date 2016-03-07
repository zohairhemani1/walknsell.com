<?php
	include 'headers/connect_database.php';
if($_POST)
{
    $id = $_POST['id'];
    $query = "DELETE FROM `kork_img` WHERE `attachment` = '$id'"
    or die('error when deleting kork images');
    $result = mysqli_query($con,$query);    
}
    ?>