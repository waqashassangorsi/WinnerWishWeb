<?php
/**
 * Displays a category list
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

get_header();
oxy_page_header( oxy_get_option('blog_header_swatch'), single_cat_title( '', false ), null, 'left');
?>
<section class="section <?php echo oxy_get_option('blog_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <?php get_template_part( 'partials/loop' ); ?>
        </div>
    </div>
</section>
<?php get_footer();