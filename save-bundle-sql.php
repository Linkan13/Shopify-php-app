<?php require'connectdb.php'; ?>

<?php
    
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $created_by = $_POST['created_by'];
  
    if(!isset($_POST['is_featured'])) {
        $is_featured = '0';
    }else{
        $is_featured = '1';
    }

    $date = date('Y-m-d H:i:s');
    $multiselect = serialize($_POST['check']);
    $quotes = serialize($_POST['quotes']);
    $tag_lines = serialize($_POST['tag_lines']);
    
    $strtotime = strtotime("now");
    $filename = $strtotime.'_'.$_FILES['bundleImage']['name'];
    $filenametwo = $strtotime.'_'.$_FILES['creatorImage']['name'];




    if(is_uploaded_file($_FILES['bundleImage']['tmp_name']) && is_uploaded_file($_FILES['creatorImage']['tmp_name'])) {
      $sourcePath = $_FILES['bundleImage']['tmp_name'];
      $targetPath = "assets/bundleimages/".$filename;
      $sourcePathtwo = $_FILES['creatorImage']['tmp_name'];
      $targetPathtwo = "assets/creatorimages/".$filenametwo;
      if(move_uploaded_file($sourcePath,$targetPath) && move_uploaded_file($sourcePathtwo,$targetPathtwo)) {
        $sql = "INSERT INTO bundle_products (created_by, creator_img, bundl_img, title, tag_lines, is_featured, description, category, quotes, products_array, status, created_at) VALUES ('".$created_by."','".$filenametwo."','".$filename."', '".$title."', '".$tag_lines."', '".$is_featured."', '".$description."', '".$category."', '".$quotes."', '".$multiselect."', '".$status."', '".$date."')";
        if ($conn->query($sql)) {
          $response = array("response" => "Success","Message" => "Bundle created");
        } else {
          $response = array("response" => "Error","Message" => "Bundle created failed.");
        }
      }
    }
    
    echo json_encode($response);
?>