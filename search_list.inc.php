<?php

if(isset($_GET['search_text'])){
	$search_text = $_GET['search_text'];

if(!empty($search_text)){
	
	if(@mysql_connect('localhost','lolism_korkster','Hemani786!')){
		if(@mysql_select_db('lolism_korkster')){
		  $query = "SELECT * FROM colleges WHERE Name LIKE '$search_text%' || Zip like '$search_text%' || Address like '$search_text%' LIMIT 5 ";
		  
		  $query_run = mysql_query($query);
		  
		  while($query_row = mysql_fetch_assoc($query_run)){
			$name = $query_row['Name'];
			$city = $query_row['City'];
			//$zip = $query_row['Zip'];
			//$address = $query_row['Address'];
			//$state = $query_row['State'];
			
			$name_hypens = str_replace(' ', '-', $name);
			
			echo "<a href='/korkster/school/$name_hypens'><li id='list'> {$name} - {$city} </li></a>";
			//echo "<li id='unilist'> <a href='#'>$name</a></li>";
			
		  }
		  
		}
	}

}

}

?>