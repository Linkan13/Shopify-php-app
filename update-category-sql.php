<?php require'connectdb.php'; ?>
<?php extract($_POST) ?>

<?php
    $date = date('Y-m-d H:i:s');

    $sql = "UPDATE categories SET title='".$utitle."', status = '".$ustatus."' , updated_at = '".$date."' WHERE id = '".$uid."'";

    if ($conn->query($sql)) {
      $response = array("response" => "Success","Message" => "Category update");
    } else {
      $response = array("response" => "Error","Message" => "Category update failed.");
    }
    
    echo json_encode($response);
?>