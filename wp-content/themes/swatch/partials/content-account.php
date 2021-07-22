<?php
/**
 * Shows a woocommerce account page
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

?>
<section class="section section-commerce <?php echo apply_filters( 'oxy_woocommerce_shop_classes', 10 );?>">
    <div class="container">
        <?php wc_print_notices(); ?>
        <div class="row">
        <?php if( is_user_logged_in() ) : ?>
            <div class="span3">
                <?php get_template_part('woocommerce/myaccount/navigation'); ?>
            </div>
            <div class="span9">
                <?php the_content(); ?>
            </div>
        <?php else : ?>
            <div class="span12">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>
