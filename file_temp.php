<?php
    
    
    $query_pics  = "select k.*,ki.*, ki.attachment as attachments from `korks` k, `kork_img` ki where k.id = ki.korkID and k.id = 199";
    $result_pics = mysqli_query($con,$query_pics);
    $result_count = mysqli_num_rows($result_pics);
    
    
    
    while($row_image = mysqli_fetch_assoc($result_pics))
    {
     //get an array which has the names of all the files and loop through it 
        
        $obj['name'] = $row_image['attachments']; //get the filename in array
        $obj['size'] = filesize("img/korkImages/".$row_image['attachments']); //get the flesize in array
        $result_temp_array[] = $obj; // copy it to another array
    }
    
       header('Content-Type: application/json');
       echo json_encode($result_temp_array); // now you have a json response which you can use in client side
    
?>