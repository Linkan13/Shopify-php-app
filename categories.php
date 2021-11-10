<?php
require'connectdb.php';
include('header.php');

$collectionList = shopify_call($token, $shop, "/admin/api/2020-04/products.json", array(), 'GET');
$collectionList = json_decode($collectionList['response'], JSON_PRETTY_PRINT);
$collectionList = $collectionList['products'];
//print_r($collectionList);


?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-center">
              <div id="msg" style="color:#fff;"></div>
            </div>
        </div>
        <div class="row">
            <button type="button" class="btn btn-primary mt-4" style="float: right;" data-toggle="modal" data-target="#modalBasket">Create new category</button>
        </div>

    	<div class="row">
    		<div class="col-md-8" style="margin: 0 auto;">
		        <h2 class="text-center">List of all categories</h2>    			
    		</div>
    	</div>

    	<div class="row">
    		<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = $conn->query("SELECT * FROM categories");
                $i = 1;
                while ($row = mysqli_fetch_assoc($sql))  
                {   
                    if($row['status'] == '1'){
                        $clr = 'green';
                        $status = 'Active';
                    }else{
                        $clr = 'red';
                        $status = 'In-active';
                    }

                    $orgDate = $row['created_at'];  
                    $newDate = date("d-m-Y", strtotime($orgDate));  
                    
                    echo '<tr>
                            <td>'.$i.'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.$newDate.'</td>
                            <td style="color:'.$clr.';">'.$status.'</td>
                            <td><a href="#" class="editCategory" data-toggle="modal" data-target="#modalBaskettwo" data-id="'.$row['id'].'" data-status="'.$row['status'].'" data-title="'.$row['title'].'">Edit</a></td>
                        </tr>';
                    $i++;
                }
            ?>
        </tbody>
    </table>
    	</div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalBasket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h3 class="mb-0">Create new category</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3 p-3 pb-0">

        <div class="row">
            <div class="col-md-12" style="margin: 0 auto;">
                <form id="create_category_Form">
                    <div class="form-row mt-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Category title">
                        <input type="hidden" id="last_id" name="last_id" value="<?php echo $i; ?>">
                    </div>
                    <div class="form-row mt-2">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">In-active</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 mb-5">Create</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalBaskettwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h3 class="mb-0">Update category</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3 p-3 pb-0">

        <div class="row">
            <div class="col-md-12" style="margin: 0 auto;">
                <form id="update_category_Form">
                    <div class="form-row mt-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="utitle" name="utitle" placeholder="Category title" >
                        <input type="hidden" class="form-control" id="uid" name="uid" >
                    </div>
                    <div class="form-row mt-2">
                        <label for="status">Status</label>
                        <select id="ustatus" name="ustatus" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">In-active</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 mb-5">Update</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );


    $('.editCategory').on('click', function (){
        var id =$(this).attr("data-id");
        var status =$(this).attr("data-status");
        var title =$(this).attr("data-title");

        $('#utitle').val(title);
        $('#uid').val(id);
        $('#ustatus').find('option[value="' + status + '"]').attr("selected", "selected");
    });


  $("#create_category_Form").on("submit",function(e){
    e.preventDefault();
    var addCategoryData = $(this).serialize();
    var title = $('#title').val();
    if(title.length === 0 ){
        alert('Please enter title');
        return false;
    }
      $.ajax({
            type:'POST',
            url:'add-category-sql.php',
            dataType : 'json',
            data: addCategoryData,
            beforeSend:function(data){
            },
            success:function(data){
                console.log(data);
               if(data.response == "Success"){
                  $('#modalBasket').modal('hide');
                  $("#title").val('');
                  $('#example > tbody:last').append(data.tabledata);
                  var lastId = data.last_id;
                  $('#last_id').val(lastId);
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



  $("#update_category_Form").on("submit",function(e){
    e.preventDefault();
    var addCategoryData = $(this).serialize();
    var title = $('#utitle').val();
    if(title.length === 0 ){
        alert('Please enter title');
        return false;
    }
      $.ajax({
            type:'POST',
            url:'update-category-sql.php',
            dataType : 'json',
            data: addCategoryData,
            beforeSend:function(data){
            },
            success:function(data){
                console.log(data);
               if(data.response == "Success"){
                  $('#modalBaskettwo').modal('hide');
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

<?php include('footer.php'); ?>

