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
    global $wpdb;
   if(isset($_POST['subs_id']) &&  $_POST['subs_id'] != ""){
   		$subscriber  = $wpdb->get_results("SELECT * FROM `PQrlH_User_subscriptions` where subsciption_id = ".$_POST['subs_id']);
   }else{
    $subscriber  = $wpdb->get_results("SELECT * FROM `PQrlH_User_subscriptions`");
   }
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> Subscribed Users </h3>
            <p> <?php echo count($subscriber);?> Users Found!</p>
            </div>
    </div>
    <div class="col-sm-12" style="padding-left:0px;margin-bottom:15px">
		<input type='hidden' class='page' value='orders'>
		<h4> Filter </h4>
		<div class="col-sm-3" style="padding-left:0px">
		<form action="" id='subscription_filter' method="post">
		<select name="subs_id" class="form-control subscription_options" id="subs_id">
			<option value="" selected disabled> Select Subscription Type</option>
			<?php 
				$args = array(  
					'post_type' => 'winner-subscriptions',
					'post_status' => 'publish',
					'posts_per_page' => -1, 
					'paged' => $paged,
					'orderby' => 'title', 
					'order' => 'DESC', 
				);
				$loop = new WP_Query( $args ); 
			   if($loop->have_posts()) {
				while ( $loop->have_posts() ) : $loop->the_post(); 
				?>
				<option value="<?php echo get_the_ID();?>"> <?php echo get_the_title(get_the_ID());?></option>
				<?php endwhile; } ?>
				</select>
			</form>
		<?php //echo $clear;?>
		</div>
	</div>
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Subs.ID</th>
                <th>User Name</th>
                <th>Subscription Name </th>
				<th>Amount Paid </th>
				<th>Payment Method </th>
				<th>Status</th>
               <!--- <th>Action</th>-->
            </tr>
        </thead>
        <tbody>
        <?php 
    	foreach($subscriber as $subs){
			$u = get_userdata($subs->user_id);
			$get_trans = $wpdb->get_row("select * from PQrlH_transactions where id = ".$subs->transaction_id);
       ?>
      <tr>
			<td><?php echo "#SUBS-".$subs->id; ?></td>
		  <td><span class="label label-default"><?php echo $u->user_nicename; ?></span></td>
		  <td><span class="label label-success"><?php echo get_the_title($subs->subsciption_id); ?></span></td>
		  <td><span style="color:green"><?php echo "£ ".$get_trans->price;?></span></td>
		    <td><?php echo ucfirst($get_trans->payment_method);?></td>
			<td><?php echo ucfirst($get_trans->payment_status);?></td>
		  <!---
			<td>
				<button class="btn btn-primary"> Change </button>
				<button class="btn btn-danger"> Delete </button>
			  </td>
          -->
      </tr>
      
      <?php } ?>
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
      } );
    </script>