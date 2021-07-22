<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>

<?php 

if(!isset($_GET['trans_id']) || $_GET['trans_id'] == "" ){

wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
	exist;

}else{
	$term_id =$_GET['trans_id'];
	$term_name = get_term( $term_id )->name;
?>
 

    <div class='col-sm-12' >
		<div class='col-sm-6' style='padding-left:0px'> <h3>Charity (<?php echo $term_name;?>) Fund Transactions  <small>List of transactions</small></h3>
            </div>
		<div class='col-sm-6 text-right' style="padding-top: 14px;">
			<a href='<?php echo site_url();?>/wp-admin/admin.php?page=fund_charity' class='btn btn-primary'> Back To Funds </a>
		</div>
    </div>
  

  <div class="col-md-12 custyle">
	  <div class="col-sm-12">
		  <h2 style="text-align:center" class="charityname"></h2>	  
	  </div>  
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th># Trans-No</th>
				<th>Charity Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        
	 <tbody>
	<?php 
	global $wpdb;
	$get_charity_trans = $wpdb->get_results("select *  from PQrlH_transactions where payment_type = 'charity_fund' AND order_id=".$term_id); 
	if(count($get_charity_trans) > 0){
		foreach($get_charity_trans as $transaction){
	?>
		 
	  <tr>
        <td><?php echo $transaction->trans_id;?></td>
        <td><?php echo $term_name;?></td>
        <td><?php echo "£ ". $transaction->price;?></td>
        <td><?php echo date('d, M Y H:i:s A',strtotime($transaction->date_time))?></td>
      </tr>
		 <?php }  } ?>
      </tbody>
    </table>
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
		
      });
    </script>
<?php } ?>