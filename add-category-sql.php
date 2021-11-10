<?php require'connectdb.php'; ?>
<?php extract($_POST) ?>

<?php
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO categories (title, status, created_at) VALUES ('".$title."', '".$status."', '".$date."')";
    if ($conn->query($sql)) {

      if($status == '1'){
          $clr = 'green';
          $status = 'Active';
      }else{
          $clr = 'red';
          $status = 'In-active';
      }
      $datasend = '<tr><td>'.$last_id.'</td><td>'.$title.'</td><td>'.$date.'</td><td style="color:'.$clr.';">'.$status.'</td><td>Edit</td></tr>';
      $last_id++;
      $response = array("response" => "Success","Message" => "Category created","tabledata" => $datasend, "last_id" => $last_id);
    } else {
      $response = array("response" => "Error","Message" => "Category created failed.");
    }
    
    echo json_encode($response);
?>