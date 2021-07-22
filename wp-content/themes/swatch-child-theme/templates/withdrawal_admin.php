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
  <?php  } ?>
 <?php
    global $wpdb;
    
    $get_vouchers  = $wpdb->get_results('Select * from payment');
    
    $total = count($get_vouchers);
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> Withdrawal</h3>
            <p> <?php echo $total;?> Withdrawal Found!</p>
            </div>
    </div>
    
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Payment.ID</th>
                <th>Amount</th>
                <th>Email</th>
                <th>Payment Gateway</th>
				<th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($get_vouchers as $voucher){
         
    ?>
      <tr>
        <td><?php echo $voucher->id;?></td>
        <td><?php echo $voucher->amount;?></td>
        <td><?php echo $voucher->email;?></td>
        <td><?php echo $voucher->paymentgateway;?></td>
		 <td><?php echo $voucher->status;?></td>
        <td>
			<?php 
				if($voucher->status == 'Pending'){
			?>
			<button class='btn btn-small btn-primary'>  Edit</button>
		<button class='btn btn-small btn-primary checkemail' data-id="<?php echo $voucher->email;?>" data-toggle="modal" data-target="#exampleModal" >Check Email</button>
			
			<form onSubmit="if(!confirm('Are you sure you want Approve withdrawal?')){return false;}"                  style='display:inline-block'  action='<?php echo esc_url( admin_url('admin-post.php') ); ?>'  method='post'>
             <input type="hidden" name="action" value="change_payment_status">
             <input type='hidden' name='qid' value="<?php echo $voucher->id;?>">
			 <input type='hidden' name='withdraw_amount' value="<?php echo $voucher->amount;?>">
				 <input type='hidden' name='userid' value="<?php echo $voucher->u_id;?>">
				 <input type='hidden' name='payment_method' value="<?php echo $voucher->paymentgateway;?>">
             <button type='submit' name='delete_question' class='btn btn-danger'>Approve Amount</button>
         </form><?php }else {?>
			
			<button class='btn btn-small btn-primary'>  Withdrawal Approved</button>
			<?php } ?>
        </td>
      </tr>
      
      <?php } } ?>
        </tbody>
    </table>
    </div>
	<!---------------------modal----------------->
		
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action='<?php echo esc_url( admin_url('admin-post.php') ); ?>'  method='post'>
			  <input type="hidden" name="action" value="check_email">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control recipient" id="recipient-name"  name="recipientemail">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" name="recipientmessage" id="message-text"></textarea>
          </div>
			  <button type="submit" class="btn btn-primary">Send message</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
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
		
		$(document).on('click','.checkemail',function(){
		 	var useremail=$(this).data('id');
			$('.recipient').val(useremail);
		});
      });
    </script>