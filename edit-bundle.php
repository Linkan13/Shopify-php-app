<?php
	require'connectdb.php';
	include('header.php');

    $collectionList = shopify_call($token, $shop, "/admin/api/2020-04/products.json", array(), 'GET');
    $collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
    $collectionList = $collectionList['products'];

    if(isset($_GET['id'])){
      $bundle_id = $_GET['id'];
      $sql = $conn->query("SELECT * FROM bundle_products WHERE id = '".$bundle_id."'");
      $row = mysqli_fetch_assoc($sql);

      $quotes = unserialize($row['quotes']);
      $count_quotes = count($quotes);

      $tag_lines = unserialize($row['tag_lines']);
      $count_tag_lines = count($tag_lines);

      $products_array = unserialize($row['products_array']);

      if(empty($row['bundl_img'])){
        $img = 'images/upload.png';
      }else{
        $img = 'bundleimages/'.$row['bundl_img'];
      }

      if(empty($row['creator_img'])){
        $imgtwo = 'images/user.png';
      }else{
        $imgtwo = 'creatorimages/'.$row['creator_img'];
      }

?>
<style type="text/css">

.form-check-input{
  margin-left: -16px;
  margin-top: 20px;
}

</style>

<div class="section">
  <div class="container">     

      <div class="row">
        <a href="/managebundles.php" class="btn btn-success mt-4" style="float: right;">Back</a>
      </div>

      <div class="row">
        <div class="col-md-8" style="margin: 0 auto;">
            <h2 class="text-center">Update bundle form</h2>          
        </div>
      </div>
    <div class="col-md-12" style="margin: 0 auto;">
  		<form id="create_bundle_Form">
        <div class="col-md-12 col-md-offset-0 text-center">
          <div id="msg" style="color:#fff;"></div>
        </div>
				<div class="form-row mt-2">
          <div class="col-md-6">
  					<label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Bundle title" value="<?php echo $row['title']; ?>">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $bundle_id; ?>">
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <label for="description">Created by</label>
                <input type="text" class="form-control" id="created_by" name="created_by" placeholder="Type your name" value="<?php echo $row['created_by']; ?>">
              </div>
              <div class="col-md-6">
                <div class="form-group logouplodicon">
                 <label class="btn btn-default">
                      <img src="assets/<?php echo $imgtwo; ?>" id="imgtwo" style=" width: 50px;"> 
                      <input type="file" name="creatorImage" id="filetwo" hidden>
                      <span>Creator image</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-row mt-2">
          <div class="col-md-6">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" placeholder="Add description"><?php echo $row['description']; ?></textarea>
          </div>
          <div class="col-md-6">
            <div class="row mt-4">
              <div class="col-md-6">
                <div class="form-group logouplodicon">
                 <label class="btn btn-default">
                      <img src="assets/<?php echo $img; ?>" id="img" style=" width: 50px;"> 
                      <input type="file" name="bundleImage" id="file" hidden>
                      <span>Bundle image</span>
                  </label>
                </div>
              </div>
              <div class="col-md-6 mt-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBasket">
                Add Products
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row mt-2">
          <div class="col-md-6">
            <label for="quotes">Quotes</label>

            <?php 
              foreach($quotes as $quote){
            ?>
                <input type="text" class="form-control" name="quotes[]" placeholder="Type here..." value="<?php echo $quote; ?>"><br>
            <?php
              }
            ?>
            <div id="dynamic_field" style="width: 100%;margin: 0px;"></div>
            <a class="plus btn btn-default"> Add more quotes</a>
          </div>
          <div class="col-md-6">
            <label for="tag_lines">Header tag lines</label>

            <?php 
              foreach($tag_lines as $tag_line){
            ?>
            <input type="text" class="form-control" name="tag_lines[]" placeholder="Add header tag lines" value="<?php echo $tag_line; ?>"><br>
            <?php
              }
            ?>
            
            <div id="dynamic_field_two" style="width: 100%;margin: 0px;"></div>
            <a class="plus_two btn btn-default"> Add more tag lines</a>
          </div>
        </div>

        <div class="form-row mt-2">
          <div class="col-md-4">
            <label for="category">Category</label>
            <select id="category" name="category" class="form-control">
                  <?php 
                    $sql = $conn->query("SELECT * FROM categories");
                    $sele = '';
                    while ($rowtwo = mysqli_fetch_assoc($sql))  
                    {
                      if($row['category'] == $rowtwo['id']){ $sele = 'selected'; }
                      echo '<option value='.$rowtwo['id'].' '.$sele.'>'.$rowtwo['title'].'</option>';
                    }
                  ?>
            </select>
          </div>
          <div class="col-md-4">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
              <option selected disabled>Choose...</option>
              <option value="1" <?php if($row['status'] == 1){ echo 'selected'; } ?>>Active</option>
              <option value="0" <?php if($row['status'] == 0){ echo 'selected'; } ?>>In-active</option>
            </select>
          </div>
          <div class="col-md-4" style="text-align: center; padding: 35px;">
            <input type="checkbox" id="is_featured" name="is_featured" <?php if($row['is_featured'] == 1){ echo 'checked'; } ?>>
            <label class="form-check-label" for="is_featured" >Is featured</label>
          </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="modalBasket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h3 class="mb-0">Add Products</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3 p-3 pb-0">
        <!-- Grid row -->
        <div class="row">
          <div class="form-outline mr-3" style="width: 48%;">
            <input type="search" id="form1" class="form-control" placeholder="Type query" aria-label="Search" />
          </div>
          <div class="form-outline" style="width: 48%;">
            <select id="product_cat" name="product_cat" class="form-control">
              <option selected disabled>Choose category</option>
              <option value="Pet">Pet</option>
              <option value="Food">Food</option>
            </select>
          </div>
        </div>
        <hr>
        <div class="row">
          <?php
            foreach($collectionList as $collect){
              $title = $collect['title'];
              $desc = $collect['body_html'];
              $image = $collect['image']['src'];          
              $id = $collect['id'];
              $price = $collect['variants']['0']['price'];
              $product_type = $collect['product_type'];
              if(empty($product_type)){
                $product_type = 'None available';
              }

              if (in_array( $id , $products_array)){
                $checked = 'checked';
              }else{
                $checked = '';
              }
              echo '<div class="card card-body col-md-12 '.$id.'">
              <a class="add_to_list">
                <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row" style="padding: 10px;">
                    <div class="mr-2 mb-1 mb-lg-0">
                      <input type="checkbox" class="media-title form-check-input" name="check[]" value='.$id.' '.$checked.'> 
                      <img src='.$image.' width="50" height="50" alt=""> 
                    </div>
                    <div class="media-body">
                        <h6 class="media-title font-weight-semibold"> 
                          '.$title.'
                        </h6>
                        <ul class="list-inline list-inline-dotted mb-lg-2">
                            <li class="list-inline-item">Product type : '.$product_type.'</li>
                        </ul>
                        <p class="mb-1">'.$desc.'</p>
                    </div>
                    <div class="mt-1 mt-lg-0 ml-lg-3 text-center">
                        <h3 class="mb-0 font-weight-semibold">'.$price.'</h3>
                    </div>
                </div>
              </a>
              </div>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

				
        <button type="submit" class="btn btn-primary mt-4 mb-5">Update</button>
      </form>
  	</div>
  </div>
</div>


<?php 
    }
?>
<?php
	include('scripts.php');
?>

<script type="text/javascript">
  var arr_sort = new Array();

  $(document).ready(function(){
      var i= <?php echo $count_quotes; ?>;
    $(".plus").click(function(){
      if( i == '5' ){
        alert('you can not add more than 5 quotes');
        $('.plus').hide();
      }else{
        i++;
        $('#dynamic_field').append('<br><input type="text" class="form-control" name="quotes[]" placeholder="Add Quotes">');
      }
    });

    var j = <?php echo $count_tag_lines; ?>;
    $(".plus_two").click(function(){
      if( j == '3' ){
        alert('you can not add more than 3 tag lines');
        $('.plus_two').hide();
      }else{
        j++;
        $('#dynamic_field_two').append('<br><input type="text" class="form-control" name="tag_lines[]" placeholder="Add tag lines">');
      }
    });
  });

  $("#file").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
        if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
            $("#msg").fadeIn(700, function(){           
               $("#msg").html('<div class="alert alert-danger"> <span class="fa fa-warning"></span> &nbsp;Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload. </div>');
            });
            $("#msg").delay(3000).fadeOut(200);
            $("#file").val('');
            return false;
        }else{
            var image = document.getElementById('file');
            image.src = URL.createObjectURL(event.target.files[0]);
            $("#img").attr("src",image.src);
      }
  });

  $("#filetwo").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
        if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
            $("#msg").fadeIn(700, function(){           
               $("#msg").html('<div class="alert alert-danger"> <span class="fa fa-warning"></span> &nbsp;Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload. </div>');
            });
            $("#msg").delay(3000).fadeOut(200);
            $("#filetwo").val('');
            return false;
        }else{
            var image = document.getElementById('file');
            image.src = URL.createObjectURL(event.target.files[0]);
            $("#imgtwo").attr("src",image.src);
      }
  });

	$(".add_to_list").click(function() {

		var checkbox = $(this).find('input[type=checkbox]');
   	checkbox.prop("checked", !checkbox.prop("checked"));

    arr_sort = [];

    $(".form-check-input").each(function()
    {
        if( $(this).is(':checked') )
        {
            arr_sort.push($(this).val());
        }
    });


		var pdt_id = $(this).attr("data-id");
		var pdt_title = $(this).attr("data-title");
		var pdt_img = $(this).attr("data-img");

    if($(this).hasClass("active")) {
	   	$(this).removeClass("active");

	   	$('.'+pdt_id+'').removeClass("main_active");
    } else {
    	$(this).addClass("active");

	   	$('.'+pdt_id+'').addClass("main_active");	    	
    }
	});


  $("#create_bundle_Form").on("submit",function(e){
    e.preventDefault();

      $.ajax({
            type:'POST',
            url:'update-bundle-sql.php',
            data:  new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(data){
            },
            success:function(data){
              console.log(data);
               if(data.response == "Success"){
                  $("#msg").fadeIn(1000, function(){             
                    $("#msg").html('<div class="alert alert-danger"> <span class="fa fa-success"></span> &nbsp; '+data.Message+'</div>');
                  });
                  $("#msg").delay(3000).fadeOut(200);
                } else {
                  $("#msg").fadeIn(1000, function(){             
                    $("#msg").html('<div class="alert alert-danger"> <span class="fa fa-warning"></span> &nbsp; data is Invalid !</div>');
                  });
                  $("#msg").delay(3000).fadeOut(200);
                }
           },
            error:function(xhr,status){
                 console.log(status.error);
            }
      });
      return false;
    
  });




</script>

<?php
	include('footer.php');
?>