<?php require'connectdb.php'; ?>

<?php

    
    $id = $_POST['id'];
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

    if(empty($_FILES['bundleImage']['name']) || empty($_FILES['creatorImage']['name'])){
          if(empty($_FILES['bundleImage']['name']) && !empty($_FILES['creatorImage']['name'])){
            $filenametwo = $strtotime.'_'.$_FILES['creatorImage']['name'];
            if(is_uploaded_file($_FILES['creatorImage']['tmp_name'])) {
              $sourcePathtwo = $_FILES['creatorImage']['tmp_name'];
              $targetPathtwo = "assets/creatorimages/".$filenametwo;            
              if(move_uploaded_file($sourcePathtwo,$targetPathtwo)) {
                $sql = "UPDATE bundle_products SET creator_img='".$filenametwo."', created_by='".$created_by."', tag_lines='".$tag_lines."', title='".$title."', is_featured='".$is_featured."',description = '".$description."', category = '".$category."', quotes = '".$quotes."', products_array = '".$multiselect."', status = '".$status."' , updated_at = '".$date."' WHERE id = '".$id."'";
              }
            }
          }else if(empty($_FILES['creatorImage']['name']) && !empty($_FILES['bundleImage']['name']) ){
            $filename = $strtotime.'_'.$_FILES['bundleImage']['name'];
            if(is_uploaded_file($_FILES['bundleImage']['tmp_name'])) {
              $sourcePath = $_FILES['bundleImage']['tmp_name'];
              $targetPath = "assets/bundleimages/".$filename;           
              if(move_uploaded_file($sourcePath,$targetPath)) {
                $sql = "UPDATE bundle_products SET bundl_img='".$filename."', created_by='".$created_by."', tag_lines='".$tag_lines."', title='".$title."', is_featured='".$is_featured."',description = '".$description."', category = '".$category."', quotes = '".$quotes."', products_array = '".$multiselect."', status = '".$status."' , updated_at = '".$date."' WHERE id = '".$id."'";
              }
            }
          }else{
            $sql = "UPDATE bundle_products SET created_by='".$created_by."', tag_lines='".$tag_lines."', title='".$title."', is_featured='".$is_featured."',description = '".$description."', category = '".$category."', quotes = '".$quotes."', products_array = '".$multiselect."', status = '".$status."' , updated_at = '".$date."' WHERE id = '".$id."'"; 
          }

            if ($conn->query($sql)) {
              $response = array("response" => "Success","Message" => "Bundle updated");
            } else {
              $response = array("response" => "Error","Message" => "Bundle updatation failed.");
            }

    }else{
          $filename = $strtotime.'_'.$_FILES['bundleImage']['name'];
          $filenametwo = $strtotime.'_'.$_FILES['creatorImage']['name'];

          if(is_uploaded_file($_FILES['bundleImage']['tmp_name']) && is_uploaded_file($_FILES['creatorImage']['tmp_name'])) {
            $sourcePath = $_FILES['bundleImage']['tmp_name'];
            $targetPath = "assets/bundleimages/".$filename;
            $sourcePathtwo = $_FILES['creatorImage']['tmp_name'];
            $targetPathtwo = "assets/creatorimages/".$filenametwo;            
            if(move_uploaded_file($sourcePath,$targetPath) && move_uploaded_file($sourcePathtwo,$targetPathtwo)) {

              $sql = "UPDATE bundle_products SET created_by='".$created_by."', bundl_img='".$filename."', creator_img='".$filenametwo."', tag_lines='".$tag_lines."', title='".$title."', is_featured='".$is_featured."',description = '".$description."', category = '".$category."', quotes = '".$quotes."', products_array = '".$multiselect."', status = '".$status."' , updated_at = '".$date."' WHERE id = '".$id."'";

              if ($conn->query($sql)) {
                $response = array("response" => "Success","Message" => "Bundle updated");
              } else {
                $response = array("response" => "Error","Message" => "Bundle updatation failed.");
              }
            }
          }
    }
  
    
    echo json_encode($response);
?>