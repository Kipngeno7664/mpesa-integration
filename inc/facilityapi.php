<?php 
// Include the database config file 
include_once 'config.inc.php'; 
 
if(!empty($_POST["institution"])){ 
    // Fetch state data based on the specific country 
    $query = "SELECT * FROM geozone  WHERE countyid = ".$_POST['institution']." ORDER BY id ASC"; 
    $result = $db->query($query); 
     
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select goezone</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value=""> no available geozones</option>'; 
    } 
}elseif(!empty($_POST["facility"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT * FROM sensor WHERE geozoneid = ".$_POST['facility']." ORDER BY number ASC";
    $result = $db->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select sensor</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">sensor not available</option>'; 
    } 
}elseif(!empty($_POST["meter"])){ 
    
    $sqlQuery = "SELECT * FROM ".$_POST['meter'];
   

    $result = mysqli_query($db, $sqlQuery);
    
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    mysqli_close($db);
    
    echo json_encode($data);


}

?>