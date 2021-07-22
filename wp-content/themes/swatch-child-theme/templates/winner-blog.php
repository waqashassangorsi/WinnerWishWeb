<?php
/* Template Name: Winner Blog Template */
get_header();
if(isset($_GET['winner']) && is_numeric($_GET['winner'])){
	$post = $_GET['winner'];
?>
<style>
	.content_section{
	width:80%;
	margin:50px auto
	}
	.single_blog img{
	height:400px;
	}
</style>
<div class="container single_blog" style="margin-top:50px;margin-bottom:50px; ">
	<div style="border-bottom:1px solid gainsboro;">
	<img src="<?php echo get_the_post_thumbnail_url();?>" class="single_blog"  width="100%">
	<div class="content_section">
	<h2 class="text-center"> <?php echo get_the_title($post);?> </h2>
	<div>
		<p style='float:left'><b> Competition Name : </b><?php echo get_the_title(get_post_meta($post,'competitions',true)); ?></p>
		<p style='float:right'><b> Location : </b><?php echo get_post_meta($post,'location',true); ?></p>
	</div>
	<p style='clear:both'> <?php echo get_the_content($post); ?> </p>
	</div>
	</div>
	<p ><?php $prev_post = get_adjacent_post(false, '', true);
if(!empty($prev_post)) {
echo ' <a href="winner-blog/?winner=' . $prev_post->ID.'" style="float:left;background: #ec8783;color: white;margin: 16px 0px;padding: 2px 15px;"> << ' . $prev_post->post_title . '</a>'; } ?>   <?php $next_post = get_adjacent_post(false, '', false);
if(!empty($next_post)) {
echo '<a href="winner-blog/?winner='.$next_post->ID. '" style="float:right;background: #ec8783;color: white;margin: 16px 0px;padding: 2px 15px;">' . $next_post->post_title . ' >> </a>'; } ?> </p>





</div>


<?php }else{
 wp_redirect(home_url());
	exit;
} get_footer(); ?>