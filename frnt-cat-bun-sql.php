<?php require'connectdb.php'; ?>

<?php
    $sql = $conn->query("SELECT * FROM bundle_products limit 10");
    if (mysqli_num_rows($sql)!=0){
      $senddata = array();
      while ($row = mysqli_fetch_assoc($sql))  
      {
        array_push($senddata,$row['id']);
      }
      $response = array("response" => "Error","send_data" => $senddata);
    }else{
      $response = array("response" => "Error","Message" => "No data");
    }  

    echo json_encode($response);
?>