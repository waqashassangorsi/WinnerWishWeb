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
    
	   $args = array(  
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
			'orderby' => 'title', 
			'order' => 'DESC', 
		);

    $loop = new WP_Query( $args ); 
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> All Raffle Tickets </h3>
            <p> <?php echo count($loop);?> Raffles Found!</p>
            </div>
    </div>
    
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Raffle.ID</th>
                <th>Raffle Name</th>
                <th>Raffle Sold Tickets </th>
				<th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($loop->have_posts()) {
    while ( $loop->have_posts() ) : $loop->the_post(); 
            $diff = abs(time() - strtotime(get_the_date('j F Y', get_the_ID())));
					
			 $min = floor($diff / (60*60*24));
		global $wpdb;
		$sold =   $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where lottery_id = ".get_the_ID());
		if( (get_post_meta( get_the_ID(), 'days', true ) - $min) <= 0){
				$stat = "<span class='label label-danger'>Awaiting Withdrawal</span>";
			    $link = "?action=export&&raffle=".get_the_ID();
			    $style_click = "";
			    $disabled = "";
		}else{
			$stat = "<span class='label label-success'>On Going</span>";
			$link = "";
			$style_click = "style='pointer-events: none;cursor: default;'";
			$disabled = "disabled";
		}
    ?>
      <tr>
			<td><?php echo "#Raff-".get_the_ID(); ?></td>
			<td><?php the_title(); ?></td>
			<td><?php echo $sold; ?></td>
			<td><?php echo $stat;?></td>
			<td><a href="<?php echo site_url();?>/wp-admin/admin.php?page=raffle_all_tickets&&Raff=<?php echo get_the_ID();?>" class='btn btn-info'>View All Tickets</a>
			  <a href='<?php echo $link;?>' <?php echo $disabled;?> <?php echo $style_click;?> class='btn btn-success'>Export Tickets</a>
			  </td>
      </tr>
      
      <?php endwhile; } ?>
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