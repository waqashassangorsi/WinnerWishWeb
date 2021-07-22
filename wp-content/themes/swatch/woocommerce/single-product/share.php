<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$permalink = get_permalink($post->ID);
$featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
$featured_image_2 = $featured_image['0'];
$post_title = rawurlencode(get_the_title($post->ID));
?>
<?php if( oxy_get_option('product_social_icons') == 'on' ): ?>
<div class="product-share">
    <ul class="inline">
        <li><a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink ?>&amp;images=<?php echo $featured_image_2 ?>" target="_blank" data-toggle="tooltip" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>
        <li><a href="https://twitter.com/share?url=<?php echo $permalink ?>" target="_blank" data-toggle="tooltip" title="Share on Twitter"><i class="fa fa-twitter"></i></a></li>
        <li><a href="mailto:enteryour@addresshere.com?subject=<?php echo $post_title ?>&amp;body=Check%20this%20out:%20'<?php echo $permalink ?>" data-toggle="tooltip" title="Email to a Friend"><i class="fa fa-envelope"></i></a></li>
        <li><a href="//pinterest.com/pin/create/button/?url=<?php echo $permalink ?>&amp;media=<?php echo $featured_image_2 ?>&amp;description=<?php echo $post_title ?>" target="_blank" data-toggle="tooltip" title="Pin on Pinterest"><i class="fa fa-pinterest"></i></a></li>
    </ul>
</div>
<?php endif; ?>

<?php do_action('woocommerce_share'); // Sharing plugins can hook into here ?>