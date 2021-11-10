<?php require'connectdb.php'; ?>

<?php

    $id = $_POST['id'];

    if(!empty($id)){
      $sql = "DELETE FROM bundle_products WHERE id= '".$id."'";
      if ($conn->query($sql)) {
        $response = array("response" => "Success","Message" => "Bundle deleted", "bundleid" => $id);
      } else {
        $response = array("response" => "Error","Message" => "Bundle deletion failed.");
      }
    }else {
        $response = array("response" => "Error","Message" => "Something went wrong");
      }
  
    
    echo json_encode($response);
?>