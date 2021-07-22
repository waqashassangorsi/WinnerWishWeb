<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>
<style>
.custab{
    border: 1px solid #ccc;
    padding: 5px;
    box-shadow: 3px 3px 2px #ccc;
    transition: 0.5s;
    }
.custab:hover{
    box-shadow: 3px 3px 0px transparent;
    transition: 0.5s;
    }
</style>
 
<?php 
    if(isset($_GET['status']) && $_GET['status'] == 'success'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Voucher Added Successfully!
         </div>
    </div>
  <?php  } else if(isset($_GET['status']) && $_GET['status'] == 'deleted'){ ?>
 
   <div class='col-sm-12'>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Voucher Deleted Successfully!
         </div>
    </div>
  <?php } ?> 
  
 <?php
    global $wpdb;
    
    $get_vouchers  = $wpdb->get_results('Select * from pqrlh_vouchers');
    
    $total = count($get_vouchers);
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> Vouchers </h3>
            <p> <?php echo $total;?> Vouchers Found!</p>
            </div>
            <div class='col-sm-6'>
            <button type='button' class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" style='margin-top:16px'><b>+</b> Add new voucher</a>
            </div>
    </div>
    
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>V.ID</th>
                <th>Voucher Name</th>
                <th>Voucher Price</th>
                <th>Voucher Limit</th>
                <th>Voucher Usage</th>
                <th>Voucher Expiry</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($get_vouchers as $voucher){
            
            if($quest->question_status == 'approved'){
                $label = "label-success";
            }else{
                $label = "label-warning";
            }
    ?>
      <tr>
        <td><?php echo $voucher->vid;?></td>
        <td><?php echo $voucher->vname;?></td>
        <td><?php echo $voucher->vprice;?></td>
        <td><?php echo $voucher->vlimit;?></td>
        <td> 0 </td>
        <td> <?php echo $voucher->vexpiry;?> </td>
        <td><!--<button class='btn btn-small btn-primary'  data-question='<?php echo $voucher->question;?>' data-questionid='<?php echo $voucher->id;?>'>  Edit</button>-->
         <form onSubmit="if(!confirm('Are you sure you want to change the Question status?')){return false;}" style='display:inline-block'  action='<?php echo esc_url( admin_url('admin-post.php') ); ?>'  method='post'>
             <input type="hidden" name="action" value="delete_voucher">
             <input type='hidden' name='vid' value="<?php echo $voucher->vid;?>">
             <button type='submit' name='delete_voucher' class='btn btn-danger'>  Delete </button>
         </form>
        </td>
      </tr>
      
      <?php } } ?>
        </tbody>
    </table>
    </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Voucher</h4>
                </div>
                <div class="modal-body">
                <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method='post'>
                    <input type='hidden' value='save_voucher' name='action'>
                    <div class="form-group">
                        <label for="text">Voucher Name:</label>
                        <input type="text" class="form-control" required name='vname' id="vname">
                    </div>
                    <div class="form-group">
                        <label for="vprice">Voucher Price (%):</label>
                        <input type="text" class="form-control" required name='vprice' id="vprice">
                    </div>
                    <div class="form-group">
                        <label for="vlimit">Voucher Limit:</label>
                        <input type="text" class="form-control" required name='vlimit' id="vlimit">
                    </div>
                    <div class="form-group">
                        <label for="vexpiry">Voucher Expiry:</label>
                        <input type="date" class="form-control" required name='vexpiry' id="vexpiry">
                    </div>
                   
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </form>
                </div>
            </div>
            
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js'></script>
    <script>
    jQuery(document).ready(function($) {
       $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
      } );
    </script>