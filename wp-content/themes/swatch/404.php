<?php
/**
 * Displays the themes 404 page
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
?>

<section class = "section section-slim text-center <?php echo oxy_get_option( '404_swatch' ); ?>">
    <img src="<?php echo oxy_get_option( '404_header_image' ); ?>">
</section>

<section class="section swatch-clouds">
    <div class="container">
        <?php get_template_part('partials/content', '404'); ?>
    </div>
</section>
<?php get_footer();
