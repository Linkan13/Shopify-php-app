<?php require'../connectdb.php' ?>
<?php require'../inc/functions.php' ?>
<?php extract($_POST) ?>

<?php
    $collectionList = shopify_call($token, $shop, "/admin/api/2020-04/products.json", array(), 'GET');
    $collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
    $collectionList = $collectionList['products'];

    $response = [];
    foreach($collectionList as $collect){ 
        $get_image = $collect['image']['src'];                  
        $title = $collect['title'];
        $id = $collect['id'];
        $desc = $collect['body_html'];

        $response[] = "<option value=".$id.">".$title."</option>";
    }


    echo json_encode($response);
?>