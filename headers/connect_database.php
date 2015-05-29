<?php

$db_host = "localhost"; 

$db_username = "root";  

$db_pass = "";  

$db_name = "korkster"; 

// Run the connection here  

$con = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name");

$dbh = new PDO("mysql:host=$db_host; dbname=$db_name", $db_username, $db_pass);   

?>