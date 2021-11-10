<?php 
include('header.php');
require_once("inc/functions.php");



$theme = shopify_call($token, $shop, "/admin/api/2020-10/themes.json", array(), 'GET');
$theme = json_decode($theme['response'], JSON_PRETTY_PRINT);


foreach ($theme as $cur_theme) {
    foreach($cur_theme as $key => $value){
        if($value['role'] == 'main'){
            $theme_id = $value['id'];
            
            $array = array('asset' => array('key' => 'layout/theme.liquid'));

            $assets = shopify_call($token, $shop, "/admin/api/2021-04/themes/" .$theme_id. "/assets.json", $array, 'GET');
            $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);


            // snippet content
        //     $snippet = "{% include 'alertcont' %}";

        //     $content_tag = '</main>';
        //     $new_content_tag = $snippet . $content_tag;
        //     $theme_liquid = $assets['asset']['value'];
            
        //     $new_theme_liquid = str_replace($content_tag, $new_content_tag, $theme_liquid);

        //     if(strpos( $assets['asset']['value'], $snippet) === false){
        //         $array = array(
        //             'asset' => array(
        //                 'key' => 'layout/theme.liquid',
        //                 'value' => $new_theme_liquid
        //             )
        //         );

        //     $assets = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $array, 'PUT');
        //     $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
        // }



            // snippet css
            $snippet = "{% include 'alertcss' %}";

            $head_tag = '</head>';
            $new_head_tag = $snippet . $head_tag;
            $theme_liquid = $assets['asset']['value'];
            
            $new_theme_liquid = str_replace($head_tag, $new_head_tag, $theme_liquid);

            if(strpos( $assets['asset']['value'], $snippet) === false){
                $array = array(
                    'asset' => array(
                        'key' => 'layout/theme.liquid',
                        'value' => $new_theme_liquid
                    )
                );

                $assets = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $array, 'PUT');
                $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
            }


            // snippet js

            $snippet = "{% include 'alertjs' %}";

            $body_tag = '</body>';
            $new_body_tag = $snippet . $body_tag;
            $theme_liquid = $assets['asset']['value'];
            
            $new_theme_liquid = str_replace($body_tag, $new_body_tag, $theme_liquid);

            if(strpos( $assets['asset']['value'], $snippet) === false){
                $array = array(
                    'asset' => array(
                        'key' => 'layout/theme.liquid',
                        'value' => $new_theme_liquid
                    )
                );

                $assets = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $array, 'PUT');
                $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
            }


            $snippet_css_liquid = '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"/>';

            $snippet_js_liquid = '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
            </script>
            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>';


    $snippet_cont_liquid = '';
    $snippet_cont_liquid .= '<div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8" style="margin:0 auto; text-align:center;">
                <h2>Shop over 50 professionally designed bundles for your pets needs!</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8" style="margin:0 auto;">
                <form class="form-inline">
                  <div class="form-group mb-2">
                    <span>Who are you shopping for?</span>
                    <select class="form-select form-select-lg mb-3" name="sel_cat" id="sel_cat">';
                
        $sql = $conn->query("SELECT * FROM categories WHERE status = 1");
        while ($row = mysqli_fetch_assoc($sql))  
        {
            $snippet_cont_liquid .= '<option value="1">'.$row['title'].'</option>';
        }
  
        $snippet_cont_liquid .= '</select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" hidden>Confirm identity</button>
                        </form>
                    </div>
                </div>
            <div class="p-2 bg-white px-4">
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-row align-items-center filters">
                    <h4>Filters</h4><span class="ml-2">(234 items)</span>
                </div>
                <div class="d-flex flex-row align-items-center filters">
                    <div class="d-flex flex-row align-items-center">
                        <h5 class="mt-1">Sort by</h5><span class="ml-2">our price</span><i class="fa fa-angle-down ml-1"></i>
                    </div>
                    <div class="d-flex flex-row align-items-center ml-3"><span>ratings</span><i class="fa fa-angle-down ml-1"></i></div>
                </div>
            </div>
        </div>
        <div class="row">';
    ?>
        <?php $sql = $conn->query("SELECT * FROM bundle_products limit 4");

        while ($row = mysqli_fetch_assoc($sql))  
        {
            $snippet_cont_liquid .=  '<div class="col-md-3 col-lg-3 mt-2">
                <div class="p-4 bg-white">
                    <div class="d-flex flex-column">
                        <div><img class="img-fluid img-responsive" src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/'.$row['bundl_img'].'" width="" height="220"></div>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <h5>'.$row['title'].'</h5>
                            </div>
                            <div><span>'.$row['description'].'</span></div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        $snippet_cont_liquid .= '</div></div>';




            $arrayCss = array(
                'asset' => array(
                    'key' => 'snippets/alertcss.liquid',
                    'value' => $snippet_css_liquid
                )
            );

            $arrayJs = array(
                'asset' => array(
                    'key' => 'snippets/alertjs.liquid',
                    'value' => $snippet_js_liquid
                )
            );

            $arrayCont = array(
                'asset' => array(
                    'key' => 'snippets/alertcont.liquid',
                    'value' => $snippet_cont_liquid
                )
            );


    $snippetCSS = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayCss, 'PUT');
    $snippetCSS = json_decode($snippetCSS['response'], JSON_PRETTY_PRINT);

    $snippetJS = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayJs, 'PUT');
    $snippetJS = json_decode($snippetJS['response'], JSON_PRETTY_PRINT);

$snippetContent = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayCont, 'PUT');
$snippetContent = json_decode($snippetContent['response'], JSON_PRETTY_PRINT);


        }

    }
}
?>


<div class="section">
    <div class="container">

        <div class="row">
            <div class="col-md-8" style="margin: 0 auto;">
                <h2 class="text-center">List of bundle orders</h2>              
            </div>
        </div>

        <div class="row">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>first order</td>
                <td>02/08/2021</td>
                <td>view</td>
            </tr>
            <tr>
                <td>2</td>
                <td>second order</td>
                <td>10/09/2021</td>
                <td>view</td>
            </tr>
            <tr>
                <td>3</td>
                <td>third order</td>
                <td>12/10/2021</td>
                <td>view</td>
            </tr>
            <tr>
                <td>4</td>
                <td>fourth order</td>
                <td>02/08/2021</td>
                <td>view</td>
            </tr>
            <tr>
                <td>5</td>
                <td>five order</td>
                <td>12/04/2021</td>
                <td>view</td>
            </tr>
        </tfoot>
    </table>
        </div>



<?php include('scripts.php'); ?>



<script type="text/javascript">
$('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [  0, 1, 2 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            }, 
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                }
            }
        ]
    });
</script>
<?php include('footer.php'); ?>

