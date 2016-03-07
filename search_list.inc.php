<?php
include "headers/connect_database.php";

if(isset($_GET['search_text'])){
	$search_text = $_GET['search_text'];
	$search_mode=$_GET['mode'];





if(!empty($search_text)){
	
	
		 
		  if($search_mode=='register'){
              // $query = "SELECT name,city FROM colleges WHERE name LIKE '%$search_text%' LIMIT 5";

              $split_text=split(" ",$search_text);//Breaking the string to array of words
              // Now let us generate the sql 
              while(list($key,$val)=each($split_text)){
              if($val<>" " and strlen($val) > 0){$result_text .= " name like '$val%' or ";}

              }// end of while
              $result_text=substr($result_text,0,(strLen($result_text)-3));
              // this will remove the last or from the string. 
              $query="SELECT name,city FROM colleges WHERE $result_text LIMIT 5 ";


              $result = mysqli_query($con,$query);
              if(!empty($result)){
                  foreach($result as $query_row){
                    $name = $query_row['name'];
                    $city = $query_row['city'];

                    $name_hypens = str_replace(' ', '-', $name);

                    echo "<li style='cursor:pointer' id='list'> {$name} - {$city} </li>";
                  }
              }else{
                echo "No results found!";
              }
		  }else{
			   // $query = "SELECT ID,name,city FROM colleges WHERE name LIKE '$search_text%' || city LIKE '$search_text%' LIMIT 5 ";


              $split_text=split(" ",$search_text);//Breaking the string to array of words
              // Now let us generate the sql 
              while(list($key,$val)=each($split_text)){
              if($val<>" " and strlen($val) > 0){$result_text .= " name like '$val%' or ";}

              }// end of while
              $result_text=substr($result_text,0,(strLen($result_text)-3));
              // this will remove the last or from the string. 
              $query="SELECT ID,name,city FROM colleges WHERE $result_text LIMIT 5 ";
		  
		  $query_run = mysqli_query($con,$query);
              $count = mysqli_num_rows($query_run);
          if($count >= 1){
			  while($query_row = mysqli_fetch_assoc($query_run)){
                    $name = $query_row['name'];
                    $city = $query_row['city'];
                    $id = $query_row['ID'];
                    $name_hypens = str_replace(' ', '-', $name);

                    //echo "<a href='/WalknSell/school/$name_hypens'><li id='list'> {$name} - {$city} </li></a>";
                    //echo "<li id='unilist'> <a href='#'>$name</a></li>";
                    echo "<li style='cursor:pointer;' id='/{$id}/{$name_hypens}'/' class=''> {$name} - {$city} </li>";
                }

          } else{
                echo "<li id='list'>No results found!</li>";
            }
			  
			  }


}

}

?>
