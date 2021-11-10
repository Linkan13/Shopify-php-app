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
    		<div class="col-md-8" style="margin: 0 auto;">
		        <h2 class="text-center">List of all bundle products</h2>    			
    		</div>
    	</div>

        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-center">
              <div id="msg" style="color:#fff;"></div>
            </div>
        </div>

    	<div class="row">
    		<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>date</th>
                <th>status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = $conn->query("SELECT * FROM bundle_products");
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
                            <td><a href="/edit-bundle.php?id='.$row['id'].'">Edit</a> / <a href="#" class="deletecls" data-toggle="modal" data-target="#modaldelete" data-id="'.$row['id'].'"  data-title="'.$row['title'].'" > Delete</a></td>
                        </tr>';
                    $i++;
                }
            ?>
        </tbody>
    </table>
    	</div>


<!-- Modal -->
<div class="modal fade" id="modaldelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      
    <div class="modal-content">
        <div class="modal-header"><h4>Delete <i class="fa fa-bin"></i><span class="catename"></span></h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
        <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to Delete?
            <input type="hidden" name="deleteid" id="deleteid" value="">
        </div>
        <div class="modal-footer"><a href="javascript:;" class="btn btn-primary btn-block deleteform" >Delete</a></div>
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

    $('.deletecls').on('click', function (){
        var id =$(this).attr("data-id");
        var title =$(this).attr("data-title");
        $('.catename').text(title);
        $('#deleteid').val(id);
    });

    $('.deleteform').on('click', function (){
        var id =$('#deleteid').val();

        $.ajax({
            type:'POST',
            url:'delete-category-sql.php',
            dataType : 'json',
            data: { id : id },
            beforeSend:function(data){
            },
            success:function(data){
               if(data.response == "Success"){
                  $('#modaldelete').modal('hide');


                    $(".deletecls[data-id='" + data.bundleid + "']").parents('tr').fadeOut(200);

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

