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
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"/>
            <link rel="stylesheet" type="text/css" href="https://phpstack-102119-1956372.cloudwaysapps.com/assets/theme.css"/>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>';

            $snippet_js_liquid = '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
            </script>
            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script type="text/javascript" src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/theme.js"></script>
            <script>$(".carousel").carousel();</script>';


            $snippet_cont_liquid = '';
            $snippet_cont_liquid .= '
                       <header class="masthead">
                          <div class="container h-100">
                            <div class="row h-100 align-items-center">
                              <div class="col-md-6 text-center">
                                <h1 class="font-weight-light">Vertically Centered Masthead Content</h1>
                                <p class="lead">A great starter layout for a landing page</p>
                              </div>
                            </div>
                          </div>
                        </header> 

<div class="container">
    <div id="content" >
        <div id="filterbar">
            <div class="card">
              <div id="headingOne">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> By Age <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box1" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div id="headingTwo">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> By Value <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box2" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div id="headingTwo">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> By Goal <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box2" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div id="headingTwo">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> By Parent <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box2" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div id="headingTwo">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> By Time <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box2" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div id="headingTwo">
                <h5 class="mb-0">
                  <a class="btn btn-link p-3 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> By Ingredient <i class="fa" aria-hidden="true" style="float: right;"></i>
                  </a>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                        <div id="inner-box2" >
                            <div class="my-1"> <label class="tick">0-6 months <input type="checkbox" hidden > <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">6-12 months <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">1-3 years <input type="checkbox" hidden checked> <span class="check"></span> </label> </div>
                            <div class="my-1"> <label class="tick">3-5 years <input type="checkbox" hidden>  <span class="check"></span> </label> </div>
                        </div>
                </div>
              </div>
            </div>

        </div>
        <div id="products">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between p-2" id="header"> 
                    Cant find what you are looking for? <a class="btn btn-header pl-3 pr-3"> Create your own!</a>
                </div>
            </div>
            <div class="row mx-0 p-5">';

            $sql = $conn->query("SELECT * FROM bundle_products");
            while ($row = mysqli_fetch_assoc($sql))  
            {
                $snippet_cont_liquid .= '<div class="col-lg-4 col-md-6 pt-md-4 pt-3">
                    <div class="card d-flex flex-column align-items-center">
                        <div class="card-img"> <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/'.$row['bundl_img'].'" alt=""> </div>
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center justify-content-center price">
                                <div class="font-weight-bold pl-2 pr-2 text-center">'.$row['title'].'</div>
                            </div>
                            <div class="text-muted text-center mt-auto">'.$row['description'].'</div>
                        </div>
                    </div>
                </div>';
            }
            $snippet_cont_liquid .= '</div></div></div>';


            $sql = $conn->query("SELECT * FROM bundle_products limit 1");
            while ($row = mysqli_fetch_assoc($sql))  
            {
                $snippet_cont_liquid .= '<div class="row featured" style="background: #f7f7f7;">
                                        <div class="col-md-12"><h4 class="text-center mt-4 mb-4" style="font-weight: 600;">Featured bundle</h4></div>
                                        <div class="col-md-9 row">
                                            <div class="col-md-6">
                                                <div class="pro-img-details">
                                                  <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/'.$row['bundl_img'].'" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="pro-d-title">
                                                  <a href="#" class="">
                                                      '.$row['title'].'
                                                  </a>
                                                </h4>
                                                <p>
                                                  '.$row['description'].'
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                        </div>';
            }
            $snippet_cont_liquid .= '</div>';

            $snippet_Bundles_liquid = '';

            $snippet_Bundles_liquid .= '

    <div class="mt-5 p-5" style="background: #E5E9F2;">
        <div class="container">
                <h2 class="font-weight-bold pt-2 ml-3">Bundle Short Description</h2>
            <div class="row align-items-center no-gutters">
                <div class="col-xl-9 col-lg-9 col-md-9 row">
                    <div class="col-md-4 py-5 py-lg-0" style="text-align: center;">
                        <img class="rounded-circle pt-3" alt="100x100" src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/1622719019_Beggin-dog-treats-logo_159e8e7e-5a87-47a6-be01-5cb0456177ca_1024x.png" style="width: 100%;background: #C3C3C3;height: 220px;padding: 10px;">
                        <span class="creator-name pt-2 pb-5">Name of creator</span>
                    </div>
                    <div class="col-md-8 py-5 py-lg-0 p-5">
                        <h3 class="title  mt-4">About this bundle title</h3>
                        <p class="mt-4">About this bundle text</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 text-left">
                    <div class="inbox" style="margin-top: -96px;">
                        <h3 class="title">What we love</h3>
                        <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/download.png" style="    width: 30px;">
                        <span class="mt-3">What we love thing 1</span>
                        <br>
                        <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/download.png" style="    width: 30px; margin-top: 10px;">
                        <span class="mt-3">What we love thing 2</span>
                        <br>
                        <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/download.png" style="    width: 30px; margin-top: 10px;">
                        <span class="mt-3">What we love thing 3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container my-4"> 
  <section>
<div class="owl-slider mt-4">
    <span class="font-weight-bold">This bundle contains</span>

    <div id="carouseltwo" class="owl-carousel" style="margin-top: 10px; padding: 0px 99px;">
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD2.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD3.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD4.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD2.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD3.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD4.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/FOOD.webp" alt="">
            <div class="ifodMh"><span class="hqhyen">Candy &amp; Chocolate</span></div>            
        </div>
    </div>
</div>
  </section>
  <hr>


    <div class="container" style="border-right: 3px solid #7d7d7d;">
    <div class="row">
        <div class="col-md-12" style=" text-align: right;">
            <button class="btn mainbtn active">Bundle layout</button>
            <button class="btn mainbtn">Type layout</button>
        </div>
    </div>
    <div class="row singleproduct p-4 mt-5 mb-5">
        <div class="col-md-12">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="details col-md-5"> 
                        <div class="rating">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="review-no">41</span>
                            </div>
                        </div>
                        <h3 class="product-title">Kettle & Fire Bone Broth, Turmeric Ginger Chicken </h3>
                        <div class="weight">16.9 oz carton</div>
                        <div class="sale_price">$6.74 <span class="real_price">$7.99</span><span class="member">Members save 16%</span></div>
                        <button class="btn add_to_cart mt-5">Add <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15" class="zq8eku-0 sc-1mi00dk-5  guRCKC"><path d="M1.671 9.667v-8H.339V.333h2A.667.667 0 013.005 1v8h8.292l1.333-5.333H4.338V2.333h9.147a.666.666 0 01.647.829l-1.667 6.667a.667.667 0 01-.647.504h-9.48a.667.667 0 01-.667-.666zm1.334 4.666a1.334 1.334 0 110-2.667 1.334 1.334 0 010 2.667zm8 0a1.334 1.334 0 110-2.667 1.334 1.334 0 010 2.667z" fill="#333"></path></svg></button>
<div class="owl-slider mt-4">
    <span class="font-weight-bold">Top picks for you</span>

    <div id="carousel" class="owl-carousel" style="margin-top: 10px;">
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
    </div>
</div>
                    </div>
                    <div class="col-md-4" style="text-align: center;">
                        <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" style="width: 70%;"/>
                    </div>
                    <div class="col-md-3">
                        <blockquote>
                            <cite class="b_crtr_name">Thomas</cite>
                            <span>Says</span>
                            <p>Non-violence leads to the highest ethics, which is the goal of all evolution. Until we stop harming all other living beings, we are still savages.</p>
                            
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <div class="prodctShrtcut">
            <img src="https://cutewallpaper.org/21/anime-trees-background/Anime-Tree-Background-98-images-in-Collection-Page-3.jpg">
            <h5 class="shrtcttitle">Product Type</h5>
        </div>
    </div>
    <hr class="hrProducts">
    <div class="row singleproduct p-4 mt-5">
        <div class="col-md-12">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="details col-md-5"> 
                        <div class="rating">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="review-no">41</span>
                            </div>
                        </div>
                        <h3 class="product-title">Kettle & Fire Bone Broth, Turmeric Ginger Chicken </h3>
                        <div class="weight">16.9 oz carton</div>
                        <div class="sale_price">$6.74 <span class="real_price">$7.99</span><span class="member">Members save 16%</span></div>
                        <button class="btn add_to_cart mt-5">Add<svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15" class="zq8eku-0 sc-1mi00dk-5  guRCKC"><path d="M1.671 9.667v-8H.339V.333h2A.667.667 0 013.005 1v8h8.292l1.333-5.333H4.338V2.333h9.147a.666.666 0 01.647.829l-1.667 6.667a.667.667 0 01-.647.504h-9.48a.667.667 0 01-.667-.666zm1.334 4.666a1.334 1.334 0 110-2.667 1.334 1.334 0 010 2.667zm8 0a1.334 1.334 0 110-2.667 1.334 1.334 0 010 2.667z" fill="#333"></path></svg></button>
<div class="owl-slider mt-4">
    <span class="font-weight-bold">Top picks for you</span>

    <div id="carouselthree" class="owl-carousel" style="margin-top: 10px;">
        <div class="item visibl">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
        <div class="item">
            <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product.webp" alt="">
        </div>
    </div>
</div>
                    </div>
                    <div class="col-md-4" style="text-align: center;">
                        <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/images/products/product2.webp" style="width: 70%;"/>
                    </div>
                    <div class="col-md-3">
                        <blockquote>
                            <cite class="b_crtr_name">Thomas</cite>
                            <span>Says</span>
                            <p>Non-violence leads to the highest ethics, which is the goal of all evolution. Until we stop harming all other living beings, we are still savages.</p>
                            
                        </blockquote>
                    </div>
                </div>

            </div>
        </div>
        <div class="prodctShrtcut">
            <img src="https://cutewallpaper.org/21/anime-trees-background/Anime-Tree-Background-98-images-in-Collection-Page-3.jpg">
            <h5 class="shrtcttitle">Product Type</h5>
        </div>
    </div>

</div>
            <hr class="hrProducts">

    <div class="row">
        <div class="col-md-12 footerbtn">
            <button class="btn mainbtn active">Add other Products</button>
            <span class="footerOR">OR</span>
            <button class="btn mainbtn">Checkout</button>
        </div>
    </div>

</div>';


        
            $sql = $conn->query("SELECT * FROM bundle_products limit 1");
            while ($row = mysqli_fetch_assoc($sql))  
            {
                $snippet_Bundles_liquid .= '<div class="row featured" style="background: #f7f7f7;">
                                        <div class="col-md-12"><h4 class="text-center mt-4 mb-4" style="font-weight: 600;">Featured bundle</h4></div>
                                        <div class="col-md-9 row">
                                            <div class="col-md-6">
                                                <div class="pro-img-details">
                                                  <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/'.$row['bundl_img'].'" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="pro-d-title">
                                                  <a href="#" class="">
                                                      '.$row['title'].'
                                                  </a>
                                                </h4>
                                                <p>
                                                  '.$row['description'].'
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                                <div class="box"><span class="filtr">Filter 1</span></div>
                                        </div>';
            }
            $snippet_Bundles_liquid .= '</div>';

            $snippet_Bundles_liquid .= '<div class="container">
                <div class="row">
                    <div class="col-md-8" style="margin: 0 auto;">
                        <h2 style="font-size: 23px;line-height: 32px;font-weight: 600;">Shop by over 70 professionally designed bundles for your pets needs!</h2>
                    </div>
                </div>
                <div class="row" style=" width: 50%; margin: 0 auto;">
                    <div class="col-md-8 text-center">
                        <span style="font-size: 23px;">Who do you shop for?</span>
                    </div>
                    <div class="col-md-4 text-center">
                        <select class="form-select" aria-label="Default select example" id="selectbox1">
                          <option selected disable>Select</option>';

$sql = $conn->query("SELECT * FROM categories WHERE status = 1");
            while ($row = mysqli_fetch_assoc($sql))  
            {
                $snippet_Bundles_liquid .= '                          
                          <option value="'.$row['id'].'">'.$row['title'].'</option>';
            }
                        $snippet_Bundles_liquid .= '</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8" style="margin: 0 auto;">
                        <div class="ccg0cr-2 PMbNk d-flex justify-content-center bd-highlight mb-3">
                            <div class="sc-1dmdmix-1 kuReTu" style="opacity: 1; transform: none;">By Age</div>
                            <div class="sc-1dmdmix-1 kuReTu active" style="opacity: 1; transform: none;">By Goal</div>
                            <div class="sc-1dmdmix-1 kuReTu" style="opacity: 1; transform: none;">By Values</div>
                            <div class="sc-1dmdmix-1 kuReTu" style="opacity: 1; transform: none;">By Time</div>
                            <div class="sc-1dmdmix-1 kuReTu" style="opacity: 1; transform: none;">By Ingredient</div>
                            <div class="sc-1dmdmix-1 kuReTu" style="opacity: 1; transform: none;">By Parent</div>
                        </div>
                    </div>
                </div><div class="row" style="width: 65%;margin: 0 auto;" id="bundlesAppend">';

    $sql = $conn->query("SELECT * FROM bundle_products limit 4");
            while ($row = mysqli_fetch_assoc($sql))  
            {
                $snippet_Bundles_liquid .= '
        <div class="bund_product col-md-3" data-id="'.$row['id'].'">
            <div class="buproduct">
                <div class="imgn">
                    <img src="https://phpstack-102119-1956372.cloudwaysapps.com/assets/bundleimages/'.$row['bundl_img'].'">
                </div>
            </div>
            <span>'.$row['title'].'df<span>
        </div>';
    }

    $snippet_Bundles_liquid .= '</div>
    <div class="row">
        <div class="col-md-12" style="text-align: center;margin: 40px 0px;">
            <button class="btn mainbtn active" style="font-size: 15px;width: 35%;">Search for more bundles</button>
            <span style="margin: 0px 24px;">OR</span>
            <button class="btn mainbtn" style="font-size: 15px;width: 20%;">Create your own</button>
        </div>
    </div>
</div>';





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

            $arrayBundles = array(
                'asset' => array(
                    'key' => 'snippets/alertbundles.liquid',
                    'value' => $snippet_Bundles_liquid
                )
            );


    $snippetCSS = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayCss, 'PUT');
    $snippetCSS = json_decode($snippetCSS['response'], JSON_PRETTY_PRINT);

    $snippetJS = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayJs, 'PUT');
    $snippetJS = json_decode($snippetJS['response'], JSON_PRETTY_PRINT);

$snippetContent = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayCont, 'PUT');
$snippetContent = json_decode($snippetContent['response'], JSON_PRETTY_PRINT);


$bundleSnippetContent = shopify_call($token, $shop, "/admin/api/2021-04/themes/" . $theme_id . "/assets.json", $arrayBundles, 'PUT');
$bundleSnippetContent = json_decode($bundleSnippetContent['response'], JSON_PRETTY_PRINT);


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

